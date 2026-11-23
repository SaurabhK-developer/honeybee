<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Honeybee Marketplace')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/marketplace.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-warning-emphasis" href="{{ route('marketplace.home') }}">
                <span class="brand-mark">h</span> Honeybee
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#marketplaceNav" aria-controls="marketplaceNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="marketplaceNav">
                <div class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                    @auth
                        <a class="nav-link" href="{{ route('marketplace.my-listings') }}">My listings</a>
                        <span class="navbar-text small text-muted">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('marketplace.logout') }}">
                            @csrf
                            <button class="btn btn-link nav-link" type="submit">Log out</button>
                        </form>
                    @else
                        <a class="nav-link" href="{{ route('marketplace.login') }}">Log in</a>
                        <a class="btn btn-outline-dark btn-sm" href="{{ route('marketplace.register') }}">Create account</a>
                    @endauth
                    <a class="btn btn-honey ms-lg-2" href="{{ route('marketplace.listings.create') }}">＋ Post an ad</a>
                </div>
            </div>
        </div>
    </nav>

    <main>
        <div class="container pt-3">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <strong>Please check the form and try again.</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        @yield('content')
    </main>

    <footer class="border-top mt-5 py-4 bg-white">
        <div class="container d-flex flex-column flex-sm-row justify-content-between gap-2 text-muted small">
            <span>Honeybee Marketplace — find good things nearby.</span>
            <a class="text-muted" href="{{ route('marketplace.home') }}">Browse all listings</a>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
