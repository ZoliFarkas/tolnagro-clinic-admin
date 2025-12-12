@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h3>Betegek</h3>
        <a href="{{ route('patients.create') }}" class="btn btn-primary">Új beteg</a>
    </div>

    <form method="GET" action="{{ route('patients.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Keresés név vagy email" value="{{ request('search') }}">
            <button class="btn btn-outline-secondary">Keres</button>
        </div>
    </form>

    @if($patients->count())
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Név</th>
                <th>Email</th>
                <th>Telefon</th>
                <th>Regisztrálva</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($patients as $p)
                <tr>
                    <td><a href="{{ route('patients.show', $p) }}">{{ $p->name }}</a></td>
                    <td>{{ $p->email }}</td>
                    <td>{{ $p->phone }}</td>
                    <td>{{ $p->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('patients.edit', $p) }}" class="btn btn-sm btn-outline-secondary">Szerkeszt</a>
                        <form action="{{ route('patients.destroy', $p) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Biztos törlöd?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Törlés</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $patients->links() }}
    @else
        <div class="alert alert-info">Nincs találat.</div>
    @endif
@endsection
