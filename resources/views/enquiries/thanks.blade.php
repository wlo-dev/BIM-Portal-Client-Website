@extends('layouts.app')

@section('title', 'Enquiry received | BIM PORTAL')

@section('content')
    <section class="relative isolate flex min-h-[60vh] items-center justify-center overflow-hidden bg-navy-950 px-4 py-16">
        <div class="absolute inset-0 -z-10 bg-blueprint opacity-20"></div>
        <div class="absolute -right-24 top-10 -z-10 h-96 w-96 rounded-full bg-brand-600/30 blur-3xl"></div>

        <div class="w-full max-w-xl rounded-xl border border-white/10 bg-navy-900/80 p-8 text-center shadow-2xl backdrop-blur">
            <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-green-500/20 text-green-300">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="m5 12 5 5L20 7" /></svg>
            </span>
            <h1 class="mt-5 font-display text-4xl font-bold uppercase text-white">Your project enquiry has been received</h1>
            <p class="mt-3 text-white/75">
                Thank you for contacting BIM PORTAL. Your project information has been submitted and is now being reviewed.
            </p>
            <p class="mt-5 text-xs font-semibold uppercase tracking-widest text-brand-400">Enquiry reference</p>
            <p class="mt-1 font-mono text-2xl font-bold text-white">{{ $reference }}</p>
            <p class="mt-5 text-sm text-white/70">Our team will review the requirements and contact you about the next steps.</p>
            <a href="{{ route('home') }}" class="btn btn-primary mt-6">Back to home</a>
        </div>
    </section>
@endsection