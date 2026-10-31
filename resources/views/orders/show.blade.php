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
 
            @if ($errors->has('payment'))
                <div class="mt-4 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    {{ $errors->first('payment') }}
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
                    </div>
                @endforeach
 
                <div class="flex items-center justify-between bg-surface p-4">
                    <span class="text-sm font-bold uppercase tracking-wider text-ink">Total</span>
                    <span class="font-semibold text-ink">R {{ number_format($order->items->sum('price_cents') / 100, 2) }}</span>
                </div>
            </div>
        </div>
    </section>
    @if ($order->status !== 'paid')
    <form method="POST" action="{{ route('orders.pay', $order) }}" class="mt-6">
        @csrf
        <button type="submit" class="w-full rounded-md bg-brand-600 px-6 py-3 text-sm font-bold uppercase tracking-wider text-white hover:bg-brand-500">
            Pay with Paystack
        </button>
    </form>
@endif
@endsection