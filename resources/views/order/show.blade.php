@extends('layouts.app')

@section('title', 'Order ' . $order->reference . ' | BIM PORTAL')

@section('content')
    <section class="bg-surface py-12">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <a href="{{ route('orders.index') }}" class="text-xs font-bold uppercase tracking-wider text-brand-600 hover:text-brand-500">← All orders</a>

            @if (session('status'))
                <div class="mt-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    {{ session('status') }}
                </div>
            @endif

            <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
                <h1 class="font-display text-4xl font-bold uppercase text-ink">Order {{ $order->reference }}</h1>
                @if ($order->status === 'paid')
                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-bold uppercase text-green-800">Paid</span>
                @else
                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-bold uppercase text-amber-800">Pending payment</span>
                @endif
            </div>

            <div class="mt-6 divide-y divide-line overflow-hidden rounded-xl border border-line bg-white shadow-sm">
                @foreach ($order->items as $item)
                    <div class="flex flex-wrap items-center justify-between gap-3 p-4">
                        <div>
                            <p class="font-semibold text-ink">{{ $item->name }}</p>
                            <p class="text-sm text-muted">R {{ number_format($item->price_cents / 100, 2) }}</p>
                        </div>

                        @if ($order->status === 'paid')
                            @if ($item->product && $item->product->file_path)
                                <a href="{{ route('orders.download', [$order, $item->product_id]) }}" class="btn btn-primary btn-sm">Download</a>
                            @else
                                <span class="text-sm text-muted">No file attached</span>
                            @endif
                        @endif
                    </div>
                @endforeach
                <div class="flex items-center justify-between bg-surface p-4">
                    <span class="text-sm font-bold uppercase tracking-wider text-muted">Total</span>
                    <span class="text-xl font-bold text-ink">{{ $order->totalFormatted() }}</span>
                </div>
            </div>

            @if ($order->status === 'pending')
                <div class="mt-6 rounded-xl border border-line bg-white p-6 shadow-sm">
                    <h2 class="font-display text-2xl font-bold uppercase text-ink">Payment</h2>
                    <p class="mt-2 text-sm text-muted">
                        Pay securely through SandboxPay, our simulated test-mode payment provider. No real money is taken.
                    </p>
                    <a href="{{ route('orders.payment', $order) }}" class="btn btn-primary mt-4">Pay {{ $order->totalFormatted() }}</a>
                </div>
            @endif

            @if ($payments->isNotEmpty())
                <div class="mt-6 overflow-hidden rounded-xl border border-line bg-white shadow-sm">
                    <h2 class="border-b border-line bg-surface px-4 py-3 text-xs font-bold uppercase tracking-wider text-muted">Payment history</h2>
                    <div class="divide-y divide-line">
                        @foreach ($payments as $payment)
                            <div class="flex flex-wrap items-center justify-between gap-3 p-4 text-sm">
                                <div>
                                    <p class="font-mono font-semibold text-ink">{{ $payment->transaction_id }}</p>
                                    <p class="text-muted">
                                        {{ $payment->card_brand }} ending {{ $payment->card_last4 }}
                                        · {{ $payment->created_at->format('d M Y, H:i') }}
                                    </p>
                                    @if ($payment->failure_reason)
                                        <p class="text-red-600">{{ $payment->failure_reason }}</p>
                                    @endif
                                </div>
                                @if ($payment->status === 'succeeded')
                                    <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-bold uppercase text-green-800">Approved</span>
                                @else
                                    <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-bold uppercase text-red-800">Declined</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection