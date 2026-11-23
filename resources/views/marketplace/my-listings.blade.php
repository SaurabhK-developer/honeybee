@extends('marketplace.layout')

@section('title', 'My listings | Honeybee Marketplace')

@section('content')
<section class="container py-5">
    <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mb-4">
        <div>
            <span class="eyebrow">YOUR ACCOUNT</span>
            <h1 class="h2 fw-bold mt-1 mb-0">My listings</h1>
        </div>
        <a class="btn btn-honey" href="{{ route('marketplace.listings.create') }}">＋ Post a new ad</a>
    </div>
    @if ($listings->count())
        <div class="table-responsive bg-white rounded-3 border">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr><th>Listing</th><th>Category</th><th>Price</th><th>Status</th><th class="text-end">Actions</th></tr>
                </thead>
                <tbody>
                    @foreach ($listings as $listing)
                        <tr>
                            <td>
                                <a class="fw-semibold text-dark text-decoration-none" href="{{ route('marketplace.listings.show', $listing->id) }}">{{ $listing->name }}</a>
                                <div class="small text-muted">{{ $listing->city }}, {{ $listing->state }}</div>
                            </td>
                            <td>{{ $listing->category->name }}</td>
                            <td class="price">₹{{ number_format((float) $listing->price, 2) }}</td>
                            <td><span class="badge {{ $listing->status === 'active' ? 'text-bg-success' : 'text-bg-secondary' }}">{{ ucfirst($listing->status) }}</span></td>
                            <td class="text-end text-nowrap">
                                <a class="btn btn-sm btn-outline-dark" href="{{ route('marketplace.listings.edit', $listing->id) }}">Edit</a>
                                <form class="d-inline" method="POST" action="{{ route('marketplace.listings.destroy', $listing->id) }}" onsubmit="return confirm('Delete this listing?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $listings->links() }}</div>
    @else
        <div class="empty-state text-center py-5">
            <div class="display-5">📦</div>
            <h2 class="h5 fw-bold mt-3">You haven't posted anything yet</h2>
            <p class="text-muted">Create your first listing to reach local buyers.</p>
            <a class="btn btn-honey" href="{{ route('marketplace.listings.create') }}">Post a listing</a>
        </div>
    @endif
</section>
@endsection
