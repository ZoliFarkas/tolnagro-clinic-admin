<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $patients = $query->orderBy('name')->paginate(12)->withQueryString();

        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email',
            'phone' => 'nullable|string|max:50',
            'birth_date' => 'nullable|date',
        ]);

        Patient::create($data);

        return redirect()->route('patients.index')->with('success', 'Beteg sikeresen létrehozva.');
    }

    public function show(Patient $patient)
    {
        $visits = $patient->visits()->orderBy('visit_date', 'desc')->get();
        return view('patients.show', compact('patient', 'visits'));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email,' . $patient->id,
            'phone' => 'nullable|string|max:50',
            'birth_date' => 'nullable|date',
        ]);

        $patient->update($data);

        return redirect()->route('patients.index')->with('success', 'Beteg adatai frissítve.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Beteg törölve.');
    }
}
