@extends('layouts.app')

@section('title', $product->name . ' | BIM PORTAL')

@section('content')
    <section class="bg-surface py-12">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <a href="{{ route('shop.index') }}" class="text-xs font-bold uppercase tracking-wider text-brand-600 hover:text-brand-500">← Back to resources</a>

            <div class="mt-6 grid gap-10 lg:grid-cols-2">
                <div class="overflow-hidden rounded-xl border border-line bg-navy-900 shadow-sm">
                    @if ($product->image_path)
                        <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" class="aspect-[4/3] w-full object-cover">
                    @else
                        <div class="flex aspect-[4/3] items-center justify-center bg-blueprint text-xs font-semibold uppercase tracking-widest text-white/50">No image</div>
                    @endif
                </div>

                <div>
                    @if ($product->category)
                        <p class="text-xs font-semibold uppercase tracking-widest text-brand-600">{{ $product->category->name }}</p>
                    @endif
                    <h1 class="mt-2 font-display text-5xl font-bold uppercase text-ink">{{ $product->name }}</h1>
                    <p class="mt-4 text-3xl font-bold text-ink">{{ $product->priceFormatted() }}</p>

                    <div class="mt-6 whitespace-pre-line leading-relaxed text-muted">{{ $product->description }}</div>
                </div>
            </div>
        </div>
    </section>
@endsection