@extends('marketplace.layout')

@section('title', 'Log in | Honeybee Marketplace')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="form-panel p-4 p-md-5">
                <span class="eyebrow">WELCOME BACK</span>
                <h1 class="h3 fw-bold mt-2">Log in to Honeybee</h1>
                <p class="text-muted">Manage your listings and connect with your community.</p>
                <form method="POST" action="{{ route('marketplace.login.submit') }}" class="mt-4">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="email">Email address</label>
                        <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Password</label>
                        <input class="form-control @error('password') is-invalid @enderror" id="password" name="password" type="password" autocomplete="current-password" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-check mb-4">
                        <input class="form-check-input" id="remember" name="remember" type="checkbox">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <button class="btn btn-honey btn-lg w-100" type="submit">Log in</button>
                </form>
                <p class="small text-center mt-4 mb-0">New here? <a href="{{ route('marketplace.register') }}">Create an account</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
