@extends('layouts.app')

@section('title', ($product->exists ? 'Edit product' : 'Add product') . ' | Admin')

@section('content')
    <x-admin-shell :title="$product->exists ? 'Edit product' : 'Add product'">
        <form method="POST" enctype="multipart/form-data"
              action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}"
              class="space-y-6 rounded-xl border border-line bg-white p-6 shadow-sm">
            @csrf
            @if ($product->exists)
                @method('PUT')
            @endif

            <div>
                <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-muted">Name</label>
                <input id="name" name="name" type="text" value="{{ old('name', $product->name) }}"
                       class="mt-2 block w-full rounded-md border border-line px-4 py-3 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/30">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="category_id" class="block text-xs font-semibold uppercase tracking-wider text-muted">Category</label>
                    <select id="category_id" name="category_id"
                            class="mt-2 block w-full rounded-md border border-line bg-white px-4 py-3 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/30">
                        <option value="">No category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="price" class="block text-xs font-semibold uppercase tracking-wider text-muted">Price (rand)</label>
                    <input id="price" name="price" type="number" step="0.01" min="0"
                           value="{{ old('price', $product->exists ? number_format($product->price_cents / 100, 2, '.', '') : '') }}"
                           class="mt-2 block w-full rounded-md border border-line px-4 py-3 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/30">
                    @error('price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="description" class="block text-xs font-semibold uppercase tracking-wider text-muted">Description</label>
                <textarea id="description" name="description" rows="5"
                          class="mt-2 block w-full rounded-md border border-line px-4 py-3 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/30">{{ old('description', $product->description) }}</textarea>
                @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="image" class="block text-xs font-semibold uppercase tracking-wider text-muted">Product image (JPG, PNG, WebP, max 2 MB)</label>
                    @if ($product->image_path)
                        <img src="{{ asset($product->image_path) }}" alt="" class="mt-2 h-24 w-24 rounded-md object-cover">
                    @endif
                    <input id="image" name="image" type="file" accept="image/*" class="mt-2 block w-full text-sm">
                    @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="file" class="block text-xs font-semibold uppercase tracking-wider text-muted">Download file (ZIP, PDF, RFA, RVT, RTE, DWG)</label>
                    @if ($product->file_path)
                        <p class="mt-2 text-sm text-green-700">A file is already attached. Upload a new one to replace it.</p>
                    @endif
                    <input id="file" name="file" type="file" class="mt-2 block w-full text-sm">
                    @error('file') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <label class="flex items-center gap-2 text-sm text-ink">
                <input type="checkbox" name="is_published" value="1" class="rounded border-line text-brand-600"
                       @checked(old('is_published', $product->is_published))>
                Published (visible in the shop)
            </label>

            <div class="flex gap-3">
                <button type="submit" class="btn btn-primary">{{ $product->exists ? 'Save changes' : 'Create product' }}</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-dark">Cancel</a>
            </div>
        </form>
    </x-admin-shell>
@endsection