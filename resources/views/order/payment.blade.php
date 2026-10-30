@extends('layouts.app')

@section('title', 'Secure payment | BIM PORTAL')

@section('content')
    <section class="relative isolate overflow-hidden bg-navy-950 px-4 py-14">
        <div class="absolute inset-0 -z-10 bg-blueprint opacity-20"></div>
        <div class="absolute -right-24 top-10 -z-10 h-96 w-96 rounded-full bg-brand-600/30 blur-3xl"></div>

        <div class="mx-auto grid max-w-5xl gap-8 lg:grid-cols-[1fr_22rem]">
            <div class="rounded-xl border border-white/10 bg-navy-900/80 p-8 shadow-2xl backdrop-blur">
                <div class="flex items-center justify-between">
                    <p class="font-display text-2xl font-bold uppercase text-white">Sandbox<span class="text-brand-400">Pay</span></p>
                    <span class="rounded-full border border-amber-300/40 bg-amber-400/10 px-3 py-1 text-xs font-bold uppercase tracking-wider text-amber-200">Test mode</span>
                </div>

                <h1 class="mt-6 font-display text-4xl font-bold uppercase text-white">Pay {{ $order->totalFormatted() }}</h1>
                <p class="mt-1 text-sm text-white/70">Order {{ $order->reference }}</p>

                @if ($errors->any())
                    <div class="mt-5 rounded-md border border-red-300/40 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                        @foreach ($errors->all() as $message)
                            <p>{{ $message }}</p>
                        @endforeach
                    </div>
                @endif

                <div id="card-warning" class="mt-5 hidden rounded-md border border-red-300/40 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                    This sandbox only accepts the test cards listed on this page. Never enter a real card number here.
                </div>

                <form id="card-form" method="POST" action="{{ route('orders.pay', $order) }}" class="mt-6 space-y-5" autocomplete="off">
                    @csrf

                    <div>
                        <label for="card_number" class="block text-xs font-semibold uppercase tracking-wider text-white/80">Card number</label>
                        <input id="card_number" name="card_number" type="text" inputmode="numeric" autocomplete="off"
                               placeholder="4242 4242 4242 4242"
                               class="mt-2 block w-full rounded-md border border-white/15 bg-navy-800/60 px-4 py-3 text-white placeholder-white/30 focus:border-brand-400 focus:outline-none focus:ring-2 focus:ring-brand-400/40">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="expiry" class="block text-xs font-semibold uppercase tracking-wider text-white/80">Expiry (MM / YY)</label>
                            <input id="expiry" name="expiry" type="text" inputmode="numeric" autocomplete="off"
                                   placeholder="12 / 30"
                                   class="mt-2 block w-full rounded-md border border-white/15 bg-navy-800/60 px-4 py-3 text-white placeholder-white/30 focus:border-brand-400 focus:outline-none focus:ring-2 focus:ring-brand-400/40">
                        </div>
                        <div>
                            <label for="cvc" class="block text-xs font-semibold uppercase tracking-wider text-white/80">CVC</label>
                            <input id="cvc" name="cvc" type="text" inputmode="numeric" maxlength="4" autocomplete="off"
                                   placeholder="123"
                                   class="mt-2 block w-full rounded-md border border-white/15 bg-navy-800/60 px-4 py-3 text-white placeholder-white/30 focus:border-brand-400 focus:outline-none focus:ring-2 focus:ring-brand-400/40">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-full">Pay {{ $order->totalFormatted() }}</button>
                </form>

                <a href="{{ route('orders.show', $order) }}" class="mt-6 block text-center text-sm text-white/60 hover:text-white">Back to order</a>
            </div>

            <aside class="rounded-xl border border-white/10 bg-navy-900/60 p-6 backdrop-blur">
                <h2 class="font-display text-2xl font-bold uppercase text-white">Test cards</h2>
                <p class="mt-2 text-sm text-white/70">Use any future expiry and any 3-digit CVC. Click a card to fill the form.</p>

                <ul class="mt-4 space-y-3 text-sm">
                    <li>
                        <button type="button" data-fill="4242424242424242" class="w-full rounded-md border border-white/15 px-3 py-3 text-left hover:border-brand-400">
                            <span class="block font-mono text-white">4242 4242 4242 4242</span>
                            <span class="text-xs text-green-300">Visa: approved</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" data-fill="5555555555554444" class="w-full rounded-md border border-white/15 px-3 py-3 text-left hover:border-brand-400">
                            <span class="block font-mono text-white">5555 5555 5555 4444</span>
                            <span class="text-xs text-green-300">Mastercard: approved</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" data-fill="4000000000000002" class="w-full rounded-md border border-white/15 px-3 py-3 text-left hover:border-brand-400">
                            <span class="block font-mono text-white">4000 0000 0000 0002</span>
                            <span class="text-xs text-red-300">Declined</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" data-fill="4000000000009995" class="w-full rounded-md border border-white/15 px-3 py-3 text-left hover:border-brand-400">
                            <span class="block font-mono text-white">4000 0000 0000 9995</span>
                            <span class="text-xs text-red-300">Insufficient funds</span>
                        </button>
                    </li>
                </ul>

                <p class="mt-5 text-xs leading-relaxed text-white/60">
                    This is a simulated payment provider for demonstration. No real payment is made, and card numbers, expiry dates and CVC codes are never saved.
                </p>
            </aside>
        </div>
    </section>

    <script>
        (function () {
            const number = document.getElementById('card_number');
            const expiry = document.getElementById('expiry');
            const cvc = document.getElementById('cvc');
            const form = document.getElementById('card-form');
            const warning = document.getElementById('card-warning');
            const testCards = ['4242424242424242', '5555555555554444', '4000000000000002', '4000000000009995'];

            number.addEventListener('input', function () {
                const digits = number.value.replace(/\D/g, '').slice(0, 16);
                number.value = digits.replace(/(.{4})/g, '$1 ').trim();
            });

            expiry.addEventListener('input', function () {
                const digits = expiry.value.replace(/\D/g, '').slice(0, 4);
                expiry.value = digits.length > 2 ? digits.slice(0, 2) + ' / ' + digits.slice(2) : digits;
            });

            form.addEventListener('submit', function (event) {
                const digits = number.value.replace(/\D/g, '');

                if (!testCards.includes(digits)) {
                    event.preventDefault();
                    warning.classList.remove('hidden');
                }
            });

            document.querySelectorAll('[data-fill]').forEach(function (button) {
                button.addEventListener('click', function () {
                    number.value = button.dataset.fill.replace(/(.{4})/g, '$1 ').trim();
                    expiry.value = '12 / 30';
                    cvc.value = '123';
                    warning.classList.add('hidden');
                });
            });
        })();
    </script>
@endsection