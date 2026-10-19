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
                <a href="#" class="btn btn-primary">Request a Quote</a>
                <a href="#" class="btn btn-outline">Explore Our Services</a>
            </div>

            <a href="#" class="mt-6 inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-white/80 hover:text-white">
                View our work <span aria-hidden="true">→</span>
            </a>
        </div>
    </section>
        @php
        $benefits = [
            [
                'title' => 'Flexible Capacity',
                'text'  => 'Scale your team when you need it',
                'paths' => ['M22 7l-8.5 8.5-5-5L2 17', 'M16 7h6v6'],
            ],
            [
                'title' => 'Professional BIM Workflows',
                'text'  => 'Structured, consistent and reliable',
                'paths' => [
                    'M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z',
                    'M3.3 7 12 12l8.7-5',
                    'M12 22V12',
                ],
            ],
            [
                'title' => 'Remote Collaboration',
                'text'  => 'Work together from anywhere',
                'paths' => ['M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20', 'M2 12h20', 'M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20'],
            ],
            [
                'title' => 'Quality Assurance',
                'text'  => 'Every deliverable reviewed',
                'paths' => [
                    'M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z',
                    'm9 12 2 2 4-4',
                ],
            ],
            [
                'title' => 'Cost Efficient',
                'text'  => 'Get more done without overhead costs',
                'paths' => ['M4 6h16a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2z', 'M12 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4z', 'M6 12h.01M18 12h.01'],
            ],
        ];
    @endphp

    <section class="border-b border-line bg-white">
        <div class="mx-auto grid max-w-7xl grid-cols-1 gap-8 px-4 py-10 sm:grid-cols-2 sm:px-6 lg:grid-cols-5 lg:gap-0 lg:px-8">
            @foreach ($benefits as $item)
                <div class="flex items-start gap-4 lg:border-l lg:border-line lg:px-6 lg:first:border-l-0 lg:first:pl-0">
                    <svg class="h-9 w-9 shrink-0 text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        @foreach ($item['paths'] as $d)
                            <path d="{{ $d }}" />
                        @endforeach
                    </svg>
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-ink">{{ $item['title'] }}</h3>
                        <p class="mt-1 text-sm text-muted">{{ $item['text'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @php
    $service = [
    [
    'title' =>'BIM Modeling',
    'text'=> 'Accurate, coordinated BIM models for all project types.',
    'paths'=> [
     'M21 8a2 2 0 0 0-1-1.731-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8V8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z',
        'M12 22V12',
    ],
    ],
    [
    'title' => 'Revit Services',
    'text' => 'Revit modelling, family, documentation and technical support.',
    'paths' => [
            'm12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83Z',
            'm22 17.65-9.17 4.16a2 2 0 0 1-1.66 0L2 17.65',
            'm22 12.65-9.17 4.16a2 2 0 0 1-1.66 0L2 12.65',
        ],
    ],
    [
     'title' => 'Architectural Documentation',
                'text'  => 'High-quality drawings and documentation for construction and approvals.',
                'paths' => [
                    'M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z',
                    'M14 2v4a2 2 0 0 0 2 2h4',
                    'M10 9H8', 'M16 13H8', 'M16 17H8',
@endsection