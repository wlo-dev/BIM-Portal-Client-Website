@extends('layouts.app')

@section('title', 'Checkout | BIM PORTAL')

@section('content')
    <section class="bg-surface py-12">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <h1 class="font-display text-5xl font-bold uppercase text-ink">Checkout</h1>

            <div class="mt-8 divide-y divide-line overflow-hidden rounded-xl border border-line bg-white shadow-sm">
                @foreach ($products as $product)
                    <div class="flex items-center justify-between gap-4 p-4">
                        <span class="font-semibold text-ink">{{ $product->name }}</span>
                        <span class="font-bold text-ink">{{ $product->priceFormatted() }}</span>
                    </div>
                @endforeach
                <div class="flex items-center justify-between bg-surface p-4">
                    <span class="text-sm font-bold uppercase tracking-wider text-muted">Total</span>
                    <span class="text-2xl font-bold text-ink">R {{ number_format($total / 100, 2) }}</span>
                </div>
            </div>

            <form method="POST" action="{{ route('checkout.store') }}" class="mt-6 flex flex-wrap gap-3">
                @csrf
                <button type="submit" class="btn btn-primary">Place order</button>
                <a href="{{ route('cart.index') }}" class="btn btn-outline-dark">Back to cart</a>
            </form>
        </div>
    </section>
@endsection