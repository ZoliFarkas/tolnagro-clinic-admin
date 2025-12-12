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

Route::get('statistics', [StatsController::class, 'index'])->name('statistics.index');
