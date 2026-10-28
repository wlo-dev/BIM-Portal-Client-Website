@extends('layouts.app')

@section('title', 'Sign in | BIM PORTAL')

@section('content')
    <section class="relative isolate flex min-h-[calc(100vh-5rem)] items-center justify-center overflow-hidden bg-navy-950 px-4 py-16">
        <div class="absolute inset-0 -z-10 bg-blueprint opacity-20"></div>
        <div class="absolute -right-24 top-10 -z-10 h-96 w-96 rounded-full bg-brand-600/30 blur-3xl"></div>

        <div class="w-full max-w-md rounded-xl border border-white/10 bg-navy-900/80 p-8 shadow-2xl backdrop-blur">
            <h1 class="font-display text-4xl font-bold uppercase text-white">Sign in</h1>
            <p class="mt-2 text-sm text-white/70">Access your BIM PORTAL account.</p>

            <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
                @csrf
                <x-field name="email" label="Email" type="email" autocomplete="email" />
                <x-field name="password" label="Password" type="password" autocomplete="current-password" />

                <label class="flex items-center gap-2 text-sm text-white/70">
                    <input type="checkbox" name="remember" class="rounded border-white/30 bg-navy-800 text-brand-500">
                    Remember me
                </label>

                <button type="submit" class="btn btn-primary w-full">Sign in</button>
            </form>

            <p class="mt-6 text-center text-sm text-white/70">
                New here?
                <a href="{{ route('register') }}" class="font-semibold text-brand-400 hover:text-white">Create an account</a>
            </p>
        </div>
    </section>
@endsection