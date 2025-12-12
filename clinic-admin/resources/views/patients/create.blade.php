@extends('layouts.app')

@section('content')
    <h3>Új beteg létrehozása</h3>

    <form method="POST" action="{{ route('patients.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Név</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Telefon</label>
            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Születési dátum</label>
            <input type="date" name="birth_date" class="form-control @error('birth_date') is-invalid @enderror" value="{{ old('birth_date') }}">
            @error('birth_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <button class="btn btn-primary">Mentés</button>
        <a href="{{ route('patients.index') }}" class="btn btn-secondary">Mégse</a>
    </form>
@endsection
