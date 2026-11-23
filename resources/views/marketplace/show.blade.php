@extends('marketplace.layout')

@section('title', $listing->name.' | Honeybee Marketplace')

@section('content')
<div class="container py-4">
    <a class="text-decoration-none text-muted small" href="{{ route('marketplace.home') }}">← Back to listings</a>
    <div class="row g-4 g-lg-5 mt-1">
        <div class="col-lg-7">
            @if ($listing->image_path)
                <img class="detail-image rounded-4" src="{{ asset('storage/'.$listing->image_path) }}" alt="{{ $listing->name }}">
            @else
                <div class="detail-image image-placeholder rounded-4"><span>🐝</span></div>
            @endif
            <div class="mt-4">
                <span class="badge rounded-pill bg-light text-dark">{{ $listing->category->name }}</span>
                <h1 class="h2 fw-bold mt-3">{{ $listing->name }}</h1>
                <p class="text-muted">{{ $listing->area }}, {{ $listing->city }}, {{ $listing->state }}, {{ $listing->country }}</p>
                <h2 class="price h3 mt-4">₹{{ number_format((float) $listing->price, 2) }}</h2>
                <hr class="my-4">
                <h2 class="h5 fw-bold">Description</h2>
                <p class="description-text">{{ $listing->detail }}</p>
            </div>
        </div>
        <aside class="col-lg-5">
            <div class="seller-panel p-4">
                <span class="eyebrow">SELLER</span>
                <h2 class="h5 fw-bold mt-2">{{ $listing->user->name }}</h2>
                <p class="text-muted mb-3">Member since {{ $listing->user->created_at->format('M Y') }}</p>
                <a class="btn btn-honey w-100" href="mailto:{{ $listing->user->email }}?subject={{ rawurlencode('Interested in: '.$listing->name) }}">Contact seller</a>
                @if (auth()->check() && auth()->id() === $listing->user_id)
                    <a class="btn btn-outline-dark w-100 mt-2" href="{{ route('marketplace.listings.edit', $listing->id) }}">Edit listing</a>
                @endif
            </div>
            <div class="small text-muted mt-3">Posted {{ $listing->created_at->diffForHumans() }} · {{ ucfirst($listing->type) }}</div>
        </aside>
    </div>
</div>
@endsection
