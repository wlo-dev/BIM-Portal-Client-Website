<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = $request->user()->orders()->latest()->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Request $request, Order $order)
    {
        $this->authorizeOrder($request, $order);

        $order->load('items.product');

        return view('orders.show', compact('order'));
    }

    // DEMO PAYMENT: no card data is collected and no money moves.
    // A real build would redirect to a payment provider and mark the order paid
    // only after the provider confirms the payment.
    public function pay(Request $request, Order $order): RedirectResponse
    {
        $this->authorizeOrder($request, $order);

        if ($order->status === 'pending') {
            $order->update(['status' => 'paid', 'paid_at' => now()]);
        }

        return redirect()->route('orders.show', $order)
            ->with('status', 'Demo payment recorded. Your downloads are ready.');
    }

    public function download(Request $request, Order $order, Product $product)
    {
        $this->authorizeOrder($request, $order);

        abort_unless($order->status === 'paid', 403);
        abort_unless($order->items()->where('product_id', $product->id)->exists(), 404);
        abort_unless($product->file_path && Storage::disk('local')->exists($product->file_path), 404);

        $extension = pathinfo($product->file_path, PATHINFO_EXTENSION);

        return Storage::disk('local')->download($product->file_path, Str::slug($product->name) . '.' . $extension);
    }

    // Customers may only ever see their own orders.
    private function authorizeOrder(Request $request, Order $order): void
    {
        abort_unless($order->user_id === $request->user()->id, 404);
    }
}