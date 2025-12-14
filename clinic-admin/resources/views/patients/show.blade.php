@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h3>{{ $patient->name }}</h3>
            <p class="mb-0"><strong>Email:</strong> {{ $patient->email }}</p>
            <p class="mb-0"><strong>Telefon:</strong> {{ $patient->phone ?? '-' }}</p>
            <p class="mb-0"><strong>Születés:</strong>{{ $patient->birth_date ? $patient->birth_date->format('Y-m-d') : '-' }}</p>
        </div>
        <div>
            <a href="{{ route('patients.edit', $patient) }}" class="btn btn-outline-secondary">Szerkeszt</a>
            <a href="{{ route('patients.index') }}" class="btn btn-secondary">Vissza</a>
        </div>
    </div>

    <h5>Vizitek</h5>
    @if($visits->count())
        <table class="table table-sm">
            <thead>
            <tr>
                <th>Dátum</th>
                <th>Ok</th>
                <th>Megjegyzés</th>
            </tr>
            </thead>
            <tbody>
            @foreach($visits as $v)
                <tr>
                    <td>{{ $v->visit_date->format('Y-m-d H:i') }}</td>
                    <td>{{ $v->reason }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($v->notes, 80) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">Nincsenek vizitek ehhez a beteghez.</div>
    @endif
@endsection
