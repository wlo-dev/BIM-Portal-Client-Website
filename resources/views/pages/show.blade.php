@extends('layouts.app')

@section('title', $page['title'] . ' | BIM PORTAL')

@section('content')
    <section class="relative isolate overflow-hidden bg-navy-950 py-16 sm:py-20">
        <div class="absolute inset-0 -z-10 bg-blueprint opacity-20"></div>
        <div class="absolute -right-24 top-0 -z-10 h-80 w-80 rounded-full bg-brand-600/30 blur-3xl"></div>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <p class="text-xs font-semibold uppercase tracking-widest text-brand-400">{{ $page['eyebrow'] }}</p>
            <h1 class="mt-2 font-display text-5xl font-bold uppercase text-white sm:text-6xl">{{ $page['title'] }}</h1>
            <p class="mt-4 max-w-2xl text-lg text-white/80">{{ $page['intro'] }}</p>
        </div>
    </section>

    <section class="bg-surface py-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if (! empty($page['note']))
                <p class="mb-8 rounded-md border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">{{ $page['note'] }}</p>
            @endif

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($page['items'] as $item)
                    <div class="reveal" style="--delay: {{ ($loop->index % 3) * 100 }}ms">
                        <div class="flex h-full flex-col rounded-xl border border-line bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-brand-500 hover:shadow-xl">
                            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-linear-to-br from-brand-500 to-brand-700 font-display text-xl font-bold text-white shadow-lg shadow-brand-600/30">
                                {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            <h2 class="mt-5 font-display text-2xl font-bold uppercase text-ink">{{ $item['title'] }}</h2>
                            <p class="mt-2 text-sm leading-relaxed text-muted">{{ $item['text'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            @if (\Illuminate\Support\Facades\Route::has('quote.create'))
                <div class="mt-12 text-center">
                    <a href="{{ route('quote.create') }}" class="btn btn-primary">Request a quote</a>
                </div>
            @endif
        </div>
    </section>
@endsection