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
@endsection