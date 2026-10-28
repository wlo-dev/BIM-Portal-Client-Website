@props(['title' => 'Admin'])

<section class="bg-surface py-10">
    <div class="mx-auto flex max-w-7xl flex-col gap-8 px-4 sm:px-6 lg:flex-row lg:px-8">
        <aside class="lg:w-56 lg:shrink-0">
            <p class="text-xs font-semibold uppercase tracking-widest text-brand-600">Admin</p>
            <nav class="mt-3 flex gap-2 lg:flex-col" aria-label="Admin">
                <a href="{{ route('admin.products.index') }}"
                   class="rounded-md border px-4 py-2 text-sm font-semibold transition {{ request()->routeIs('admin.products.*') ? 'border-brand-600 bg-brand-600 text-white' : 'border-line bg-white text-ink hover:border-brand-500' }}">
                    Products
                </a>
            </nav>
        </aside>

        <div class="min-w-0 flex-1">
            <h1 class="font-display text-4xl font-bold uppercase text-ink">{{ $title }}</h1>

            @if (session('status'))
                <div class="mt-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    {{ session('status') }}
                </div>
            @endif

            <div class="mt-6">
                {{ $slot }}
            </div>
        </div>
    </div>
</section>