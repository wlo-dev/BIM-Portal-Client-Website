@extends('layouts.app')

@section('content')
    <section class="relative isolate flex min-h-[80vh] items-center overflow-hidden bg-navy-950">
        @if (file_exists(public_path('images/hero.jpg')))
            <img src="{{ asset('images/hero.jpg') }}" alt=""
                 class="absolute inset-0 -z-30 h-full w-full object-cover object-right">
        @endif

        <div class="absolute inset-0 -z-20 bg-linear-to-r from-navy-950 from-30% via-navy-950/70 via-50% to-transparent"></div>
        <div class="absolute inset-0 -z-10 bg-blueprint opacity-20"></div>
        <div class="absolute -right-24 top-10 -z-10 h-96 w-96 rounded-full bg-brand-600/30 blur-3xl"></div>

        <div class="mx-auto w-full max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <p class="mb-5 inline-flex items-center gap-2 rounded-full border border-brand-400/40 bg-brand-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-widest text-brand-400">
                <span class="h-1.5 w-1.5 rounded-full bg-brand-400"></span>
                BIM · Revit · Documentation
            </p>

            <h1 class="max-w-3xl font-display text-5xl font-bold uppercase leading-[0.95] text-white sm:text-6xl lg:text-7xl">
                Your BIM Production <span class="text-brand-400">Partner</span>
            </h1>

            <p class="mt-6 max-w-xl text-lg text-white/85">
                Professional BIM, Revit and documentation services that help architectural,
                engineering and construction businesses deliver with confidence.
            </p>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('quote.create') }}>Request a Quote</a>
                <a href="#" class="btn btn-outline">Explore Our Services</a>
            </div>

            <a href="#" class="mt-6 inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-white/80 hover:text-white">
                View our work <span aria-hidden="true">→</span>
            </a>
        </div>
    </section>

    @php
        $benefits = [
            ['icon' => 'trending-up', 'title' => 'Flexible Capacity', 'text' => 'Scale your team when you need it'],
            ['icon' => 'box', 'title' => 'Professional BIM Workflows', 'text' => 'Structured, consistent and reliable'],
            ['icon' => 'globe', 'title' => 'Remote Collaboration', 'text' => 'Work together from anywhere'],
            ['icon' => 'shield-check', 'title' => 'Quality Assurance', 'text' => 'Every deliverable reviewed'],
            ['icon' => 'banknote', 'title' => 'Cost Efficient', 'text' => 'Get more done without overhead costs'],
        ];

        $services = [
            ['icon' => 'box', 'title' => 'BIM Modelling', 'text' => 'Accurate, coordinated BIM models for all project types.'],
            ['icon' => 'layers', 'title' => 'Revit Services', 'text' => 'Revit modelling, families, documentation and technical support.'],
            ['icon' => 'file-text', 'title' => 'Architectural Documentation', 'text' => 'High-quality drawings and documentation for construction and approvals.'],
            ['icon' => 'crosshair', 'title' => 'CAD Services', 'text' => '2D drafting, CAD conversion and technical drawing production.'],
        ];
    @endphp

    <section class="border-b border-line bg-white">
        <div class="mx-auto grid max-w-7xl grid-cols-1 gap-8 px-4 py-10 sm:grid-cols-2 sm:px-6 lg:grid-cols-5 lg:gap-0 lg:px-8">
            @foreach ($benefits as $item)
                <div class="flex items-start gap-4 lg:border-l lg:border-line lg:px-6 lg:first:border-l-0 lg:first:pl-0">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-linear-to-br from-brand-500 to-brand-700 text-white shadow-lg shadow-brand-600/25">
                        <x-icon :name="$item['icon']" class="h-6 w-6" />
                    </span>
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-ink">{{ $item['title'] }}</h3>
                        <p class="mt-1 text-sm text-muted">{{ $item['text'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="bg-surface py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="reveal flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
                <div class="max-w-2xl">
                    <p class="text-xs font-semibold uppercase tracking-widest text-brand-600">What we do</p>
                    <h2 class="mt-2 font-display text-4xl font-bold uppercase text-ink sm:text-5xl">Our Services</h2>
                    <p class="mt-4 text-lg text-muted">End-to-end BIM and technical services to support your projects.</p>
                </div>
                <a href="#" class="btn btn-outline-dark self-start sm:self-auto">View all services</a>
            </div>

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($services as $service)
                    <div class="reveal" style="--delay: {{ $loop->index * 100 }}ms">
                        <a href="#" class="group flex h-full flex-col rounded-xl border border-line bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-brand-500 hover:shadow-xl">
                            <span class="flex h-14 w-14 items-center justify-center rounded-xl bg-linear-to-br from-brand-500 to-brand-700 text-white shadow-lg shadow-brand-600/30 transition duration-300 group-hover:rotate-3 group-hover:scale-110">
                                <x-icon :name="$service['icon']" class="h-7 w-7" />
                            </span>
                            <h3 class="mt-5 font-display text-2xl font-bold uppercase text-ink">{{ $service['title'] }}</h3>
                            <p class="mt-2 text-sm leading-relaxed text-muted">{{ $service['text'] }}</p>
                            <span class="mt-auto inline-flex items-center gap-1 pt-6 text-xs font-bold uppercase tracking-wider text-brand-600">
                                Learn more
                                <span class="transition group-hover:translate-x-1" aria-hidden="true">→</span>
                            </span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection