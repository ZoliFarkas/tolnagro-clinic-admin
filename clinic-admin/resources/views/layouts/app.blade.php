<!doctype html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rendelő Admin</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<header class="top-header">
    <div class="container d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <img src="{{ asset('images/tolnagro_logo.svg') }}" alt="Tolnagro" class="logo">
        </div>
    </div>
</header>
<nav class="sub-nav">
    <div class="container d-flex gap-3">
        <a href="{{ route('patients.index') }}"
           class="sub-nav-link {{ request()->routeIs('patients.*') ? 'active' : '' }}">
            BETEGEK
        </a>
        <a href="{{ route('visits.index') }}"
           class="sub-nav-link {{ request()->routeIs('visits.*') ? 'active' : '' }}">
            VIZITEK
        </a>
        <a href="{{ route('statistics.index') }}"
           class="sub-nav-link {{ request()->routeIs('statistics.*') ? 'active' : '' }}">
            STATISZTIKA
        </a>
    </div>
</nav>

<div class="container main-content">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            Kérjük javítsd a hibákat.
        </div>
    @endif

    @yield('content')
</div>
@foreach (['success', 'error', 'warning'] as $type)
    @if(session($type))
        <div class="alert alert-{{ $type == 'error' ? 'danger' : $type }}">
            {{ session($type) }}
        </div>
    @endif
@endforeach

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    })
</script>
</body>
</html>
