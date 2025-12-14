@extends('layouts.app')

@section('content')
    <h3>Új vizit hozzáadása</h3>

    <form method="POST" action="{{ route('visits.store') }}" class="mt-4">
        @csrf

        <div class="mb-3">
            <label class="form-label">Beteg</label>
            <select name="patient_id" class="form-select" required>
                <option value="">Válassz beteget...</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}"
                        {{ old('patient_id', $selectedPatientId) == $patient->id ? 'selected' : '' }}>
                        {{ $patient->name }}
                    </option>
                @endforeach
            </select>
            @error('patient_id') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Vizit időpontja</label>
            <input type="datetime-local" name="visit_date" class="form-control"
                   value="{{ old('visit_date') }}" required>
            @error('visit_date') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Vizit oka</label>
            <input type="text" name="reason" class="form-control"
                   value="{{ old('reason') }}" required>
            @error('reason') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Megjegyzés</label>
            <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
        </div>

        <button class="btn btn-primary">Mentés</button>
        <a href="{{ route('visits.index') }}" class="btn btn-secondary">Mégse</a>
    </form>
@endsection
