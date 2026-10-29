@extends('layouts.app')

@section('title', 'BIM Resources | BIM PORTAL')

@section('content')
    <section class="relative isolate overflow-hidden bg-navy-950 py-16 sm:py-20">
        <div class="absolute inset-0 -z-10 bg-blueprint opacity-20"></div>
        <div class="absolute -right-24 top-0 -z-10 h-80 w-80 rounded-full bg-brand-600/30 blur-3xl"></div>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <p class="text-xs font-semibold uppercase tracking-widest text-brand-400">Digital marketplace</p>
            <h1 class="mt-2 font-display text-5xl font-bold uppercase text-white sm:text-6xl">BIM Resources</h1>
            <p class="mt-4 max-w-2xl text-lg text-white/80">Revit families, templates, CAD resources and documentation, ready to download.</p>
        </div>
    </section>

    <section class="bg-surface py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <form method="GET" action="{{ route('shop.index') }}" class="grid gap-3 rounded-xl border border-line bg-white p-4 shadow-sm sm:grid-cols-2 lg:grid-cols-[1fr_14rem_14rem_auto]">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Search resources"
                       class="rounded-md border border-line px-4 py-3 text-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/30">

                <select name="category" class="rounded-md border border-line bg-white px-4 py-3 text-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/30">
                    <option value="">All categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->name }}</option>
                    @endforeach
                </select>

                <select name="sort" class="rounded-md border border-line bg-white px-4 py-3 text-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/30">
                    <option value="newest" @selected($sort === 'newest')>Newest first</option>
                    <option value="price_asc" @selected($sort === 'price_asc')>Price: low to high</option>
                    <option value="price_desc" @selected($sort === 'price_desc')>Price: high to low</option>
                </select>

                <button type="submit" class="btn btn-primary">Filter</button>
            </form>

            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($products as $product)
                    <a href="{{ route('shop.show', $product) }}"
                       class="group flex flex-col overflow-hidden rounded-xl border border-line bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:border-brand-500 hover:shadow-xl">
                        <div class="aspect-[4/3] overflow-hidden bg-navy-900">
                            @if ($product->image_path)
                                <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}"
                                     class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                            @else
                                <div class="flex h-full items-center justify-center bg-blueprint text-xs font-semibold uppercase tracking-widest text-white/50">No image</div>
                            @endif
                        </div>
                        <div class="flex flex-1 flex-col p-5">
                            @if ($product->category)
                                <p class="text-xs font-semibold uppercase tracking-widest text-brand-600">{{ $product->category->name }}</p>
                            @endif
                            <h2 class="mt-1 font-display text-2xl font-bold uppercase text-ink">{{ $product->name }}</h2>
                            <div class="mt-auto flex items-center justify-between pt-5">
                                <span class="text-lg font-bold text-ink">{{ $product->priceFormatted() }}</span>
                                <span class="inline-flex items-center gap-1 text-xs font-bold uppercase tracking-wider text-brand-600">
                                    View <span class="transition group-hover:translate-x-1" aria-hidden="true">→</span>
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full rounded-xl border border-dashed border-line bg-white p-12 text-center text-muted">
                        No resources match your search yet.
                    </div>
                @endforelse
            </div>

            <div class="mt-10">
                {{ $products->links() }}
            </div>
        </div>
    </section>
@endsection