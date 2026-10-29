@extends('layouts.app')

@section('title', 'My orders | BIM PORTAL')

@section('content')
    <section class="bg-surface py-12">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <h1 class="font-display text-5xl font-bold uppercase text-ink">My orders</h1>

            <div class="mt-8 overflow-x-auto rounded-xl border border-line bg-white shadow-sm">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-line bg-surface text-xs uppercase tracking-wider text-muted">
                        <tr>
                            <th class="px-4 py-3">Order</th>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">Total</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line">
                        @forelse ($orders as $order)
                            <tr>
                                <td class="px-4 py-3 font-semibold text-ink">{{ $order->reference }}</td>
                                <td class="px-4 py-3 text-muted">{{ $order->created_at->format('d M Y') }}</td>
                                <td class="px-4 py-3">{{ $order->totalFormatted() }}</td>
                                <td class="px-4 py-3">
                                    @if ($order->status === 'paid')
                                        <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-bold uppercase text-green-800">Paid</span>
                                    @else
                                        <span class="rounded-full bg-amber-100 px-2.5 py-1 text-xs font-bold uppercase text-amber-800">Pending</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-dark btn-sm">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-muted">
                                    You have no orders yet. <a href="{{ route('shop.index') }}" class="font-semibold text-brand-600">Browse resources</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        </div>
    </section>
@endsection