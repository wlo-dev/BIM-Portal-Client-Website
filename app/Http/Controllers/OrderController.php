<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\PaystackCheckout;
use App\Services\SandboxGateway;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = $request->user()->orders()->latest()->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Request $request, Order $order, PaystackCheckout $gateway)
    {
        $this->authorizeOrder($request, $order);

        $order->load('items.product');
        $payments = $order->payments()->latest()->get();
        $gatewayEnabled = $gateway->enabled();

        return view('orders.show', compact('order', 'payments', 'gatewayEnabled'));
    }

    // ---------- Paystack (test mode) ----------

    public function gatewayStart(Request $request, Order $order, PaystackCheckout $gateway): RedirectResponse
    {
        $this->authorizeOrder($request, $order);

        if ($order->status !== 'pending' || ! $gateway->enabled()) {
            return redirect()->route('orders.show', $order);
        }

        // Each attempt needs its own reference.
        $reference = $order->reference . '-' . Str::lower(Str::random(6));

        try {
            $data = $gateway->initialize(
                $order,
                $request->user()->email,
                $reference,
                route('orders.gateway.return', $order)
            );
        } catch (\Throwable $e) {
            report($e);

            return redirect()->route('orders.show', $order)
                ->withErrors(['payment' => 'We could not start the payment. Please try again.']);
        }

        return redirect()->away($data['authorization_url']);
    }

    public function gatewayReturn(Request $request, Order $order, PaystackCheckout $gateway): RedirectResponse
    {
        $this->authorizeOrder($request, $order);

        if ($order->status === 'paid') {
            return redirect()->route('orders.show', $order);
        }

        $reference = (string) ($request->query('reference') ?? $request->query('trxref'));

        // The reference must belong to this order.
        if (! str_starts_with($reference, $order->reference . '-')) {
            return redirect()->route('orders.show', $order);
        }

        try {
            $data = $gateway->verify($reference);
        } catch (\Throwable $e) {
            report($e);

            return redirect()->route('orders.show', $order)
                ->withErrors(['payment' => 'We could not confirm the payment yet. Please refresh in a moment.']);
        }

        // Trust Paystack's answer, not the browser: check status, reference, amount and currency.
        $valid = ($data['status'] ?? null) === 'success'
            && ($data['reference'] ?? null) === $reference
            && (int) ($data['amount'] ?? 0) === $order->total_cents
            && strtoupper($data['currency'] ?? '') === strtoupper(config('services.paystack.currency'));

        if (! $valid) {
            return redirect()->route('orders.show', $order)
                ->withErrors(['payment' => 'The payment was not completed, so your order is still pending.']);
        }

        $authorization = $data['authorization'] ?? [];
        $brand = trim((string) ($authorization['brand'] ?? $authorization['card_type'] ?? ''));
        $last4 = $authorization['last4'] ?? null;

        // Only safe details are saved: the provider's reference, brand and last four digits.
        $order->payments()->firstOrCreate(
            ['transaction_id' => substr($reference, 0, 40)],
            [
                'provider' => 'paystack',
                'amount_cents' => $order->total_cents,
                'currency' => strtoupper(config('services.paystack.currency')),
                'status' => 'succeeded',
                'card_brand' => $brand !== '' ? ucfirst($brand) : null,
                'card_last4' => $last4 ? substr($last4, -4) : null,
            ]
        );

        $order->update(['status' => 'paid', 'paid_at' => now()]);

        return redirect()->route('orders.show', $order)
            ->with('status', 'Payment confirmed by Paystack. Reference ' . $reference . '. Your downloads are ready.');
    }

    // ---------- SandboxPay (fallback when no Paystack key is set) ----------

    public function payment(Request $request, Order $order)
    {
        $this->authorizeOrder($request, $order);

        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order);
        }

        return view('orders.payment', compact('order'));
    }

    public function pay(Request $request, Order $order, SandboxGateway $gateway): RedirectResponse
    {
        $this->authorizeOrder($request, $order);

        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order);
        }

        $validator = Validator::make($request->all(), [
            'card_number' => ['bail', 'required', 'string', 'max:25', function ($attribute, $value, $fail) use ($gateway) {
                if (! $gateway->isTestCard($value)) {
                    $fail('This sandbox only accepts the test cards listed on this page.');
                }
            }],
            'expiry' => ['bail', 'required', 'regex:/^(0[1-9]|1[0-2])\s*\/\s*\d{2}$/', function ($attribute, $value, $fail) {
                [$month, $year] = array_map('trim', explode('/', $value));
                $expires = Carbon::createFromDate(2000 + (int) $year, (int) $month, 1)->endOfMonth();

                if ($expires->isPast()) {
                    $fail('This card has expired.');
                }
            }],
            'cvc' => ['required', 'digits_between:3,4'],
        ]);

        // We redirect with the errors only, never with the typed card details.
        if ($validator->fails()) {
            return redirect()->route('orders.payment', $order)->withErrors($validator);
        }

        $data = $validator->validated();

        $result = $gateway->charge($order, $data['card_number']);

        // Only safe details are saved: never the card number, expiry or CVC.
        $order->payments()->create([
            'provider' => 'sandbox',
            'transaction_id' => $result['transaction_id'],
            'amount_cents' => $result['amount_cents'],
            'currency' => 'ZAR',
            'status' => $result['status'],
            'failure_reason' => $result['status'] === 'succeeded' ? null : $result['message'],
            'card_brand' => $result['brand'],
            'card_last4' => $result['last4'],
        ]);

        if ($result['status'] !== 'succeeded') {
            return redirect()->route('orders.payment', $order)
                ->withErrors(['payment' => $result['message'] . ' Your order is still pending, so you can try again.']);
        }

        $order->update(['status' => 'paid', 'paid_at' => now()]);

        return redirect()->route('orders.show', $order)
            ->with('status', 'Payment approved. Transaction ' . $result['transaction_id'] . '. Your downloads are ready.');
    }

    // ---------- Downloads ----------

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