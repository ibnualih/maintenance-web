<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnalisaFuelRequest;
use App\Http\Requests\UpdateAnalisaFuelRequest;
use App\Models\AnalisaFuel;
use Illuminate\Http\Request;

class AnalisaFuelController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index(Request $request)
{
    $query = AnalisaFuel::query();

    // Filter berdasarkan status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Filter berdasarkan lab number
    if ($request->filled('lab_number')) {
        $query->where('lab_number', 'like', '%' . $request->lab_number . '%');
    }

    // Filter berdasarkan customer name
    if ($request->filled('customer_name')) {
        $query->where('customer_name', 'like', '%' . $request->customer_name . '%');
    }

    // Filter berdasarkan branch
    if ($request->filled('branch')) {
        $query->where('branch', 'like', '%' . $request->branch . '%');
    }

    // Filter berdasarkan sample date
    if ($request->filled('sample_date')) {
        $query->whereDate('sample_date', $request->sample_date);
    }

    // Filter berdasarkan report date
    if ($request->filled('report_date')) {
        $query->whereDate('report_date', $request->report_date);
    }

    // Filter berdasarkan type unit
    if ($request->filled('type_unit')) {
        $query->where('type_unit', 'like', '%' . $request->type_unit . '%');
    }

    // Filter berdasarkan serial number
    if ($request->filled('serial_number')) {
        $query->where('serial_number', 'like', '%' . $request->serial_number . '%');
    }

    // Ambil data dengan pagination
    $analisa_fuels = $query->paginate(10);

    return view('pages.analisa_fuels.index', compact('analisa_fuels'));
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.analisa_fuels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnalisaFuelRequest $request)
    {
        // Menggunakan request untuk menyimpan data baru
        AnalisaFuel::create($request->validated());
        
        return redirect()->route('analisa_fuel.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(AnalisaFuel $analisa_fuel)
    {
        // Mengembalikan view dengan data analisa fuel yang spesifik
        return view('pages.analisa_fuels.show', compact('analisa_fuel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AnalisaFuel $analisa_fuel)
    {
        return view('pages.analisa_fuels.edit', compact('analisa_fuel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $analisa_fuel = AnalisaFuel::findOrFail($id);

    // Validasi input
    $request->validate([
        'lab_number' => 'required|string',
        'customer_name' => 'required|string',
        'branch' => 'required|string',
        'sample_date' => 'required|date',
        'report_date' => 'required|date',
        'unit' => 'required|string',
        'type_unit' => 'required|string',
        'code_unit' => 'required|string',
        'serial_number' => 'required|string',
        // Tambahkan validasi lain sesuai kebutuhan
    ]);

    // Update data, jika status tidak diubah, tetap gunakan status yang ada
    $analisa_fuel->update([
        'status' => $request->input('status', $analisa_fuel->status), // Jika status tidak dipilih, gunakan status yang ada
        'lab_number' => $request->lab_number,
        'customer_name' => $request->customer_name,
        'branch' => $request->branch,
        'sample_date' => $request->sample_date,
        'report_date' => $request->report_date,
        'unit' => $request->unit,
        'type_unit' => $request->type_unit,
        'code_unit' => $request->code_unit,
        'serial_number' => $request->serial_number,
    ]);

    return redirect()->route('analisa_fuel.index')->with('success', 'Data berhasil diupdate.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnalisaFuel $analisa_fuel)
    {
        $analisa_fuel->delete();
        
        return redirect()->route('analisa_fuel.index');
    }
}
