<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Vhms;
use App\Imports\hd785Import;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class VhmsController extends Controller
{
    public function index(Request $request)
    {
        $vhmsData = Vhms::query();

        $currentRouteName = \Route::currentRouteName(); // Nama route aktif
        // $search = $request->input('search');
        $unit_code = $request->input('unit_code');

        // if ($search) {
        //     $magneticPlugs->where('unit_model', 'like', "%$search%")
        //                   ->orWhere('unit_code', 'like', "%$search%");
        // }
        // Sorting berdasarkan kolom ed
        // if ($request->has('sort_ed') && in_array($request->sort_ed, ['asc', 'desc'])) {
        //     $magneticPlugs->orderBy('ed', $request->sort_ed);
        // }
        //Filter untuk rating
        // if ($rating) {
        //     $magneticPlugs->where('rating', $rating);
        // }
        //Filter untuk rating
        if ($unit_code) {
            $vhmsData->where('code', $unit_code);
        }


        $unitCodes = Vhms::select('code')->distinct()->pluck('code');

        // Ambil list unit unik dari database
        // $units = VHMS::select('code')->distinct()->pluck('code');

        $vhmsPage = $vhmsData->paginate(10);

        // Filter data berdasarkan unit yang dipilih
        $selectedUnit = $request->get('code');
        $vhmsData = VHMS::when($selectedUnit, function ($query, $unit) {
            return $query->where('code', $unit);
        })->get();

        return view('pages.vhms.index', compact( 'selectedUnit', 'unitCodes', 'vhmsData', 'vhmsPage', 'currentRouteName'));
    }


    // Route tambahan untuk AJAX request
    // public function getSerialNumber(Request $request)
    // {
    //     // Ambil serial number berdasarkan code_unit
    //     $serialNumber = Unit::where('code_unit', $request->code_unit)
    //                         ->value('serial_number');

    //     return response()->json(['serial_number' => $serialNumber]);
    // }
    public function getSerialNumber(Request $request)
    {
        try {
            $codeUnit = $request->query('code_unit');

            // Validasi apakah code_unit dikirim
            if (!$codeUnit) {
                return response()->json(['error' => 'Code unit is required'], 400);
            }

            // Ambil data dari database berdasarkan code_unit
            $unit = Unit::where('code_unit', $codeUnit)->first();

            // Jika unit tidak ditemukan
            if (!$unit) {
                return response()->json(['error' => 'Unit not found'], 404);
            }

            // Kembalikan data serial number dalam JSON
            return response()->json([
                'serial_number' => $unit->serial_number,
            ]);

        } catch (\Exception $e) {
            // Log error dan kembalikan respons error 500
            \Log::error('Error in getSerialNumber: ' . $e->getMessage());
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    public function import(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new hd785Import, $request->file('file'));

        return redirect()->route('vhms.index')->with('success', 'Data successfully imported.');

        // try {
        //     // Proses import menggunakan class import
        //     Excel::import(new hd785Import, $request->file('file'));

        //     return redirect()->back()->with('success', 'Data berhasil diimpor!');
        // } catch (\Exception $e) {
        //     return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        // }
    }

    public function create()
    {
        // Ambil data unit dengan unit = "HD785-7"
        $units = Unit::where('unit', 'HD785-7')->get();

        return view('pages.vhms.create', compact('units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'sn' => 'required',
            'hm' => 'required|integer',
            'blowby_max' => 'required|numeric',
            'boost_press_max' => 'required|numeric',
            'exh_temp_lf_max' => 'required|numeric',
            'exh_temp_lr_max' => 'required|numeric',
            'exh_temp_rf_max' => 'required|numeric',
            'exh_temp_rr_max' => 'required|numeric',
            'eng_oil_press_hmin' => 'required|numeric',
            'eng_oil_press_lmin' => 'required|numeric',
            'coolant_temp_max' => 'required|numeric',
            'eng_oil_temp_max' => 'required|numeric',
            'tm_oil_temp_max' => 'required|numeric',
        ]);

        Vhms::create($request->all());
        return redirect()->route('vhms.index')->with('success', 'VHMS data created successfully.');
    }

    public function edit($id)
    {
        $vhms = VHMS::findOrFail($id);
        $units = Unit::where('unit', 'HD785-7')->get();

        return view('pages.vhms.edit', compact('vhms', 'units'));
    }
    // Menyimpan update data VHMS
    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required',
            'sn' => 'required',
            'hm' => 'required|integer',
            'blowby_max' => 'required|numeric',
            'boost_press_max' => 'required|numeric',
            'exh_temp_lf_max' => 'required|numeric',
            'exh_temp_lr_max' => 'required|numeric',
            'exh_temp_rf_max' => 'required|numeric',
            'exh_temp_rr_max' => 'required|numeric',
            'eng_oil_press_hmin' => 'required|numeric',
            'eng_oil_press_lmin' => 'required|numeric',
            'coolant_temp_max' => 'required|numeric',
            'eng_oil_temp_max' => 'required|numeric',
            'tm_oil_temp_max' => 'required|numeric',
        ]);

        $vhms = Vhms::findOrFail($id);
        $vhms->update($request->all());
        return redirect()->route('vhms.index')->with('success', 'VHMS data updated successfully.');
    }

    public function uploadCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        $path = $request->file('csv_file')->getRealPath();
        $data = array_map('str_getcsv', file($path));

        // Lewati baris header
        foreach (array_slice($data, 1) as $row) {
            Vhms::create([
                'code' => $row[1],
                'sn' => $row[2],
                'hm' => $row[3],
                'blowby_max' => $row[4],
                'boost_press_max' => $row[5],
                'exh_temp_lf_max' => $row[6],
                'exh_temp_lr_max' => $row[7],
                'exh_temp_rf_max' => $row[8],
                'exh_temp_rr_max' => $row[9],
                'eng_oil_press_hmin' => $row[10],
                'eng_oil_press_lmin' => $row[11],
                'coolant_temp_max' => $row[12],
                'eng_oil_temp_max' => $row[13],
                'tm_oil_temp_max' => $row[14],
            ]);
        }

        return redirect()->route('vhms.index')->with('success', 'CSV data imported successfully.');
    }

    // Menghapus data VHMS
    public function destroy($id)
    {
        Vhms::findOrFail($id)->delete();
        return redirect()->route('vhms.index')->with('success', 'VHMS data deleted successfully.');
    }
}
