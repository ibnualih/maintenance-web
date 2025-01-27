<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Imports\UnitsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        Excel::import(new UnitsImport, $request->file('file'));

        return redirect()->route('unit.index')->with('success', 'Data imported successfully.');
    }
    public function index(Request $request)
{
    $search = $request->input('search'); // Tangkap parameter pencarian
    $units = Unit::query();

    // Filter berdasarkan kolom type atau unit
    if ($search) {
        $units = $units->where('type', 'like', "%{$search}%")
                       ->orWhere('unit', 'like', "%{$search}%");
    }

    // Paginate hasil pencarian
    $units = $units->paginate(10)->withQueryString(); // Menyimpan parameter query di URL untuk pagination

    return view('pages.units.index', compact('units'));
}


    public function create()
    {
        return view('pages.units.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'unit' => 'required|string',
            'code_unit' => 'required|string',
            'serial_number' => 'required|string',
        ]);

        Unit::create($request->all());

        return redirect(route('unit.index'))->with('success', 'Unit berhasil ditambahkan');
    }

    public function edit(Unit $unit)
    {
        return view('pages.units.edit', compact('unit'));
    }

    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'type' => 'required|string',
            'unit' => 'required|string',
            'code_unit' => 'required|string',
            'serial_number' => 'required|string',
        ]);

        $unit->update($request->all());

        return redirect(route('unit.index'))->with('success', 'Unit berhasil diperbarui');
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect(route('unit.index'))->with('success', 'Unit berhasil dihapus');
    }
}
