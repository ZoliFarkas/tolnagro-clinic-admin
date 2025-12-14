@extends('layouts.app')

@section('content')
    <h3>Vizit szerkesztése</h3>

    <form method="POST" action="{{ route('visits.update', $visit) }}" class="mt-4">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Beteg</label>
            <select name="patient_id" class="form-select" required>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}"
                        {{ old('patient_id', $visit->patient_id) == $patient->id ? 'selected' : '' }}>
                        {{ $patient->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Vizit időpontja</label>
            <input type="datetime-local" name="visit_date" class="form-control"
                   value="{{ old('visit_date', $visit->visit_date->format('Y-m-d\TH:i')) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Vizit oka</label>
            <input type="text" name="reason" class="form-control"
                   value="{{ old('reason', $visit->reason) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Megjegyzés</label>
            <textarea name="notes" class="form-control">{{ old('notes', $visit->notes) }}</textarea>
        </div>

        <button class="btn btn-primary">Mentés</button>
        <a href="{{ route('visits.index', ['patient_id' => $visit->patient_id]) }}"
           class="btn btn-secondary">Mégse</a>
    </form>
@endsection
