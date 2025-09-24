<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Http\Controllers\MeasurementController;
use App\Http\Controllers\KpiController;
use App\Models\Kpi;

Route::get('/', function () {
    return view('Home' );
})->middleware('auth')->name('Home');

Route::post('/logout', function(){
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/measurements', [MeasurementController::class, 'index'])->name('measurements.index');
Route::get('/measurements/create',[MeasurementController::class,'create'])->name('measurements.create');
Route::post('/measurements/store',[MeasurementController::class,'store'])->name('measurements.store');

Route::get('/kpis',[KpiController::class, 'index'])->name('kpis.index');
Route::get('/kpis/create',[KpiController::class, 'create'])->name('kpis.create');
Route::post('/kpis',[KpiController::class, 'store'])->name('kpis.store');
Route::get('/kpis/{kpi}/edit',[KpiController::class, 'edit'])->name('kpis.edit');
Route::patch('/kpis/{kpi}',[KpiController::class, 'update'])->name('kpis.update');
Route::delete('/kpis/{kpi}',[KpiController::class, 'destroy'])->name('kpis.destroy');


 Route::get('/dashboard', function () {
    $companyId = auth()->user()->company_id;
    $kpis = Kpi::where('company_id', $companyId)->get();
    return view('dashboard', compact('kpis'));
})->middleware(['auth', 'verified'])->name('dashboard');


 Route::middleware('auth')->post('/api/measurements', [MeasurementController::class, 'fetchMeasurements']);

 
         Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
         Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
         Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
 });

require __DIR__.'/auth.php';
