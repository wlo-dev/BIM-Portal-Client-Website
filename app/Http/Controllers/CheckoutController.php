<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        $products = $this->cartProducts($request);

        if ($products->isEmpty()) {
            return redirect()->route('cart.index');
        }

        return view('checkout.show', [
            'products' => $products,
            'total' => $products->sum('price_cents'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $products = $this->cartProducts($request);

        if ($products->isEmpty()) {
            return redirect()->route('cart.index');
        }

        // Everything inside the transaction succeeds together or not at all.
        $order = DB::transaction(function () use ($request, $products) {
            $order = Order::create([
                'user_id' => $request->user()->id,
                'reference' => 'BP-' . now()->format('Y') . '-' . strtoupper(Str::random(6)),
                'status' => 'pending',
                'total_cents' => $products->sum('price_cents'), // from the database, never from the browser
            ]);

            foreach ($products as $product) {
                $order->items()->create([
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price_cents' => $product->price_cents,
                    'quantity' => 1,
                ]);
            }

            return $order;
        });

        $request->session()->forget('cart');

        return redirect()->route('orders.show', $order)
            ->with('status', 'Order placed. Complete the demo payment to unlock your downloads.');
    }

    private function cartProducts(Request $request)
    {
        return Product::published()
            ->whereIn('id', $request->session()->get('cart', []))
            ->get();
    }
}