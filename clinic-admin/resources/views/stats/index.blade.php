@extends('layouts.app')

@section('content')
    <h3>Statisztika</h3>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card p-3">
                <h6>Heti vizitszám (napokra bontva)</h6>
                <ul class="list-group list-group-flush">
                    @php
                        $days = [];
                        for($i = 6; $i >= 0; $i--) {
                            $day = \Carbon\Carbon::today()->subDays($i)->format('Y-m-d');
                            $days[$day] = 0;
                        }
                        foreach($weeklyCounts as $wc) {
                            $days[$wc->day] = $wc->count;
                        }
                    @endphp

                    @foreach($days as $day => $count)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $day }} <span class="badge bg-primary rounded-pill">{{ $count }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-3">
                <h6>Top okok</h6>
                <ul class="list-group list-group-flush">
                    @foreach($topReasons as $tr)
                        <li class="list-group-item d-flex justify-content-between">
                            {{ $tr->reason }}
                            <span class="badge bg-secondary">{{ $tr->total }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="card p-3">
        <h6>Legutóbbi vizitek</h6>
        <table class="table table-sm">
            <thead>
            <tr>
                <th>Dátum</th>
                <th>Beteg</th>
                <th>Ok</th>
            </tr>
            </thead>
            <tbody>
            @foreach($recentVisits as $rv)
                <tr>
                    <td>{{ $rv->visit_date->format('Y-m-d H:i') }}</td>
                    <td><a href="{{ route('patients.show', $rv->patient) }}">{{ $rv->patient->name }}</a></td>
                    <td>{{ $rv->reason }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
