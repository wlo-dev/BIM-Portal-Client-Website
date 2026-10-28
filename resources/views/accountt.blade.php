@extends('layouts.app')

@section('title', 'My account | BIM PORTAL')

@section('content')
    <section class="bg-surface py-16">
        <div class="mx-auto max-w-3xl px-4 sm:px-6">
            @if (session('status'))
                <div class="mb-6 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    {{ session('status') }}
                </div>
            @endif

            <div class="rounded-xl border border-line bg-white p-8 shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-brand-600">My account</p>
                        <h1 class="mt-1 font-display text-4xl font-bold uppercase text-ink">{{ $user->name }}</h1>
                        <p class="mt-1 text-muted">{{ $user->email }}</p>
                    </div>
                    <span class="rounded-full bg-brand-500/10 px-3 py-1 text-xs font-bold uppercase tracking-wider text-brand-600">
                        {{ $user->role }}
                    </span>
                </div>

                <form method="POST" action="{{ route('account.update') }}" class="mt-8 space-y-4 border-t border-line pt-8">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-muted">Full name</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}"
                               class="mt-2 block w-full rounded-md border border-line px-4 py-3 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/30">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="mt-6 border-t border-line pt-6">
                    @csrf
                    <button type="submit" class="btn btn-outline-dark">Sign out</button>
                </form>
            </div>
        </div>
    </section>
@endsection