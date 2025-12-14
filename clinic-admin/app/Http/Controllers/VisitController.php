<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Visit;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Carbon\Carbon;

class VisitController extends Controller
{
    // A listázás a beteg profilján keresztül a PatientController@show használja.
    // Ha külön route-ot szeretnénk, itt egy metódus:
    public function index(Patient $patient)
    {
        $visits = $patient->visits()->orderBy('visit_date', 'desc')->get();
        return view('patients.show', compact('patient', 'visits'));
    }


    public function all(Request $request)
    {
        $patients = Patient::orderBy('name')->get();

        $visits = collect();

        if ($request->filled('patient_id')) {

            $query = Visit::with('patient')
                ->where('patient_id', $request->patient_id);

            // DÁTUM SZŰRÉS
            if ($request->filled('from')) {
                $query->whereDate('visit_date', '>=', $request->from);
            }

            if ($request->filled('to')) {
                $query->whereDate('visit_date', '<=', $request->to);
            }

            if ($request->filled('period')) {
                if ($request->period === '7') {
                    $query->where('visit_date', '>=', Carbon::now()->subDays(7));
                }

                if ($request->period === '30') {
                    $query->where('visit_date', '>=', Carbon::now()->subDays(30));
                }

                if ($request->period === 'year') {
                    $query->whereYear('visit_date', now()->year);
                }
            }
            $visits = $query
                ->orderBy('visit_date', 'desc')
                ->paginate(10)
                ->withQueryString();
        }
        return view('visits.index', compact('patients', 'visits'));
    }
    public function create(Request $request)
    {
        $patients = Patient::orderBy('name')->get();
        $selectedPatientId = $request->get('patient_id');

        return view('visits.create', compact('patients', 'selectedPatientId'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'visit_date' => 'required|date',
            'reason' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        Visit::create($validated);

        return redirect()
            ->route('visits.index', ['patient_id' => $validated['patient_id']])
            ->with('success', 'A vizit sikeresen rögzítve lett.');
    }

    public function edit(Visit $visit)
    {
        $patients = Patient::orderBy('name')->get();
        return view('visits.edit', compact('visit', 'patients'));
    }
    public function update(Request $request, Visit $visit)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'visit_date' => 'required|date',
            'reason' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $visit->update($validated);

        return redirect()
            ->route('visits.index', ['patient_id' => $validated['patient_id']])
            ->with('success', 'A vizit sikeresen frissítve lett.');
    }
    public function destroy(Visit $visit)
    {
        $patientId = $visit->patient_id;
        $visit->delete();

        return redirect()
            ->route('visits.index', ['patient_id' => $patientId])
            ->with('success', 'A vizit törölve lett.');
    }
    public function exportCsv(Request $request): StreamedResponse
    {
        if (!$request->filled('patient_id')) {
            abort(403, 'Export csak kiválasztott beteg esetén lehetséges.');
        }

        $query = Visit::with('patient');

        // Beteg szűrés
        if ($request->filled('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        // Időszak szűrés
        if ($request->filled('period')) {
            if ($request->period === '7') {
                $query->where('visit_date', '>=', Carbon::now()->subDays(7));
            }

            if ($request->period === '30') {
                $query->where('visit_date', '>=', Carbon::now()->subDays(30));
            }

            if ($request->period === 'year') {
                $query->whereYear('visit_date', now()->year);
            }
        }

        $visits = $query->orderBy('visit_date', 'desc')->get();
        if ($visits->isEmpty()) {
            abort(404, 'Nincs exportálható vizit.');
        }
        $response = new StreamedResponse(function () use ($visits) {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM (Excel miatt fontos!)
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // Fejléc
            fputcsv($handle, [
                'Dátum',
                'Beteg',
                'Ok',
                'Megjegyzés',
            ]);

            foreach ($visits as $visit) {
                fputcsv($handle, [
                    $visit->visit_date->format('Y-m-d H:i'),
                    $visit->patient->name,
                    $visit->reason,
                    $visit->notes,
                ]);
            }

            fclose($handle);
        });

        $filename = 'vizitek_' . now()->format('Ymd_His') . '.csv';

        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', "attachment; filename=\"$filename\"");

        return $response;
    }
}
