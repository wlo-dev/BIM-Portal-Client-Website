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
    ->when
    ->when
    ->when
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