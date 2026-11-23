@extends('marketplace.layout')

@section('title', $heading.' | Honeybee Marketplace')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <a class="small text-muted text-decoration-none" href="{{ route('marketplace.home') }}">← Back to marketplace</a>
            <h1 class="h2 fw-bold mt-3">{{ $heading }}</h1>
            <p class="text-muted mb-4">Share the details so people nearby can find what they need.</p>

            <form class="form-panel p-4 p-md-5" method="POST" action="{{ $formAction }}" enctype="multipart/form-data">
                @csrf
                @if ($formMethod !== 'POST')
                    @method($formMethod)
                @endif
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="name">Listing title</label>
                        <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $listing->name) }}" maxlength="255" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="category_id">Category</label>
                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                            <option value="">Choose a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if((string) old('category_id', $listing->category_id) === (string) $category->id) selected @endif>
                                    {{ $category->parent ? $category->parent->name.' · ' : '' }}{{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="type">Type</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="product" @if(old('type', $listing->type) === 'product') selected @endif>Product</option>
                            <option value="service" @if(old('type', $listing->type) === 'service') selected @endif>Service</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="price">Price (₹)</label>
                        <input class="form-control @error('price') is-invalid @enderror" id="price" name="price" type="number" min="0" max="9999999999.99" step="0.01" value="{{ old('price', $listing->price) }}" required>
                        @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="detail">Description</label>
                        <textarea class="form-control @error('detail') is-invalid @enderror" id="detail" name="detail" rows="5" maxlength="5000" required>{{ old('detail', $listing->detail) }}</textarea>
                        @error('detail') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="country">Country</label>
                        <input class="form-control" id="country" name="country" value="{{ old('country', $listing->country ?: 'India') }}" maxlength="100" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="state">State</label>
                        <input class="form-control" id="state" name="state" value="{{ old('state', $listing->state) }}" maxlength="100" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="city">City</label>
                        <input class="form-control" id="city" name="city" value="{{ old('city', $listing->city) }}" maxlength="100" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="area">Area / neighbourhood</label>
                        <input class="form-control" id="area" name="area" value="{{ old('area', $listing->area) }}" maxlength="120" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="image">Photo <span class="text-muted fw-normal">(optional, max 5 MB)</span></label>
                        <input class="form-control @error('image') is-invalid @enderror" id="image" name="image" type="file" accept="image/*">
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        @if ($listing->image_path)
                            <img class="form-image-preview mt-3" src="{{ asset('storage/'.$listing->image_path) }}" alt="Current listing photo">
                        @endif
                    </div>
                    @if ($formMethod !== 'POST')
                        <div class="col-md-6">
                            <label class="form-label" for="status">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="active" @if(old('status', $listing->status) === 'active') selected @endif>Active</option>
                                <option value="sold" @if(old('status', $listing->status) === 'sold') selected @endif>Sold</option>
                            </select>
                        </div>
                    @endif
                    <div class="col-12 pt-2">
                        <button class="btn btn-honey btn-lg" type="submit">{{ $formMethod === 'POST' ? 'Publish listing' : 'Save changes' }}</button>
                        <a class="btn btn-link text-muted ms-2" href="{{ route('marketplace.my-listings') }}">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
