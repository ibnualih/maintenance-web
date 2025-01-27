<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\WheelBrake;
use Illuminate\Http\Request;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class WheelBrakeController extends Controller
{
    public function approve($id)
    {
        $data = WheelBrake::findOrFail($id);
        $data->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Data berhasil disetujui.');
    }

    public function reject($id)
    {
        $data = WheelBrake::findOrFail($id);
        // $data->update(['status' => 'rejected']);

        // Hapus data
        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil ditolak.');
    }

    public function resume(Request $request)
    {
        $currentRouteName = \Route::currentRouteName();

        // Ambil data yang berstatus 'approved'
        $approvedData = WheelBrake::query()
        ->with('user')
        ->where('status', 'approved')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        // Hitung nomor awal untuk halaman saat ini
        $startNumber = ($approvedData->currentPage() - 1) * $approvedData->perPage();

        // // Ambil data MagneticPluck
        // $data = WheelBrake::select('unit_model', 'unit_code', 'rating')->get();

        // // Hitung total data berdasarkan rating
        // $ratingSummary = $data->groupBy('rating')->map(fn($item) => $item->count());

        // // Ambil daftar rating unik dari kolom 'rating'
        // $ratings = MagneticPluck::select('rating')->distinct()->pluck('rating')->toArray();

        // // Kelompokkan data berdasarkan unit_model
        // $groupedData = $data->groupBy('unit_model');

        // // Membuat bar chart untuk setiap unit_model
        // $charts = [];
        // foreach ($groupedData as $unitModel => $units) {
        //     // Labels: unit_code
        //     $labels = $units->pluck('unit_code')->unique()->toArray();

        //     // Data untuk setiap rating
        //     $chartData = [];
        //     foreach ($ratings as $rating) {
        //         $chartData[] = array_map(
        //             fn($codeUnit) => $units->where('unit_code', $codeUnit)->where('rating', $rating)->count() ?: 0,
        //             $labels
        //         );
        //     }

        //     // Jika tidak ada data untuk chart, skip iterasi
        //     if (empty($labels) || empty($chartData)) {
        //         continue;
        //     }

        //     // Membuat dataset untuk LarapexChart
        //     $dataset = [];
        //     foreach ($ratings as $index => $rating) {
        //         $dataset[] = [
        //             'name' => $rating,
        //             'data' => $chartData[$index] ?? [],
        //         ];
        //     }

        //     // Buat chart
        //     $chart = (new LarapexChart)
        //         ->barChart()
        //         ->setTitle("Rating Distribution for $unitModel")
        //         ->setSubtitle("Ratings: " . implode(', ', $ratings))
        //         ->setXAxis($labels) // Labels berupa unit_code
        //         ->setColors(['#FF5733', '#FFC300', '#DAF7A6', '#C70039', '#900C3F'])
        //         ->setDataset($dataset);

        //     $charts[$unitModel] = $chart;
        // }

        return view('pages.wheel_brakes.resume', compact( 'approvedData', 'startNumber',  'currentRouteName'));
    }

    public function index(Request $request)
    {
        $currentRouteName = \Route::currentRouteName();
        $search = $request->input('search');
        $status = $request->input('status');

        $wheelBrakes = WheelBrake::query()->with('user');

        if (auth()->user()->hasRole('mekanik')) {
            $wheelBrakes->where('user_id', auth()->id());
        }

        if ($search) {
            $wheelBrakes->where('unit_code', 'like', "%$search%");
        }

        if ($status) {
            $wheelBrakes->where('status', $status);
        }

        // Sorting berdasarkan kolom ed
        if ($request->has('sort_ed') && in_array($request->sort_ed, ['asc', 'desc'])) {
            $wheelBrakes->orderBy('ed', $request->sort_ed);
        }

        $wheelBrakes->orderBy('created_at', 'desc');
        $wheelBrakes = $wheelBrakes->paginate(10);
        // Hitung nomor awal untuk halaman saat ini
        $startNumber = ($wheelBrakes->currentPage() - 1) * $wheelBrakes->perPage();

        return view('pages.wheel_brakes.index', compact('wheelBrakes', 'startNumber', 'currentRouteName', 'status'));
    }

    public function create()
    {
        $units = Unit::where('type', 'HEAVY DUMPTRUCK')->get(); // Assuming you have a Unit model for unit_code dropdown
        return view('pages.wheel_brakes.create', compact('units'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'unit_code' => 'required|string',
            'hm' => 'required|integer',
            'last_date' => 'required|date',
            'flh_rgauge' => 'required|numeric',
            'flh_tbase' => 'required|numeric',
            'frh_rgauge' => 'required|numeric',
            'frh_tbase' => 'required|numeric',
            'rlh_rgauge' => 'required|numeric',
            'rlh_tbase' => 'required|numeric',
            'rrh_rgauge' => 'required|numeric',
            'rrh_tbase' => 'required|numeric',
            'picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data['user_id'] = auth()->id();
        $data['status'] = auth()->user()->hasRole(['admin', 'supervisor']) ? 'approved' : 'pending';

        if ($request->hasFile('picture')) {
            $data['picture'] = $request->file('picture')->store('pictures', 'public');
        }

        WheelBrake::create($data);

        return redirect()->route('wheel-brakes.index')->with('success', 'Wheel Brake created successfully!');
    }

    public function edit(WheelBrake $wheelBrake)
    {
        $units = Unit::all();
        return view('pages.wheel_brakes.edit', compact('wheelBrake', 'units'));
    }

    public function update(Request $request, WheelBrake $wheelBrake)
    {
        $data = $request->validate([
            'unit_code' => 'required|string',
            'hm' => 'required|integer',
            'ed' => 'required|integer',
            'last_date' => 'required|date',
            'flh_rgauge' => 'nullable|numeric',
            'flh_tbase' => 'nullable|numeric',
            'frh_rgauge' => 'nullable|numeric',
            'frh_tbase' => 'nullable|numeric',
            'rlh_rgauge' => 'nullable|numeric',
            'rlh_tbase' => 'nullable|numeric',
            'rrh_rgauge' => 'nullable|numeric',
            'rrh_tbase' => 'nullable|numeric',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('picture')) {
            $data['picture'] = $request->file('picture')->store('pictures', 'public');
        }

        $wheelBrake->update($data);

        return redirect()->route('wheel-brakes.index')->with('success', 'Wheel Brake updated successfully!');
    }

    public function destroy(WheelBrake $wheelBrake)
    {
        if ($wheelBrake->picture) {
            \Storage::disk('public')->delete($wheelBrake->picture);
        }

        $wheelBrake->delete();

        return redirect()->route('wheel-brakes.index')->with('success', 'Wheel Brake deleted successfully!');
    }
}
