<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\SwingCircle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class SwingCircleController extends Controller
{
    public function approve($id)
    {
        $data = SwingCircle::findOrFail($id);
        $data->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Data berhasil disetujui.');
    }

    public function reject($id)
    {
        $data = SwingCircle::findOrFail($id);

        // Hapus data
        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil ditolak.');
    }

    public function resume(Request $request)
    {
        $currentRouteName = \Route::currentRouteName();

        // Ambil data yang berstatus 'approved'
        $query = SwingCircle::query()
            ->with('user')
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc');

        // Filter berdasarkan Unit Model
        if ($request->filled('unit_model')) {
            $query->where('unit_model', 'like', '%' . $request->unit_model . '%');
        }

        // Filter berdasarkan Unit Code
        if ($request->filled('unit_code')) {
            $query->where('unit_code', 'like', '%' . $request->unit_code . '%');
        }

        // Ambil data dari database
        $approvedData = $query->paginate(10);

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

        // Ambil unit_model dan unit_code unik untuk filter dropdown
        $uniqueUnitModels = SwingCircle::select('unit_model')->distinct()->pluck('unit_model');
        $uniqueUnitCodes = SwingCircle::select('unit_code')->distinct()->pluck('unit_code');

        return view('pages.swing_circles.resume', compact(
            'approvedData',
            'startNumber',
            'currentRouteName',
            'uniqueUnitModels',
            'uniqueUnitCodes'
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
        $unit_model = $request->input('unit_model');
        $status = $request->input('status');

        $swingCircles = SwingCircle::query()->with('user');

        if (auth()->user()->hasRole('mekanik')) {
            $swingCircles->where('user_id', auth()->id());
        }

        if ($status) {
            $swingCircles->where('status', $status);
        }

        if ($search) {
            $swingCircles->where('unit_model', 'like', "%$search%")
                          ->orWhere('unit_code', 'like', "%$search%");
        }

        // Sorting berdasarkan ED
        if ($request->has('sort_ed') && in_array($request->sort_ed, ['asc', 'desc'])) {
            $swingCircles = $swingCircles->get()->sortBy('ed', SORT_REGULAR, $request->sort_ed === 'desc');
        } else {
            $swingCircles = $swingCircles->paginate(10);
        }

        //Filter untuk rating
        if ($unit_model) {
            $swingCircles->where('unit_model', $unit_model);
        }

        // Hitung nomor awal untuk halaman saat ini
        $startNumber = ($swingCircles->currentPage() - 1) * $swingCircles->perPage();

        // Get unique ratings for dropdown
        $unitModels = SwingCircle::select('unit_model')->distinct()->pluck('unit_model');

        // $swingCircles->orderBy('created_at', 'desc');
        $swingCircles = SwingCircle::paginate(10);

        return view('pages.swing_circles.index', compact('swingCircles', 'unitModels', 'currentRouteName', 'startNumber', 'status'));
    }

    public function create()
    {
        $unitModels = Unit::where('type', 'Exca')->select('unit')->distinct()->get();

        $allUnits = Unit::select('unit', 'code_unit')->get();
        return view('pages.swing_circles.create', compact('unitModels', 'allUnits'));
        // dd($unitModels ,$allUnits);
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'unit_model' => 'required|string',
            'unit_code' => 'required|string',
            'hm' => 'required|integer',
            'last_update' => 'required|date',
            'peak_value' => 'required|numeric',
            'front_value' => 'required|numeric',
            'front_picture' => 'nullable|image',
            'rear_value' => 'required|numeric',
            'rear_picture' => 'nullable|image',
            'level_grease_picture' => 'nullable|image',
        ]);

        $data['user_id'] = auth()->id();
        $data['status'] = auth()->user()->hasRole(['admin', 'supervisor']) ? 'approved' : 'pending';

        // Upload images if exist
        if ($request->hasFile('front_picture')) {
            $data['front_picture'] = $request->file('front_picture')->store('pictures', 'public');
        }
        if ($request->hasFile('rear_picture')) {
            $data['rear_picture'] = $request->file('rear_picture')->store('pictures', 'public');
        }
        if ($request->hasFile('level_grease_picture')) {
            $data['level_grease_picture'] = $request->file('level_grease_picture')->store('pictures', 'public');
        }

        SwingCircle::create($data);

        return redirect()->route('swing_circles.index')->with('success', 'Data added successfully.');
    }

    public function edit(swingCircle $swingCircle)
    {
        // dd($swingCircle);
        // $swingCircle = SwingCircle::findOrFail($id);
        $unitModels = Unit::where('type', 'Exca')->select('unit')->distinct()->pluck('unit');
        $allUnits = Unit::select('unit', 'code_unit')->get();
        return view('pages.swing_circles.edit', compact('swingCircle', 'unitModels', 'allUnits'));
    }


    public function update(Request $request, $id)
    {
        $swingCircle = SwingCircle::findOrFail($id);

        $data = $request->validate([
            'unit_model' => 'required|string',
            'unit_code' => 'required|string',
            'hm' => 'required|integer',
            'last_update' => 'required|date',
            'peak_value' => 'required|numeric',
            'front_value' => 'required|numeric',
            'front_picture' => 'nullable|image',
            'rear_value' => 'required|numeric',
            'rear_picture' => 'nullable|image',
            'level_grease_picture' => 'nullable|image',
        ]);

        if ($request->hasFile('front_picture')) {
            $data['front_picture'] = $request->file('front_picture')->store('pictures', 'public');
        }
        if ($request->hasFile('rear_picture')) {
            $data['rear_picture'] = $request->file('rear_picture')->store('pictures', 'public');
        }
        if ($request->hasFile('level_grease_picture')) {
            $data['level_grease_picture'] = $request->file('level_grease_picture')->store('pictures', 'public');
        }

        $swingCircle->update($data);
        return redirect()->route('swing_circles.index')->with('success', 'Data updated successfully.');
    }

    public function destroy(SwingCircle $swingCircle)
    {
        if ($swingCircle->picture) {
            Storage::disk('public')->delete($swingCircle->picture);
        }

        $swingCircle->delete();
        return redirect()->route('swing_circles.index')->with('success', 'Data deleted successfully.');
    }

}
