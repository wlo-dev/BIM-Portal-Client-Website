<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Str;

/**
 * A simulated payment provider for demonstration.
 * No money moves and only the sandbox test cards below are accepted.
 * To go live, replace charge() with a call to a real provider (for example PayFast or Paystack).
 */
class SandboxGateway
{
    private const TEST_CARDS = [
        '4242424242424242' => ['brand' => 'Visa', 'result' => 'success'],
        '5555555555554444' => ['brand' => 'Mastercard', 'result' => 'success'],
        '4000000000000002' => ['brand' => 'Visa', 'result' => 'declined', 'reason' => 'Your card was declined.'],
        '4000000000009995' => ['brand' => 'Visa', 'result' => 'declined', 'reason' => 'Insufficient funds.'],
    ];

    public function isTestCard(string $number): bool
    {
        return array_key_exists($this->digits($number), self::TEST_CARDS);
    }

    public function charge(Order $order, string $number): array
    {
        $digits = $this->digits($number);
        $card = self::TEST_CARDS[$digits];
        $succeeded = $card['result'] === 'success';

        return [
            'status' => $succeeded ? 'succeeded' : 'declined',
            'transaction_id' => 'SBX-' . strtoupper(Str::random(10)),
            'amount_cents' => $order->total_cents,
            'message' => $succeeded ? 'Payment approved.' : $card['reason'],
            'brand' => $card['brand'],
            'last4' => substr($digits, -4),
        ];
    }

    private function digits(string $value): string
    {
        return preg_replace('/\D/', '', $value);
    }
}