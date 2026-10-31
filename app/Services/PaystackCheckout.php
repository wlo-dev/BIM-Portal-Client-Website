<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;

/**
 * Talks to Paystack (test mode when the key starts with sk_test_).
 * The card is entered on Paystack's own hosted page, so card details never reach this server.
 */
class PaystackCheckout
{
    private const BASE = 'https://api.paystack.co';

    public function enabled(): bool
    {
        return filled(config('services.paystack.secret'));
    }

    public function initialize(Order $order, string $email, string $reference, string $callbackUrl): array
    {
        return Http::withToken(config('services.paystack.secret'))
            ->post(self::BASE . '/transaction/initialize', [
                'email' => $email,
                'amount' => $order->total_cents, // Paystack takes the smallest currency unit (cents)
                'currency' => config('services.paystack.currency'),
                'reference' => $reference,
                'callback_url' => $callbackUrl,
            ])
            ->throw()
            ->json('data');
    }

    public function verify(string $reference): array
    {
        return Http::withToken(config('services.paystack.secret'))
            ->get(self::BASE . '/transaction/verify/' . rawurlencode($reference))
            ->throw()
            ->json('data') ?? [];
    }
}