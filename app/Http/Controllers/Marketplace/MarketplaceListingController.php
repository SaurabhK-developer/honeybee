<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\Controller;
use App\Marketplace\Category;
use App\Marketplace\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MarketplaceListingController extends Controller
{
    public function index()
    {
        $listings = Listing::with('category')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(12);

        return view('marketplace.my-listings', compact('listings'));
    }

    public function create()
    {
        $categories = Category::with('parent')->orderBy('name')->get();

        return view('marketplace.form', [
            'categories' => $categories,
            'listing' => new Listing(),
            'formAction' => route('marketplace.listings.store'),
            'formMethod' => 'POST',
            'heading' => 'Post a listing',
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedListing($request);
        $data['user_id'] = Auth::id();
        $data['status'] = 'active';

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('marketplace-listings', 'public');
        }

        $listing = Listing::create($data);

        return redirect()->route('marketplace.listings.show', $listing->id)
            ->with('success', 'Your listing has been posted.');
    }

    public function edit($id)
    {
        $listing = $this->ownedListing($id);
        $categories = Category::with('parent')->orderBy('name')->get();

        return view('marketplace.form', [
            'categories' => $categories,
            'listing' => $listing,
            'formAction' => route('marketplace.listings.update', $listing->id),
            'formMethod' => 'PUT',
            'heading' => 'Edit listing',
        ]);
    }

    public function update(Request $request, $id)
    {
        $listing = $this->ownedListing($id);
        $data = $this->validatedListing($request, true);
        $oldImage = $listing->image_path;

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('marketplace-listings', 'public');
        }

        $listing->update($data);

        if ($request->hasFile('image') && $oldImage) {
            Storage::disk('public')->delete($oldImage);
        }

        return redirect()->route('marketplace.listings.show', $listing->id)
            ->with('success', 'Your listing has been updated.');
    }

    public function destroy($id)
    {
        $listing = $this->ownedListing($id);
        $imagePath = $listing->image_path;
        $listing->delete();

        if ($imagePath) {
            Storage::disk('public')->delete($imagePath);
        }

        return redirect()->route('marketplace.my-listings')
            ->with('success', 'Your listing has been deleted.');
    }

    private function ownedListing($id): Listing
    {
        return Listing::where('user_id', Auth::id())->findOrFail($id);
    }

    private function validatedListing(Request $request, $includeStatus = false): array
    {
        $rules = [
            'category_id' => 'required|integer|exists:marketplace_categories,id',
            'type' => 'required|in:product,service',
            'name' => 'required|string|max:255',
            'detail' => 'required|string|max:5000',
            'country' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'area' => 'required|string|max:120',
            'price' => 'required|numeric|min:0|max:9999999999.99',
            'image' => 'nullable|image|max:5120',
        ];

        if ($includeStatus) {
            $rules['status'] = 'required|in:active,sold';
        }

        return $request->validate($rules);
    }
}
