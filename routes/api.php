<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AnalisaFuelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');

Route::apiResource('analisa_fuels', AnalisaFuelController::class)
    ->middleware('auth:sanctum');

    Route::get('/components', function (Request $request) {
        $unitModel = $request->query('unit_model');

        // Mapping Unit Model ke Component
        $componentsMap = [
            'PC2000-8' => ['Final Drive LH', 'Final Drive RH'],
            'PC1250-8' => ['Final Drive LH', 'Final Drive RH'],
            'PC850-8'  => ['Final Drive LH', 'Final Drive RH'],
            'D155-6R'  => ['Final Drive LH', 'Final Drive RH'],
            'HD785-7'  => ['Final Drive LH', 'Final Drive RH', 'Differential'],
            'GD825-2'  => ['Differential'],
            'GD755-5'  => ['Differential'],
        ];

        $components = $componentsMap[$unitModel] ?? []; // Jika unit model tidak ditemukan, kosongkan array
        return response()->json($components);
    });



