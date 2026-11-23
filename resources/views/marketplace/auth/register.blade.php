@extends('marketplace.layout')

@section('title', 'Create account | Honeybee Marketplace')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="form-panel p-4 p-md-5">
                <span class="eyebrow">JOIN YOUR COMMUNITY</span>
                <h1 class="h3 fw-bold mt-2">Create your account</h1>
                <p class="text-muted">It only takes a moment to start buying and selling locally.</p>
                <form method="POST" action="{{ route('marketplace.register.submit') }}" class="mt-4">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="name">Your name</label>
                        <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" autocomplete="name" maxlength="255" required autofocus>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email">Email address</label>
                        <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Password</label>
                        <input class="form-control @error('password') is-invalid @enderror" id="password" name="password" type="password" autocomplete="new-password" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="password_confirmation">Confirm password</label>
                        <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required>
                    </div>
                    <button class="btn btn-honey btn-lg w-100" type="submit">Create account</button>
                </form>
                <p class="small text-center mt-4 mb-0">Already registered? <a href="{{ route('marketplace.login') }}">Log in</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
