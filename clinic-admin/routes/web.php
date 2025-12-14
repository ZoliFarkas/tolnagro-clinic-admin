<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\StatsController;

Route::get('/', function () {
    return redirect()->route('patients.index');
});

Route::resource('patients', PatientController::class)->except(['show']);
Route::get('patients/{patient}', [PatientController::class, 'show'])->name('patients.show');
Route::get('patients/{patient}/visits', [VisitController::class, 'index'])->name('patients.visits');
Route::get('visits', [VisitController::class, 'all'])->name('visits.index');
Route::get('visits/create', [VisitController::class, 'create'])->name('visits.create');
Route::post('visits', [VisitController::class, 'store'])->name('visits.store');
Route::get('/visits/{visit}/edit', [VisitController::class, 'edit'])->name('visits.edit');
Route::put('/visits/{visit}', [VisitController::class, 'update'])->name('visits.update');
Route::delete('/visits/{visit}', [VisitController::class, 'destroy'])->name('visits.destroy');
Route::get('/visits/export/csv', [VisitController::class, 'exportCsv'])
    ->name('visits.export.csv');
Route::get('statistics', [StatsController::class, 'index'])->name('statistics.index');
