<?php

namespace App\Http\Controllers;

use App\Models\KomponenTrack; // Pastikan untuk mengimpor model ini
use App\Models\KomponenWheel; // Pastikan untuk mengimpor model ini
use Illuminate\Http\Request;

class PhenomenaController extends Controller
{
    public function showTrack($component)
    {
        // Mengambil data berdasarkan komponen, gunakan kolom yang sesuai
        $data = KomponenTrack::where('model', $component)->first(); // Ganti 'model' jika kolom berbeda
        return view('tracks.track_detail', compact('data')); // Mengirim data ke view
    }

    public function showWheel($component)
    {
        // Mengambil data berdasarkan komponen, gunakan kolom yang sesuai
        $data = KomponenWheel::where('model', $component)->first(); // Ganti 'model' jika kolom berbeda
        return view('tracks.wheel_detail', compact('data')); // Mengirim data ke view
    }
}
