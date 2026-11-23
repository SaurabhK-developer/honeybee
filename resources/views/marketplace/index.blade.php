@extends('marketplace.layout')

@section('title', 'Buy and sell locally | Honeybee Marketplace')

@section('content')
<section class="hero py-5">
    <div class="container py-lg-4">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <span class="eyebrow">YOUR NEIGHBOURHOOD MARKETPLACE</span>
                <h1 class="display-5 fw-bold mt-3">Find it. Love it.<br><span class="text-honey">Pass it on.</span></h1>
                <p class="lead text-secondary mt-3">Discover pre-loved finds, useful services and great deals from people around you.</p>
            </div>
            <div class="col-lg-6">
                <form class="search-panel row g-2" method="GET" action="{{ route('marketplace.home') }}">
                    <div class="col-12">
                        <label class="form-label small fw-semibold" for="search-q">What are you looking for?</label>
                        <input id="search-q" class="form-control form-control-lg" type="search" name="q" value="{{ old('q', request('q')) }}" placeholder="Try “bicycle” or “tutoring”">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold" for="search-city">City</label>
                        <input id="search-city" class="form-control" type="text" name="city" value="{{ old('city', request('city')) }}" placeholder="Any city">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold" for="search-category">Category</label>
                        <select id="search-category" class="form-select" name="category_id">
                            <option value="">All categories</option>
                            @foreach ($categories as $parent)
                                <option value="{{ $parent->id }}" @if((string) request('category_id') === (string) $parent->id) selected @endif>{{ $parent->name }}</option>
                                @foreach ($parent->children as $child)
                                    <option value="{{ $child->id }}" @if((string) request('category_id') === (string) $child->id) selected @endif>{{ $parent->name }} · {{ $child->name }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 d-grid mt-3">
                        <button class="btn btn-honey btn-lg" type="submit">Search listings</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="container py-5">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-end gap-2 mb-4">
        <div>
            <span class="eyebrow">THE LATEST FINDS</span>
            <h2 class="h3 fw-bold mt-1 mb-0">Listings near you</h2>
        </div>
        <span class="text-muted small">{{ $listings->total() }} {{ $listings->total() === 1 ? 'listing' : 'listings' }}</span>
    </div>

    <form class="filter-bar row g-2 align-items-end mb-4" method="GET" action="{{ route('marketplace.home') }}">
        <div class="col-6 col-md-2">
            <label class="form-label small" for="filter-type">Listing type</label>
            <select class="form-select form-select-sm" id="filter-type" name="type">
                <option value="">Any type</option>
                <option value="product" @if(request('type') === 'product') selected @endif>Products</option>
                <option value="service" @if(request('type') === 'service') selected @endif>Services</option>
            </select>
        </div>
        <div class="col-6 col-md-2">
            <label class="form-label small" for="filter-min">Min price</label>
            <input class="form-control form-control-sm" id="filter-min" name="min_price" type="number" min="0" step="0.01" value="{{ request('min_price') }}" placeholder="0">
        </div>
        <div class="col-6 col-md-2">
            <label class="form-label small" for="filter-max">Max price</label>
            <input class="form-control form-control-sm" id="filter-max" name="max_price" type="number" min="0" step="0.01" value="{{ request('max_price') }}" placeholder="No limit">
        </div>
        @foreach (['q', 'city', 'category_id'] as $filter)
            @if(request($filter))
                <input type="hidden" name="{{ $filter }}" value="{{ request($filter) }}">
            @endif
        @endforeach
        <div class="col-6 col-md-2">
            <button class="btn btn-outline-dark btn-sm w-100" type="submit">Apply filters</button>
        </div>
        <div class="col-6 col-md-2">
            <a class="btn btn-link btn-sm text-muted" href="{{ route('marketplace.home') }}">Clear filters</a>
        </div>
    </form>

    @if ($listings->count())
        <div class="row g-4">
            @foreach ($listings as $listing)
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <a class="listing-card card h-100 text-decoration-none" href="{{ route('marketplace.listings.show', $listing->id) }}">
                        @if ($listing->image_path)
                            <img class="card-img-top listing-image" src="{{ asset('storage/'.$listing->image_path) }}" alt="{{ $listing->name }}">
                        @else
                            <div class="listing-image image-placeholder"><span>🐝</span></div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <span class="badge rounded-pill bg-light text-dark">{{ $listing->type === 'service' ? 'Service' : 'Product' }}</span>
                                <span class="small text-muted text-truncate">{{ $listing->category->name }}</span>
                            </div>
                            <h3 class="h6 fw-semibold mt-3 mb-2 text-dark">{{ $listing->name }}</h3>
                            <p class="price mb-2">₹{{ number_format((float) $listing->price, 2) }}</p>
                            <p class="small text-muted mt-auto mb-0">{{ $listing->city }}, {{ $listing->state }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="mt-4">{{ $listings->links() }}</div>
    @else
        <div class="empty-state text-center py-5">
            <div class="display-5">🔎</div>
            <h3 class="h5 fw-bold mt-3">No listings match those filters yet</h3>
            <p class="text-muted">Try another search, or be the first to post something in your area.</p>
            <a class="btn btn-honey" href="{{ route('marketplace.listings.create') }}">Post a listing</a>
        </div>
    @endif
</section>
@endsection
