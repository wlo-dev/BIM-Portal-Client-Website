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
                <div class="mt-6 rounded-xl border border-amber-200 bg-amber-50 p-6">
                    <h2 class="font-display text-2xl font-bold uppercase text-amber-900">Demo payment</h2>
                    <p class="mt-2 text-sm text-amber-900">
                        This is a simulated payment for demonstration. No card details are collected and no money is taken.
                        A live site would send you to a secure payment provider here.
                    </p>
                    <form method="POST" action="{{ route('orders.pay', $order) }}" class="mt-4">
                        @csrf
                        <button type="submit" class="btn btn-primary">Pay {{ $order->totalFormatted() }} (demo)</button>
                    </form>
                </div>
            @endif
        </div>
    </section>
@endsection