<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'BIM PORTAL | Your BIM Production Partner')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @php
        $navLinks = [
            'Home' => url('/'),
            'Services' => route('pages.services'),
            'Industries' => route('pages.industries'),
            'Portfolio' => route('pages.portfolio'),
            'How It Works' => route('pages.how-it-works'),
            'Training' => route('pages.training'),
            'BIM Resources' => route('shop.index'),
            'About' => route('pages.about'),
            'Contact' => route('contact.create'),
        ];

        $portalUrl = auth()->check() ? route('account') : route('login');
        $quoteUrl = route('quote.create');
        $cartCount = count(session('cart', []));
    @endphp

    <header class="sticky top-0 z-50 border-b border-white/10 bg-navy-950">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
            <a href="{{ url('/') }}" class="flex flex-col leading-none" aria-label="BIM PORTAL home">
                <span class="font-display text-4xl font-bold tracking-tight text-white">BIM</span>
                <span class="text-[0.65rem] font-semibold uppercase tracking-[0.3em] text-brand-400">Portal</span>
            </a>

            <nav class="hidden items-center gap-6 xl:flex" aria-label="Main">
                              @foreach ($navLinks as $label => $href)
                    @php
                        $active = $label === 'Home'
                            ? request()->routeIs('home')
                            : (request()->url() === $href || str_starts_with(request()->url(), $href . '/'));
                    @endphp
                    <a href="{{ $href }}"
                       @if ($active) aria-current="page" @endif
                       class="border-b-2 py-1 text-xs font-semibold uppercase tracking-wider transition {{ $active ? 'border-brand-400 text-white' : 'border-transparent text-white/90 hover:border-white/40 hover:text-white' }}">{{ $label }}</a>
                @endforeach
            </nav>

            <div class="hidden items-center gap-3 xl:flex">
                <a href="{{ route('cart.index') }}" class="relative rounded-sm p-2 text-white hover:bg-white/10" aria-label="Cart, {{ $cartCount }} items">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="8" cy="21" r="1" /><circle cx="19" cy="21" r="1" />
                        <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
                    </svg>
                    @if ($cartCount > 0)
                        <span class="absolute -right-1 -top-1 flex h-5 min-w-5 items-center justify-center rounded-full bg-brand-500 px-1 text-[0.65rem] font-bold text-white">{{ $cartCount }}</span>
                    @endif
                </a>
                <a href="{{ $portalUrl }}" class="btn btn-outline btn-sm">Client Portal</a>
                <a href="{{ $quoteUrl }}" class="btn btn-primary btn-sm">Request a Quote</a>
            </div>

            <div class="flex items-center gap-1 xl:hidden">
                <a href="{{ route('cart.index') }}" class="relative rounded-sm p-2 text-white hover:bg-white/10" aria-label="Cart, {{ $cartCount }} items">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="8" cy="21" r="1" /><circle cx="19" cy="21" r="1" />
                        <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
                    </svg>
                    @if ($cartCount > 0)
                        <span class="absolute -right-1 -top-1 flex h-5 min-w-5 items-center justify-center rounded-full bg-brand-500 px-1 text-[0.65rem] font-bold text-white">{{ $cartCount }}</span>
                    @endif
                </a>
                <a href="{{ $quoteUrl }}" class="btn btn-primary btn-sm hidden sm:inline-flex">Request a Quote</a>
                <button id="menu-toggle" type="button"
                        class="rounded-sm p-2 text-white hover:bg-white/10"
                        aria-controls="mobile-menu" aria-expanded="false" aria-label="Toggle menu">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden max-h-[calc(100vh-4.5rem)] overflow-y-auto border-t border-white/10 xl:hidden">
            <nav class="mx-auto flex max-w-7xl flex-col gap-1 px-4 py-4 sm:px-6" aria-label="Mobile">
                @foreach ($navLinks as $label => $href)
                    <a href="{{ $href }}" class="rounded-sm px-3 py-3 text-sm font-semibold uppercase tracking-wider text-white/90 hover:bg-white/10">{{ $label }}</a>
                @endforeach
                <a href="{{ $portalUrl }}" class="btn btn-outline mt-3">Client Portal</a>
                <a href="{{ $quoteUrl }}" class="btn btn-primary mt-2">Request a Quote</a>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <x-footer />
</body>
</html>