<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Unit; // Pastikan model Unit ada

class UnitChartController extends Controller
{
    public function index()
    {
        $totalUsers = User::count(); // Hitung total user
        $totalUnits = Unit::count(); // Hitung total unit

        // Ambil data jumlah unit berdasarkan kolom 'type'
        $units = Unit::select('type')
            ->groupBy('type')
            ->selectRaw('type, COUNT(*) as count')
            ->get();

        // Pisahkan label dan data untuk chart
        $labels = $units->pluck('type')->toArray(); // Label untuk chart (type)
        $data = $units->pluck('count')->toArray();  // Data untuk chart (jumlah tiap type)

        // Buat Pie Chart
        $chart = (new LarapexChart)
            ->pieChart()
            ->setTitle('Distribusi Unit')
            ->addData($data) // Data jumlah
            ->setLabels($labels); // Label type

        // Pie Chart 2: Berdasarkan Kolom 'unit'
        $units = Unit::select('unit')
            ->groupBy('unit')
            ->selectRaw('unit, COUNT(*) as count')
            ->get();

        $unitLabels = $units->pluck('unit')->toArray(); // Label untuk chart (unit)
        $unitData = $units->pluck('count')->toArray();  // Data untuk chart (jumlah tiap unit)

        $unitChart = (new LarapexChart)
            ->pieChart()
            ->setTitle('Distribusi Tipe Unit')
            ->addData($unitData) // Data jumlah
            ->setLabels($unitLabels); // Label unit

        // Kirim chart ke view
        return view('pages.app.dashboard', compact('chart', 'unitChart', 'totalUsers', 'totalUnits'));
    }
}
