@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Vizitek</h3>
        @if(request('period'))
            <span class="badge bg-secondary ms-2">
            {{ request('period') == '7' ? 'Elmúlt 7 nap' :
               (request('period') == '30' ? 'Elmúlt 30 nap' : 'Idei év') }}
        </span>
        @endif
        @php
            $canExport = request()->filled('patient_id') && $visits->count() > 0;
        @endphp

        @if($canExport)
            <a href="{{ route('visits.export.csv', request()->query()) }}"
               class="btn btn-outline-secondary me-2">
                Export CSV
            </a>
        @else
            <button class="btn btn-outline-secondary me-2" disabled
                    data-bs-toggle="tooltip"
                    title="Export csak kiválasztott beteg és meglévő vizitek esetén lehetséges">
                Export CSV
            </button>
        @endif
        <a href="{{ request()->filled('patient_id')
        ? route('visits.create', ['patient_id' => request('patient_id')])
        : '#'}}"
           class="btn btn-primary {{ request()->filled('patient_id') ? '' : 'disabled' }}">
            Új vizit
        </a>

    </div>
    <form method="GET" class="row align-items-end mb-4 g-3 p-3 bg-light rounded">

        <div class="col-12 col-md-6">
            <label class="form-label mb-1">Beteg</label>
            <select name="patient_id" class="form-select" onchange="this.form.submit()">
                <option value="">Válassz beteget...</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}"
                        {{ request('patient_id') == $patient->id ? 'selected' : '' }}>
                        {{ $patient->name }}
                    </option>
                @endforeach
            </select>
        </div>

        @if(request()->filled('patient_id'))
            <div class="col-12 col-md-3">
                <label class="form-label mb-1">Időszak</label>
                <select name="period" class="form-select" onchange="this.form.submit()">
                    <option value="">Összes időszak</option>
                    <option value="7" {{ request('period') == '7' ? 'selected' : '' }}>
                        Elmúlt 7 nap
                    </option>
                    <option value="30" {{ request('period') == '30' ? 'selected' : '' }}>
                        Elmúlt 30 nap
                    </option>
                    <option value="year" {{ request('period') == 'year' ? 'selected' : '' }}>
                        Idei év
                    </option>
                </select>
            </div>
        @endif
    </form>

    @if(request()->filled('patient_id'))
        @if($visits->isNotEmpty())
            <div class="table-responsive d-none d-md-block">
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th>Dátum</th>
                        <th>Beteg</th>
                        <th>Ok</th>
                        <th>Megjegyzés</th>
                        <th class="text-end" style="width: 160px;">Műveletek</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($visits as $visit)
                        <tr>
                            <td>{{ $visit->visit_date->format('Y-m-d H:i') }}</td>
                            <td>{{ $visit->patient->name }}</td>
                            <td>{{ $visit->reason }}</td>
                            <td>
                                {{ \Illuminate\Support\Str::limit($visit->notes, 80) }}
                                @if(strlen($visit->notes) > 80)
                                    <a class="ms-1" data-bs-toggle="collapse" href="#note-{{ $visit->id }}">
                                        több
                                    </a>
                                @endif
                            </td>
                            <td class="text-end align-middle">
                                <div class="d-inline-flex gap-2 flex-nowrap">
                                    <a href="{{ route('visits.edit', $visit) }}"
                                       class="btn btn-sm btn-outline-secondary">
                                        Szerkeszt
                                    </a>

                                    <form action="{{ route('visits.destroy', $visit) }}"
                                          method="POST"
                                          onsubmit="return confirm('Biztosan törlöd ezt a vizitet?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            Törlés
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @if(strlen($visit->notes) > 80)
                            <tr class="collapse bg-light" id="note-{{ $visit->id }}">
                                <td colspan="5">
                                    <strong>Megjegyzés:</strong>
                                    {{ $visit->notes }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-md-none">
                @foreach($visits as $visit)
                    <div class="card mb-3">
                        <div class="card-body">

                            <div class="mb-2">
                                <strong>Dátum:</strong><br>
                                {{ $visit->visit_date->format('Y-m-d H:i') }}
                            </div>

                            <div class="mb-2">
                                <strong>Beteg:</strong><br>
                                {{ $visit->patient->name }}
                            </div>

                            <div class="mb-2">
                                <strong>Ok:</strong><br>
                                {{ $visit->reason }}
                            </div>

                            @if($visit->notes)
                                <div class="mb-2">
                                    <strong>Megjegyzés:</strong><br>
                                    {{ \Illuminate\Support\Str::limit($visit->notes, 120) }}
                                </div>
                            @endif

                            <div class="d-flex gap-2 mt-3">
                                <a href="{{ route('visits.edit', $visit) }}"
                                   class="btn btn-sm btn-outline-secondary">
                                    Szerkeszt
                                </a>

                                <form action="{{ route('visits.destroy', $visit) }}"
                                      method="POST"
                                      onsubmit="return confirm('Biztosan törlöd ezt a vizitet?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        Törlés
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
            {{ $visits->links() }}
        @else
            <div class="alert alert-info mt-3">
                A kiválasztott beteghez jelenleg nem tartozik egyetlen vizit sem.
            </div>
        @endif
    @endif
@endsection
