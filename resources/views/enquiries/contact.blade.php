@extends('layouts.app')

@section('title', 'Contact | BIM PORTAL')

@section('content')
    @php
        $input = 'mt-2 block w-full rounded-md border border-line bg-white px-4 py-3 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/30';
        $label = 'block text-xs font-semibold uppercase tracking-wider text-muted';
    @endphp

    <section class="relative isolate overflow-hidden bg-navy-950 py-16 sm:py-20">
        <div class="absolute inset-0 -z-10 bg-blueprint opacity-20"></div>
        <div class="absolute -right-24 top-0 -z-10 h-80 w-80 rounded-full bg-brand-600/30 blur-3xl"></div>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <p class="text-xs font-semibold uppercase tracking-widest text-brand-400">Get in touch</p>
            <h1 class="mt-2 font-display text-5xl font-bold uppercase text-white sm:text-6xl">Contact</h1>
            <p class="mt-4 max-w-2xl text-lg text-white/80">Questions about our services, training or partnerships? Send us a message.</p>
        </div>
    </section>

    <section class="bg-surface py-14">
        <div class="mx-auto grid max-w-6xl gap-8 px-4 sm:px-6 lg:grid-cols-[1fr_20rem] lg:px-8">
            <div class="rounded-xl border border-line bg-white p-6 shadow-sm sm:p-8">
                @if (session('status'))
                    <div class="mb-6 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                        {{ session('status') }}
                    </div>
                @endif

                <h2 class="font-display text-3xl font-bold uppercase text-ink">General enquiry</h2>
                <p class="mt-2 text-sm text-muted">
                    Have a project that needs BIM capacity?
                    <a href="{{ route('quote.create') }}" class="font-semibold text-brand-600 hover:text-brand-500">Request a quote</a>
                    instead so we can price it properly.
                </p>

                <form method="POST" action="{{ route('contact.store') }}" class="mt-6 space-y-5">
                    @csrf

                    {{-- Honeypot: hidden from people, filled in by bots. --}}
                    <div class="absolute -left-[9999px]" aria-hidden="true">
                        <label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="name" class="{{ $label }}">Full name</label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" required autocomplete="name" class="{{ $input }}">
                            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="email" class="{{ $label }}">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" class="{{ $input }}">
                            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="phone" class="{{ $label }}">Phone (optional)</label>
                            <input id="phone" name="phone" type="text" value="{{ old('phone') }}" autocomplete="tel" class="{{ $input }}">
                            @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="subject" class="{{ $label }}">Subject</label>
                            <input id="subject" name="subject" type="text" value="{{ old('subject') }}" required class="{{ $input }}">
                            @error('subject') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="message" class="{{ $label }}">Message</label>
                        <textarea id="message" name="message" rows="6" required class="{{ $input }}">{{ old('message') }}</textarea>
                        @error('message') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Send message</button>
                </form>
            </div>

            <aside class="space-y-4">
                <div class="rounded-xl border border-line bg-white p-6 shadow-sm">
                    <h2 class="font-display text-2xl font-bold uppercase text-ink">Details</h2>
                    <dl class="mt-4 space-y-3 text-sm">
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wider text-muted">Email</dt>
                            <dd class="text-ink">info@bimportal.co.za</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wider text-muted">Phone</dt>
                            <dd class="text-ink">+27 21 123 4567</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wider text-muted">Location</dt>
                            <dd class="text-ink">Cape Town, South Africa</dd>
                        </div>
                    </dl>
                    <p class="mt-4 text-xs text-muted">Contact details are the placeholders from the client's design and need confirming.</p>
                </div>

                <div class="rounded-xl bg-navy-900 p-6 text-white shadow-sm">
                    <h2 class="font-display text-2xl font-bold uppercase">Need a quote?</h2>
                    <p class="mt-2 text-sm text-white/75">Tell us about your project and upload your drawings or models.</p>
                    <a href="{{ route('quote.create') }}" class="btn btn-primary mt-4">Request a quote</a>
                </div>
            </aside>
        </div>
    </section>
@endsection