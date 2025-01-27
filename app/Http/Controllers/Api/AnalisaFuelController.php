<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AnalisaFuelResource;
use App\Models\AnalisaFuel;
use Illuminate\Http\Request;

class AnalisaFuelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $analisa_fuel = AnalisaFuel::with('religion')->get();
        return AnalisaFuelResource::collection($analisa_fuel);
    }

    // Metode lain
}
