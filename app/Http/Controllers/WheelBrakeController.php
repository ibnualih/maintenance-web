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
        $query = WheelBrake::query()
            ->with('user')
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc');


        // Filter berdasarkan Unit Code
        if ($request->filled('unit_code')) {
            $query->where('unit_code', 'like', '%' . $request->unit_code . '%');
        }

        // Ambil data dari database
        $approvedData = $query->paginate(10);

        // Hitung `ED` secara dinamis
        $approvedData->getCollection()->transform(function ($item) {
            // ED dihitung sebagai selisih hari antara last_update dan hari ini
            $item->ed = $item->last_date ? now()->diffInDays($item->last_date) : null;
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

        // Ambil daftar unit_model dan unit_code unik untuk filter dropdown
        // $uniqueUnitModels = WheelBrake::select('unit_model')->distinct()->pluck('unit_model');
        $uniqueUnitCodes = WheelBrake::select('unit_code')->distinct()->pluck('unit_code');

        return view('pages.wheel_brakes.resume', compact(
            'approvedData',
            'startNumber',
            'currentRouteName',
            'uniqueUnitCodes'
        ));
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
            'rlh_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'lrh_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'llh_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data['user_id'] = auth()->id();
        $data['status'] = auth()->user()->hasRole(['admin', 'supervisor']) ? 'approved' : 'pending';

        if ($request->hasFile('picture')) {
            $data['picture'] = $request->file('picture')->store('pictures', 'public');
        }
        if ($request->hasFile('rlh_picture')) {
            $data['rlh_picture'] = $request->file('rlh_picture')->store('pictures', 'public');
        }
        if ($request->hasFile('lrh_picture')) {
            $data['lrh_picture'] = $request->file('lrh_picture')->store('pictures', 'public');
        }
        if ($request->hasFile('llh_picture')) {
            $data['llh_picture'] = $request->file('llh_picture')->store('pictures', 'public');
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
            'rlh_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'lrh_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'llh_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('picture')) {
            $data['picture'] = $request->file('picture')->store('pictures', 'public');
        }
        if ($request->hasFile('rlh_picture')) {
            $data['rlh_picture'] = $request->file('rlh_picture')->store('pictures', 'public');
        }
        if ($request->hasFile('lrh_picture')) {
            $data['lrh_picture'] = $request->file('lrh_picture')->store('pictures', 'public');
        }
        if ($request->hasFile('llh_picture')) {
            $data['llh_picture'] = $request->file('llh_picture')->store('pictures', 'public');
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
