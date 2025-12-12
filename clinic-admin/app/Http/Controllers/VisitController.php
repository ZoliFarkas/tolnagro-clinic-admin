<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    // A listázás a beteg profilján keresztül a PatientController@show használja.
    // Ha külön route-ot szeretnénk, itt egy metódus:
    public function index(Patient $patient)
    {
        $visits = $patient->visits()->orderBy('visit_date', 'desc')->get();
        return view('patients.show', compact('patient', 'visits'));
    }
}
