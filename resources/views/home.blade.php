@extends('layouts.app')

@section('content')
    <section class="relative overflow-hidden bg-navy-900 bg-blueprint">
        <div class="pointer-events-none absolute -right-32 top-0 h-[32rem] w-[32rem] rounded-full bg-brand-600/30 blur-3xl" aria-hidden="true"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 sm:py-28 lg:px-8 lg:py-36">
            <div class="max-w-2xl">
                <h1 class="font-display text-5xl font-bold uppercase leading-[0.95] text-white sm:text-6xl lg:text-7xl">
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
        </div>
    </section>
@endsection