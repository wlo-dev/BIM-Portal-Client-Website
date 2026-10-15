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
            'Services' => '#',
            'Industries' => '#',
            'Portfolio' => '#',
            'How It Works' => '#',
            'Training' => '#',
            'BIM Resources' => '#',
            'About' => '#',
            'Contact' => '#',
        ];
    @endphp

    <header class="sticky top-0 z-50 border-b border-white/10 bg-navy-950">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
            <a href="{{ url('/') }}" class="flex flex-col leading-none" aria-label="BIM PORTAL home">
                <span class="font-display text-4xl font-bold tracking-tight text-white">BIM</span>
                <span class="text-[0.65rem] font-semibold uppercase tracking-[0.3em] text-brand-400">Portal</span>
            </a>

            <nav class="hidden items-center gap-6 xl:flex" aria-label="Main">
                @foreach ($navLinks as $label => $href)
                    <a href="{{ $href }}"
                       class="border-b-2 py-1 text-xs font-semibold uppercase tracking-wider text-white/90 transition hover:text-white {{ $label === 'Home' ? 'border-brand-400' : 'border-transparent' }}">{{ $label }}</a>
                @endforeach
            </nav>

            <div class="hidden items-center gap-3 xl:flex">
                <a href="#" class="btn btn-outline btn-sm">Client Portal</a>
                <a href="#" class="btn btn-primary btn-sm">Request a Quote</a>
            </div>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>