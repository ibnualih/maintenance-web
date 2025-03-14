<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\CuttingFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class CuttingFilterController extends Controller
{
    public function approve($id)
    {
        $data = CuttingFilter::findOrFail($id);
        $data->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Data berhasil disetujui.');
    }

    public function reject($id)
    {
        $data = CuttingFilter::findOrFail($id);

        // Hapus data
        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil ditolak.');
    }

    public function resume(Request $request)
    {
        $currentRouteName = \Route::currentRouteName();

        // Get unique ratings for dropdown
        $uniqueRatings = CuttingFilter::select('rating')->distinct()->pluck('rating');
        // Get unique components for dropdown
        $uniqueComponents = CuttingFilter::select('component')->distinct()->pluck('component');

        // Ambil data yang berstatus 'approved' dan lakukan filter jika ada request
        $approvedDataQuery = CuttingFilter::query()
            ->with('user')
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc');

        // Filter berdasarkan Unit Model
        if ($request->filled('unit_model')) {
            $approvedDataQuery->where('unit_model', 'like', '%' . $request->unit_model . '%');
        }

        // Filter berdasarkan Unit Code
        if ($request->filled('unit_code')) {
            $approvedDataQuery->where('unit_code', 'like', '%' . $request->unit_code . '%');
        }

        // Ambil data dari database
        $approvedData = $approvedDataQuery->paginate(10);

        // Hitung `ED` secara dinamis
        $approvedData->getCollection()->transform(function ($item) {
            // ED dihitung sebagai selisih hari antara last_update dan hari ini
            $item->ed = $item->last_update ? now()->diffInDays($item->last_update) : null;
            return $item;
        });

        // Sorting secara manual berdasarkan `ED`
        if ($request->has('sort_ed') && in_array($request->sort_ed, ['asc', 'desc'])) {
            $approvedData = $approvedData->setCollection(
                $approvedData->getCollection()->sortBy('ed', SORT_REGULAR, $request->sort_ed === 'desc')
            );
        }

        // Hitung nomor awal untuk halaman saat ini
        $startNumber = ($approvedData->currentPage() - 1) * $approvedData->perPage();

        // Ambil data CuttingFilter
        $data = CuttingFilter::select('unit_model', 'unit_code', 'rating')->get();

        // Hitung total data berdasarkan rating
        $ratingSummary = $data->groupBy('rating')->map(fn($item) => $item->count());

        // Ambil daftar rating unik dari kolom 'rating'
        $ratings = CuttingFilter::select('rating')->distinct()->pluck('rating')->toArray();

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
                    fn($codeUnit) => $units->where('unit_code', $codeUnit)->where('rating', $rating)->count(),
                    $labels
                );
            }

            // Jika tidak ada data untuk chart, skip iterasi
            if (empty($labels) || empty($chartData)) {
                continue;
            }

            // Buat chart
            $chart = (new LarapexChart)
                ->barChart()
                ->setTitle("Rating Distribution for $unitModel")
                ->setSubtitle("Ratings: " . implode(', ', $ratings))
                ->setXAxis($labels) // Labels berupa unit_code
                ->setColors(['#FF5733', '#FFC300', '#DAF7A6', '#C70039', '#900C3F'])
                ->setDataset(array_map(fn($index) => [
                    'name' => $ratings[$index],
                    'data' => $chartData[$index] ?? [],
                ], array_keys($ratings)));

            $charts[$unitModel] = $chart;
        }

        return view('pages.cutting_filters.resume', compact(
            'ratingSummary', 'charts', 'approvedData', 'uniqueRatings',
            'uniqueComponents', 'currentRouteName', 'startNumber'
        ));
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

        $cuttingFilter = CuttingFilter::query()->with('user');

        // Filter berdasarkan status
        if ($status) {
            $cuttingFilter->where('status', $status);
        }
        // Filter berdasarkan kolom pencarian
        if($search) {
            $cuttingFilter->where(function($query) use ($search) {
                $query->where('unit_model', 'like', "%$search%")
                    ->orWhere('unit_code', 'like', "%$search%")
                    ->orWhere('hm', 'like', "%$search%")
                    ->orWhere('rating', 'like', "%$search%");
            });
        }

        // Sorting berdasarkan kolom ed
        if ($request->has('sort_ed') && in_array($request->sort_ed, ['asc', 'desc'])) {
            $cuttingFilter->orderBy('ed', $request->sort_ed);
        }
        //Filter untuk rating
        if ($rating) {
            $cuttingFilter->where('rating', $rating);
        }
        //Filter untuk rating
        if ($unit_model) {
            $cuttingFilter->where('unit_model', $unit_model);
        }

        $cuttingFilter->orderBy('created_at', 'desc');
        $cuttingFilter = $cuttingFilter->paginate(10);
        // Hitung nomor awal untuk halaman saat ini
        $startNumber = ($cuttingFilter->currentPage() - 1) * $cuttingFilter->perPage();

        // Get unique ratings for dropdown
        $uniqueRatings = CuttingFilter::select('rating')->distinct()->pluck('rating');

        // Get unique ratings for dropdown
        $unitModels = CuttingFilter::select('unit_model')->distinct()->pluck('unit_model');

        return view('pages.cutting_filters.index', compact('cuttingFilter', 'uniqueRatings', 'unitModels', 'currentRouteName', 'startNumber', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $unitModels = Unit::select('unit')->distinct()->get();
        $allUnits = Unit::all(); // Untuk dropdown dinamis
        return view('pages.cutting_filters.create', compact('unitModels','allUnits'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit_model' => 'required|string|max:255',
            'unit_code' => 'required|string|max:255',
            'hm' => 'required|integer',
            'last_update' => 'required|date',
            'rating' => 'required|string|max:255',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'unit_model.required' => 'Unit Model harus diisi.',
            'unit_code.required' => 'Unit Code harus diisi.',
            'hm.required' => 'HM harus diisi.',
            'last_update.required' => 'Last Update harus diisi.',
            'rating.required' => 'Rating harus diisi.',
            'picture.image' => 'File Picture harus berupa gambar.',
            'picture.mimes' => 'File Picture hanya boleh dalam format: jpeg, png, jpg.',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = auth()->user()->hasRole(['admin', 'supervisor']) ? 'approved' : 'pending';

        // Set default component to "Engine"
        $validated['component'] = 'Engine';

        // Handle picture upload if exists
        if ($request->hasFile('picture')) {
            $validated['picture'] = $request->file('picture')->store('pictures', 'public');
        }

        CuttingFilter::create($validated);

        return redirect()->route('cutting_filters.index')->with('success', 'Cutting Filter created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CuttingFilter $cuttingFilter)
    {
        $unitModels = Unit::select('unit')->distinct()->get();
        $allUnits = Unit::all(); // Untuk dropdown dinamis
        return view('pages.cutting_filters.edit', compact('cuttingFilter', 'unitModels', 'allUnits'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CuttingFilter $cuttingFilter)
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
            // Hapus gambar lama jika ada
            if ($cuttingFilter->picture) {
                Storage::disk('public')->delete($cuttingFilter->picture);
            }
            // Simpan gambar baru dan perbarui validated data
            $validated['picture'] = $request->file('picture')->store('pictures', 'public');
        }

        // Update cutting filter dengan data yang sudah tervalidasi
        $cuttingFilter->update($validated);

        return redirect()->route('cutting_filters.index')->with('success', 'Cutting Filter updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CuttingFilter $cuttingFilter)
    {
        // Delete picture file if exists
        if ($cuttingFilter->picture) {
            Storage::disk('public')->delete($cuttingFilter->picture);
        }

        $cuttingFilter->delete();

        return redirect()->route('cutting_filters.index')->with('success', 'Cutting Filter deleted successfully.');
    }
}
