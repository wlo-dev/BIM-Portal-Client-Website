@extends('layouts.app')

@section('title', 'Your cart | BIM PORTAL')

@section('content')
    <section class="bg-surface py-12">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <h1 class="font-display text-5xl font-bold uppercase text-ink">Your cart</h1>

            @if (session('status'))
                <div class="mt-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    {{ session('status') }}
                </div>
            @endif

            @if ($products->isEmpty())
                <div class="mt-8 rounded-xl border border-dashed border-line bg-white p-12 text-center">
                    <p class="text-muted">Your cart is empty.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-primary mt-6">Browse resources</a>
                </div>
            @else
                <div class="mt-8 divide-y divide-line overflow-hidden rounded-xl border border-line bg-white shadow-sm">
                    @foreach ($products as $product)
                        <div class="flex items-center gap-4 p-4">
                            @if ($product->image_path)
                                <img src="{{ asset($product->image_path) }}" alt="" class="h-20 w-20 rounded-md object-cover">
                            @else
                                <div class="flex h-20 w-20 items-center justify-center rounded-md bg-navy-900 text-[0.6rem] font-semibold uppercase text-white/50">No img</div>
                            @endif

                            <div class="min-w-0 flex-1">
                                <a href="{{ route('shop.show', $product) }}" class="font-display text-2xl font-bold uppercase text-ink hover:text-brand-600">{{ $product->name }}</a>
                                @if ($product->category)
                                    <p class="text-xs font-semibold uppercase tracking-widest text-muted">{{ $product->category->name }}</p>
                                @endif
                            </div>

                            <p class="font-bold text-ink">{{ $product->priceFormatted() }}</p>

                            <form method="POST" action="{{ route('cart.remove', $product) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-md p-2 text-sm font-semibold text-red-700 hover:bg-red-50" aria-label="Remove {{ $product->name }}">Remove</button>
                            </form>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 flex flex-col items-end gap-4">
                    <p class="text-2xl font-bold text-ink">Total: R {{ number_format($total / 100, 2) }}</p>

                    @if (\Illuminate\Support\Facades\Route::has('checkout.show'))
                        <a href="{{ route('checkout.show') }}" class="btn btn-primary">Proceed to checkout</a>
                    @endif
                </div>
            @endif
        </div>
    </section>
@endsection