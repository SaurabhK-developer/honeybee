<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\Controller;
use App\Marketplace\Category;
use App\Marketplace\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketplaceController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'q' => 'nullable|string|max:120',
            'city' => 'nullable|string|max:100',
            'category_id' => 'nullable|integer|exists:marketplace_categories,id',
            'type' => 'nullable|in:product,service',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
        ]);

        if (isset($filters['min_price'], $filters['max_price']) &&
            $filters['min_price'] > $filters['max_price']) {
            return redirect()->route('marketplace.home')
                ->withInput()
                ->withErrors(['max_price' => 'Maximum price must be greater than or equal to minimum price.']);
        }

        $listings = Listing::with(['category', 'user'])
            ->where('status', 'active')
            ->when(!empty($filters['q']), function ($query) use ($filters) {
                $term = $filters['q'];
                $query->where(function ($search) use ($term) {
                    $search->where('name', 'like', '%'.$term.'%')
                        ->orWhere('detail', 'like', '%'.$term.'%');
                });
            })
            ->when(!empty($filters['city']), function ($query) use ($filters) {
                $query->where('city', 'like', '%'.$filters['city'].'%');
            })
            ->when(!empty($filters['category_id']), function ($query) use ($filters) {
                $category = Category::with('children')->findOrFail($filters['category_id']);
                $categoryIds = $category->children->pluck('id')->push($category->id);
                $query->whereIn('category_id', $categoryIds);
            })
            ->when(!empty($filters['type']), function ($query) use ($filters) {
                $query->where('type', $filters['type']);
            })
            ->when(isset($filters['min_price']), function ($query) use ($filters) {
                $query->where('price', '>=', $filters['min_price']);
            })
            ->when(isset($filters['max_price']), function ($query) use ($filters) {
                $query->where('price', '<=', $filters['max_price']);
            })
            ->latest()
            ->paginate(12)
            ->appends($request->query());

        $categories = Category::whereNull('parent_id')->with('children')->orderBy('name')->get();

        return view('marketplace.index', compact('listings', 'categories'));
    }

    public function show($id)
    {
        $listing = Listing::with(['category', 'user'])->findOrFail($id);

        if ($listing->status !== 'active' &&
            (!Auth::check() || Auth::id() !== $listing->user_id)) {
            abort(404);
        }

        return view('marketplace.show', compact('listing'));
    }
}
