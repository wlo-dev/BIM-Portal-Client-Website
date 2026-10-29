<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;


class ShopController extends Controller
{

public function index(Request $request)
{
    $categories = Category::orderBy('name')->get();
    $sort = $request->query('sort', 'newest');

    $products = Products::published()
    ->with('category')
    ->when($request->query('q'), fn ($query, $term) => $query->where('name', 'ilike', '%'. $term. '%'))
    ->when($request->query('category'), fn ($query, $slug) => $query->whereHas('category', fn ($c) => $c->where('slug', $slug)))
    ->when($sort ==='price_asc', fn ($query)=> $query->orderBy('price_cents'))
    ->when($sort === 'price_desc' , fn ($query) => $query->orderByDesc('price_cents'))
    ->when(! in_array($sort,['price_asc', 'price_desc']), fn($query) =>query->latest())
    ->paginate(9)
    ->withQueryString();

    return view('shop.index', compact('products','categories', 'sort'));
    
}
public function show(Product $product)
{
// Drafts are invisible to the public, even if someone guessed the address
abort_unless($product->is_published, 404);


return view('shop.show' , compact('product'));

}
}