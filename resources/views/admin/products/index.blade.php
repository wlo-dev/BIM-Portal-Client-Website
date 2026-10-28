@extends('layouts.app')

@section('title', 'Products | Admin')

@section('content')
    <x-admin-shell title="Products">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <form method="GET" action="{{ route('admin.products.index') }}" class="flex gap-2">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Search products"
                       class="w-full rounded-md border border-line bg-white px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/30 sm:w-64">
                <button type="submit" class="btn btn-outline-dark btn-sm">Search</button>
            </form>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">Add product</a>
        </div>

        <div class="mt-6 overflow-x-auto rounded-xl border border-line bg-white shadow-sm">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-line bg-surface text-xs uppercase tracking-wider text-muted">
                    <tr>
                        <th class="px-4 py-3">Product</th>
                        <th class="px-4 py-3">Category</th>
                        <th class="px-4 py-3">Price</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @forelse ($products as $product)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    @if ($product->image_path)
                                        <img src="{{ asset($product->image_path) }}" alt="" class="h-12 w-12 rounded-md object-cover">
                                    @else
                                        <span class="flex h-12 w-12 items-center justify-center rounded-md bg-surface text-xs text-muted">No img</span>
                                    @endif
                                    <span class="font-semibold text-ink">{{ $product->name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-muted">{{ $product->category?->name ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $product->priceFormatted() }}</td>
                            <td class="px-4 py-3">
                                @if ($product->is_published)
                                    <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-bold uppercase text-green-800">Published</span>
                                @else
                                    <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-bold uppercase text-slate-600">Draft</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline-dark btn-sm">Edit</a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                          onsubmit="return confirm('Delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm border border-red-300 text-red-700 hover:bg-red-50">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-muted">
                                No products yet. Click <strong>Add product</strong> to create the first one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </x-admin-shell>
@endsection