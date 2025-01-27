<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Strainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class StrainerController extends Controller
{
    public function approve($id)
    {
        $data = Strainer::findOrFail($id);
        $data->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Data berhasil disetujui.');
    }

    public function reject($id)
    {
        $data = Strainer::findOrFail($id);
        // $data->update(['status' => 'rejected']);

        // Hapus data
        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil ditolak.');
    }

    public function resume()
    {
        $currentRouteName = \Route::currentRouteName();
        // Get unique ratings for dropdown
        $uniqueRatings = Strainer::select('rating')->distinct()->pluck('rating');
        // Get unique ratings for dropdown
        $uniqueComponents = Strainer::select('component')->distinct()->pluck('component');

        // Ambil data yang berstatus 'approved'
        $approvedData = Strainer::query()
        ->with('user')
        ->where('status', 'approved')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        // Hitung nomor awal untuk halaman saat ini
        $startNumber = ($approvedData->currentPage() - 1) * $approvedData->perPage();

        // Ambil data Strainer
        $data = Strainer::select('unit_model', 'unit_code', 'rating')->get();

        // Hitung total data berdasarkan rating
        $ratingSummary = $data->groupBy('rating')->map(fn($item) => $item->count());

        // Ambil daftar rating unik dari kolom 'rating'
        $ratings = Strainer::select('rating')->distinct()->pluck('rating')->toArray();

        // Kelompokkan data berdasarkan unit_model
        $groupedData = $data->groupBy('unit_model');

        // Membuat bar chart untuk setiap unit_model
        $charts = [];
        foreach ($groupedData as $unitModel => $units) {
            // Labels: unit_code
            $labels = $units->pluck('unit_code')->unique()->toArray();

            // Data untuk setiap rating
            $chartData = [];
            foreach ($ratings as $rating) {
                $chartData[] = array_map(
                    fn($codeUnit) => $units->where('unit_code', $codeUnit)->where('rating', $rating)->count() ?: 0,
                    $labels
                );
            }

            // Jika tidak ada data untuk chart, skip iterasi
            if (empty($labels) || empty($chartData)) {
                continue;
            }

            // Membuat dataset untuk LarapexChart
            $dataset = [];
            foreach ($ratings as $index => $rating) {
                $dataset[] = [
                    'name' => $rating,
                    'data' => $chartData[$index] ?? [],
                ];
            }

            // Buat chart
            $chart = (new LarapexChart)
                ->barChart()
                ->setTitle("Rating Distribution for $unitModel")
                ->setSubtitle("Ratings: " . implode(', ', $ratings))
                ->setXAxis($labels) // Labels berupa unit_code
                ->setColors(['#FF5733', '#FFC300', '#DAF7A6', '#C70039', '#900C3F'])
                ->setDataset($dataset);

            $charts[$unitModel] = $chart;
        }

        return view('pages.strainer.resume', compact('ratingSummary', 'charts', 'approvedData', 'startNumber', 'uniqueComponents', 'currentRouteName', 'uniqueRatings'));
    }

    public function getUnitCodes($unitModel)
    {
        $unitCodes = Unit::where('unit', $unitModel)->pluck('code_unit');

        if ($unitCodes->isEmpty()) {
            return response()->json(['unitCodes' => [], 'message' => 'No unit codes found'], 404);
        }

        return response()->json(['unitCodes' => $unitCodes]);
    }

    public function index(Request $request)
    {
        $currentRouteName = \Route::currentRouteName(); // Nama route aktif
        $search = $request->input('search');
        $rating = $request->input('rating');
        $unit_model = $request->input('unit_model');
        $status = $request->input('status');

        $strainers = Strainer::query()->with('user');

        if (auth()->user()->hasRole('mekanik')) {
            $strainers->where('user_id', auth()->id());
        }

        // Filter berdasarkan kolom pencarian
        if ($search) {
            $strainers->where(function ($query) use ($search) {
                $query->where('unit_model', 'like', "%$search%")
                    ->orWhere('unit_code', 'like', "%$search%")
                    ->orWhere('rating', 'like', "%$search%");
            });
        }

        // Filter berdasarkan status
        if ($status) {
            $strainers->where('status', $status);
        }

        // Sorting berdasarkan kolom ed
        if ($request->has('sort_ed') && in_array($request->sort_ed, ['asc', 'desc'])) {
            $strainers->orderBy('ed', $request->sort_ed);
        }
        //Filter untuk rating
        if ($rating) {
            $strainers->where('rating', $rating);
        }

        $strainers->orderBy('created_at', 'desc');
        $strainers = $strainers->paginate(10);

        // Hitung nomor awal untuk halaman saat ini
        $startNumber = ($strainers->currentPage() - 1) * $strainers->perPage();

        // Get unique ratings for dropdown
        $uniqueRatings = Strainer::select('rating')->distinct()->pluck('rating');

        // Get unique ratings for dropdown
        $unitModels = Strainer::select('unit_model')->distinct()->pluck('unit_model');

        return view('pages.strainer.index', compact('strainers', 'uniqueRatings', 'unitModels', 'currentRouteName', 'startNumber', 'status'));
    }

    public function create()
    {
        // Ambil data unit model unik dari tabel units
        $unitModels = Unit::select('unit')->distinct()->get();

        // Ambil semua data unit untuk JavaScript filtering pada unit_code
        $allUnits = Unit::all();

        return view('pages.strainer.create', compact('unitModels', 'allUnits'));
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit_model' => 'required|string|max:255',
            'unit_code' => 'required|string|max:255',
            'hm' => 'required|integer',
            'last_update' => 'required|date',
            'rating' => 'required|string|max:255',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $validated['status'] = auth()->user()->hasRole(['admin', 'supervisor']) ? 'approved' : 'pending';
        $validated['user_id'] = auth()->id();

        // Set default component to "Transmission"
        $validated['component'] = 'Transmission';

        // Handle picture upload if exists
        if ($request->hasFile('picture')) {
            $validated['picture'] = $request->file('picture')->store('pictures', 'public');
        }

        Strainer::create($validated);

        return redirect()->route('strainer.index')->with('success', 'Strainer data added successfully.');
    }

    public function edit(Strainer $strainer)
    {
        // Ambil data unit model unik dari tabel units
        $unitModels = Unit::select('unit')->distinct()->get();
        // Ambil semua data unit untuk JavaScript filtering pada unit_code
        $allUnits = Unit::all();

        return view('pages.strainer.edit', compact('strainer', 'unitModels', 'allUnits'));
    }

    public function update(Request $request, Strainer $strainer)
    {
        $validated = $request->validate([
            'unit_model' => 'required|string|max:255',
            'unit_code' => 'required|string|max:255',
            'hm' => 'required|integer',
            'last_update' => 'required|date',
            'rating' => 'required|string|max:255',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle picture upload if exists
        if ($request->hasFile('picture')) {
            // Hapus gambar lama jika ada dan path valid
            if ($strainer->picture && Storage::disk('public')->exists($strainer->picture)) {
                Storage::disk('public')->delete($strainer->picture);
            }

            // Simpan gambar baru
            $validated['picture'] = $request->file('picture')->store('pictures', 'public');
        }

        // Update dengan data tervalidasi
        $strainer->update($validated);

        return redirect()->route('strainer.index')->with('success', 'Strainer data updated successfully.');
    }


    public function destroy(Strainer $strainer)
    {
        if ($strainer->picture) {
            Storage::disk('public')->delete($strainer->picture);
        }

        $strainer->delete();
        return redirect()->route('strainer.index')->with('success', 'Strainer data deleted successfully.');
    }
}

