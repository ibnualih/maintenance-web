<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\MagneticPluck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class MagneticPluckController extends Controller
{
    public function approve($id)
    {
        $data = MagneticPluck::findOrFail($id);
        $data->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Data berhasil disetujui.');
    }

    public function reject($id)
    {
        $data = MagneticPluck::findOrFail($id);
        // $data->update(['status' => 'rejected']);

        // Hapus data
        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil ditolak.');
    }

    public function resume(Request $request)
    {
        $currentRouteName = \Route::currentRouteName();

        // Get unique ratings for dropdown
        $uniqueRatings = MagneticPluck::select('rating')->distinct()->pluck('rating');
        // Get unique ratings for dropdown
        $uniqueComponents = MagneticPluck::select('component')->distinct()->pluck('component');

        // Ambil data yang berstatus 'approved'
        $approvedData = MagneticPluck::query()
        ->with('user')
        ->where('status', 'approved')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        // Hitung nomor awal untuk halaman saat ini
        $startNumber = ($approvedData->currentPage() - 1) * $approvedData->perPage();

        // Ambil data MagneticPluck
        $data = MagneticPluck::select('unit_model', 'unit_code', 'rating')->get();

        // Hitung total data berdasarkan rating
        $ratingSummary = $data->groupBy('rating')->map(fn($item) => $item->count());

        // Ambil daftar rating unik dari kolom 'rating'
        $ratings = MagneticPluck::select('rating')->distinct()->pluck('rating')->toArray();

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

        return view('pages.magnetic_plucks.resume', compact('ratingSummary', 'charts', 'approvedData', 'startNumber', 'uniqueComponents', 'currentRouteName', 'uniqueRatings'));
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
        $component = $request->input('component');
        $status = $request->input('status');

        $magneticPlugs = MagneticPluck::with('user');

        if (auth()->user()->hasRole('mekanik')) {
            $magneticPlugs->where('user_id', auth()->id());
        }

        // Filter untuk pencarian
        if ($search) {
            $magneticPlugs->where(function ($q) use ($search) {
                $q->where('unit_model', 'like', "%$search%")
                  ->orWhere('unit_code', 'like', "%$search%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%$search%");
                  });
            });
        }

        //Filter untuk component
        if ($component) {
            $magneticPlugs->where('component', $component);
        }

        //Filter untuk rating
        if ($rating) {
            $magneticPlugs->where('rating', $rating);
        }

        //Filter untuk status
        if ($status) {
            $magneticPlugs->where('status', $status);
        }

        // Sorting berdasarkan kolom ed
        if ($request->has('sort_ed') && in_array($request->sort_ed, ['asc', 'desc'])) {
            $magneticPlugs->orderBy('ed', $request->sort_ed);
        }

        $magneticPlugs->orderBy('created_at', 'desc');
        $magneticPlugs = $magneticPlugs->paginate(10);

        // Hitung nomor awal untuk halaman saat ini
        $startNumber = ($magneticPlugs->currentPage() - 1) * $magneticPlugs->perPage();

        // Get unique ratings for dropdown
        $uniqueComponents = MagneticPluck::select('component')->distinct()->pluck('component');

        // Get unique ratings for dropdown
        $uniqueRatings = MagneticPluck::select('rating')->distinct()->pluck('rating');

        return view('pages.magnetic_plucks.index', compact('magneticPlugs', 'uniqueRatings', 'uniqueComponents', 'currentRouteName', 'startNumber', 'status'));
    }


    public function create()
    {
        $unitModels = Unit::select('unit')->distinct()->get();
        $allUnits = Unit::all(); // Untuk dropdown dinamis
        return view('pages.magnetic_plucks.create', compact('unitModels', 'allUnits'));
    }

    public function store(Request $request)
    {

        // dd($request->all());

        $validated = $request->validate([
            'unit_model' => 'required|string|max:255',
            'unit_code' => 'required|string|max:255',
            'hm' => 'required|integer',
            'last_update' => 'required|date_format:d-m-Y',
            'component' => 'required|string|max:255',
            'rating' => 'required|string|max:255',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = auth()->user()->hasRole(['admin', 'supervisor']) ? 'approved' : 'pending';

        // dd($validated);

        if ($request->hasFile('picture')) {
            $validated['picture'] = $request->file('picture')->store('pictures', 'public');
        }

        // Validasi hubungan Unit Model dan Component
        $componentsMap = [
            'PC2000-8' => ['Final Drive LH', 'Final Drive RH'],
            'PC1250-8' => ['Final Drive LH', 'Final Drive RH'],
            'PC850-8'  => ['Final Drive LH', 'Final Drive RH'],
            'D155-6R'  => ['Final Drive LH', 'Final Drive RH'],
            'HD785-7'  => ['Final Drive LH', 'Final Drive RH', 'Differential'],
            'GD825-2'  => ['Differential'],
            'GD755-5'  => ['Differential'],
        ];

        $unitModel = $request->input('unit_model');
        $component = $request->input('component');

        if (!in_array($component, $componentsMap[$unitModel] ?? [])) {
            return redirect()->back()->withErrors(['component' => 'Invalid component for selected unit model.']);
        }

        MagneticPluck::create($validated);

        return redirect()->route('magnetic_plucks.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit(MagneticPluck $magneticPluck)
    {
        $unitModels = Unit::select('unit')->distinct()->get(); // Ambil unit model unik
        $allUnits = Unit::all(); // Ambil semua unit untuk dropdown dinamis

        return view('pages.magnetic_plucks.edit', compact('magneticPluck', 'unitModels', 'allUnits'));
    }


    public function update(Request $request, MagneticPluck $magneticPluck)
    {
        $validated = $request->validate([
            'unit_model' => 'required|string|max:255',
            'unit_code' => 'required|string|max:255',
            'hm' => 'required|integer',
            'last_update' => 'required|date',
            'component' => 'required|string|max:255',
            'rating' => 'required|string|max:255',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('picture')) {
            Storage::disk('public')->delete($magneticPluck->picture);
            $validated['picture'] = $request->file('picture')->store('pictures', 'public');
        }

        $magneticPluck->update($validated);

        return redirect()->route('magnetic_plucks.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy(MagneticPluck $magneticPluck)
    {
        if ($magneticPluck->picture) {
            Storage::disk('public')->delete($magneticPluck->picture);
        }

        $magneticPluck->delete();
        return redirect()->route('magnetic_plucks.index')->with('success', 'Data berhasil dihapus');
    }
}
