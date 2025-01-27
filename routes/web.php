<?php

use App\Models\SwingCircle;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VhmsController;
use App\Http\Controllers\StrainerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PhenomenaController;
use App\Http\Controllers\UnitChartController;
use App\Http\Controllers\AnalisaPAPController;
use App\Http\Controllers\WheelBrakeController;
use App\Http\Controllers\AnalisaFuelController;
use App\Http\Controllers\SwingCircleController;
use App\Http\Controllers\CuttingFilterController;
use App\Http\Controllers\MagneticPluckController;

// Rute untuk halaman login
Route::get('/', function () {
    return view('pages.auth.auth-login', ['type_menu' => '']);
});

// Rute untuk pengguna yang sudah diautentikasi
Route::middleware(['auth'])->group(function () {

    // Rute untuk halaman semua role
    Route::get('/home', [UnitChartController::class, 'index'])->name('units.chart');

    Route::get('/dashboard/phenomena-component-health', function () {
        return view('pages.app.phenomena-component-health');
    })->name('dashboard.phenomenaHealth');

    // Rute untuk supervisor dan admin
    Route::middleware(['role:supervisor|admin'])->group(function () {
        // Rute resource untuk pengguna
        Route::resource('user', UserController::class);

        // Rute resource untuk unit
        Route::resource('unit', UnitController::class);
        Route::post('/units/import', [UnitController::class, 'import'])->name('units.import');

        Route::resource('analisa_fuel', AnalisaFuelController::class);
        Route::get('/get-type-units/{unit}', [AnalisaFuelController::class, 'getTypeUnits']);
        Route::get('/get-code-units/{typeUnitId}', [AnalisaFuelController::class, 'getCodeUnits']);

        Route::resource('analisa_pap', AnalisaPAPController::class);
    });

    // Rute untuk semua role (user, supervisor, admin)
    Route::middleware(['role:mekanik|supervisor|admin'])->group(function () {
        // Grup rute untuk tracks
        Route::prefix('tracks')->group(function () {
            Route::get('/phenomena/track/{component}', [PhenomenaController::class, 'showTrack'])->name('phenomena.track');
            Route::get('/phenomena/wheel/{component}', [PhenomenaController::class, 'showWheel'])->name('phenomena.wheel');
        });

        // Grup rute untuk Magnetic Pluck
        Route::resource('magnetic_plucks', MagneticPluckController::class);
        Route::get('/get-unit-codes/{unitModel}', [MagneticPluckController::class, 'getUnitCodes']);
        Route::get('magnetic-plucks/resume', [MagneticPluckController::class, 'resume'])->name('magnetic_plucks.resume');
        Route::put('magnetic-plucks/approve/{id}', [MagneticPluckController::class, 'approve'])->name('magnetic.approve');
        Route::put('magnetic-plucks/reject/{id}', [MagneticPluckController::class, 'reject'])->name('magnetic.reject');


        // Grup rute untuk Swing Circle
        Route::resource('swing_circles', SwingCircleController::class)->except(['show']);
        Route::get('swing_circles/resume', [SwingCircleController::class, 'resume'])->name('swing_circles.resume');
        Route::put('swing_circles/approve/{id}', [SwingCircleController::class, 'approve'])->name('swing_circles.approve');
        Route::put('swing_circles/reject/{id}', [SwingCircleController::class, 'reject'])->name('swing_circles.reject');


        // Grup rute untuk Wheel Brakes
        Route::resource('wheel-brakes', WheelBrakeController::class)->except(['show']);
        Route::get('wheel-brakes/resume', [WheelBrakeController::class, 'resume'])->name('wheel-brakes.resume');
        Route::put('wheel-brakes/approve/{id}', [WheelBrakeController::class, 'approve'])->name('wheel-brakes.approve');
        Route::put('wheel-brakes/reject/{id}', [WheelBrakeController::class, 'reject'])->name('wheel-brakes.reject');

        // Grup rute untuk Strainer
        // Route::resource('strainer', StrainerController::class);
        Route::resource('strainer', StrainerController::class)->except(['show']);
        Route::get('/get-unit-codes/{model}', [StrainerController::class, 'getUnitCodes']);
        Route::get('strainer/resume', [StrainerController::class, 'resume'])->name('strainer.resume');
        Route::put('strainer/approve/{id}', [StrainerController::class, 'approve'])->name('strainer.approve');
        Route::put('strainer/reject/{id}', [StrainerController::class, 'reject'])->name('strainer.reject');

        // Grup rute untuk Cutting Filter
        Route::resource('cutting_filters', CuttingFilterController::class);
        Route::get('/get-unit-codes/{model}', [CuttingFilterController::class, 'getUnitCodes']);
        Route::get('cutting-filters/resume', [CuttingFilterController::class, 'resume'])->name('cutting_filters.resume');
        Route::put('cutting-filters/approve/{id}', [CuttingFilterController::class, 'approve'])->name('filter.approve');
        Route::put('cutting-filters/reject/{id}', [CuttingFilterController::class, 'reject'])->name('filter.reject');

        // Grup rute untuk VHMS
        Route::resource('vhms', VhmsController::class);
        Route::get('/get-serial-number', [VhmsController::class, 'getSerialNumber'])->name('vhms.getSerialNumber');
        Route::post('vhms/import', [VhmsController::class, 'import'])->name('vhms.import');
    });
});
