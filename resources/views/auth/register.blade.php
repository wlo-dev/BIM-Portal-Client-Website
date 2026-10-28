@extends('layouts.app')

@section('title','Create account | BIM Portal')

@section('content')
      <section class="relative isolate flex  min-h-[calc(100vh-5rem)] items-center justify-center overflow-hidden bg-navy-950 px-4 py-16">
        <div class="absolute inset-0 -z-10 bg-blueprint opacity-20"></div>
        <div class="absolute -right-24 top-10 -z-10 h-96 w-96 rounded-full bg-brand-600/30 blur-3xl"></div>

<div class="w-full max-w-md rounded-xl border border-white/10 bg-navy-900/80 p-8 shadow-2xl backdrop-blur">
    <h1 class="font-display  text-4xl font-bold uppercase text-white">Create account</h1>
    <p class="mt-2 text-sm text-white/70">Register to buy resources and manage your projects.</p>


    <from method="POST" action="{{ route('register') }}" class="mt-8 space-y-5">
        @csrf

        <x-field name="name" label="Full name" autocomplete="name" />
        <x-field name="email" label="Email" type="email" autocomplete="email" />
        <x-field name="password" type="password" label="Password" autocomplete="new-password" />
        <x-field name="password_confirmation" type="password" label="Confirm password" autocomplete="new-password" />
        <button type="submit" class="btn btn-primary w-full">Create account</button>


</form>

<p class="mt-6 text-center text-sm text-white/70">
    Already registered?
    <a href="{{ route('login') }}" class="font-semibold text-400 hove:text-white">Sign in</a>
</p>
</div>
</section>
@endsection
