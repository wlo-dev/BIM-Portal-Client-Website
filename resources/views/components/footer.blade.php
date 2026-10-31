@php
    $columns = [
        'Services' => [
            'BIM Modelling' => route('pages.services'),
            'Revit Services' => route('pages.services'),
            'Architectural Documentation' => route('pages.services'),
            'CAD Services' => route('pages.services'),
        ],
        'Company' => [
            'About' => route('pages.about'),
            'Portfolio' => route('pages.portfolio'),
            'How It Works' => route('pages.how-it-works'),
            'Contact' => route('contact.create'),
        ],
        'Resources' => [
            'Training' => route('pages.training'),
            'BIM Resources' => route('shop.index'),
            'Industries' => route('pages.industries'),
        ],
        'Client' => [
            'Client Portal' => auth()->check() ? route('account') : route('login'),
            'Request a Quote' => route('quote.create'),
            'My Orders' => auth()->check() ? route('orders.index') : route('login'),
        ],
    ];
@endphp

<footer class="bg-navy-950 text-white/70">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:grid-cols-2 sm:px-6 lg:grid-cols-[1.4fr_repeat(4,1fr)] lg:px-8">
        <div>
            <a href="{{ route('home') }}" class="flex flex-col leading-none" aria-label="BIM PORTAL home">
                <span class="font-display text-4xl font-bold tracking-tight text-white">BIM</span>
                <span class="text-[0.65rem] font-semibold uppercase tracking-[0.3em] text-brand-400">Portal</span>
            </a>
            <p class="mt-4 max-w-xs text-sm leading-relaxed">
                BIM PORTAL provides flexible BIM, Revit and documentation services to architecture, engineering and construction professionals.
            </p>
            <p class="mt-4 text-sm">info@bimportal.co.za<br>+27 21 123 4567<br>Cape Town, South Africa</p>
        </div>

        @foreach ($columns as $heading => $links)
            <div>
                <h2 class="text-xs font-bold uppercase tracking-widest text-white">{{ $heading }}</h2>
                <ul class="mt-4 space-y-2 text-sm">
                    @foreach ($links as $label => $href)
                        <li><a href="{{ $href }}" class="transition hover:text-white">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>

    <div class="border-t border-white/10">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-2 px-4 py-5 text-xs sm:px-6 lg:px-8">
            <p>&copy; {{ date('Y') }} BIM PORTAL. All rights reserved.</p>
            <p>Demonstration site. Sample content and test-mode payments only.</p>
        </div>
    </div>
</footer>