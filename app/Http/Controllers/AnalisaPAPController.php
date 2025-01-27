<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnalisaPAPRequest;
use App\Http\Requests\UpdateAnalisaPAPRequest;
use App\Models\AnalisaPAP;
use Illuminate\Http\Request;

class AnalisaPAPController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data tanpa filter
        $analisa_paps = AnalisaPAP::paginate(10);

        return view('pages.analisa_paps.index', compact('analisa_paps'));
    }


    public function create()
    {
        return view('pages.analisa_paps.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnalisaPAPRequest $request)
    {
        // Menggunakan request untuk menyimpan data baru
        AnalisaPAP::create($request->validated());

        return redirect()->route('analisa_pap.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Update the specified resource in storage.
     */

     public function edit(AnalisaPAP $analisa_pap)
     {
         return view('pages.analisa_paps.edit', compact('analisa_pap'));
     }


    public function update(UpdateAnalisaPAPRequest $request, AnalisaPAP $analisa_pap)
    {
        // Memvalidasi dan memperbarui data analisa pap
        $analisa_pap->update($request->validated());

        return redirect()->route('analisa_pap.index')->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnalisaPAP $analisa_pap)
    {
        $analisa_pap->delete();

        return redirect()->route('analisa_pap.index')->with('success', 'Data berhasil dihapus');
    }
}
