<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $products = $this->cartProducts($request);
        $total = $products->sum('price_cents');

        return view('cart.index', compact('products', 'total'));
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        abort_unless($product->is_published, 404);

        $ids = $request->session()->get('cart', []);

        if (! in_array($product->id, $ids)) {
            $ids[] = $product->id;
        }

        $request->session()->put('cart', $ids);

        return redirect()->route('cart.index')->with('status', $product->name . ' was added to your cart.');
    }

    public function remove(Request $request, Product $product): RedirectResponse
    {
        $ids = array_values(array_diff($request->session()->get('cart', []), [$product->id]));

        $request->session()->put('cart', $ids);

        return back()->with('status', 'Item removed from your cart.');
    }

    private function cartProducts(Request $request)
    {
        $ids = $request->session()->get('cart', []);

        return Product::published()->whereIn('id', $ids)->get();
    }
}