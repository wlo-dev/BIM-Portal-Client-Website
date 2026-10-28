<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->query('q'), fn ($query, $term) => $query->where('name', 'ilike', '%' . $term . '%'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.form', [
            'product' => new Product(),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());

        $product = new Product();
        $this->fill($product, $request, $data);
        $product->slug = Str::slug($data['name']) . '-' . Str::lower(Str::random(4));
        $product->save();

        return redirect()->route('admin.products.index')->with('status', 'Product created.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.form', [
            'product' => $product,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate($this->rules());

        $this->fill($product, $request, $data);
        $product->save();

        return redirect()->route('admin.products.index')->with('status', 'Product updated.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        // Past orders keep a link to the product, so a purchased product is hidden, not deleted.
        if (OrderItem::where('product_id', $product->id)->exists()) {
            $product->update(['is_published' => false]);

            return back()->with('status', 'This product has orders, so it was unpublished instead of deleted.');
        }

        if ($product->image_path) {
            File::delete(public_path($product->image_path));
        }
        if ($product->file_path) {
            Storage::disk('local')->delete($product->file_path);
        }

        $product->delete();

        return back()->with('status', 'Product deleted.');
    }

    private function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'description' => ['nullable', 'string', 'max:5000'],
            'price' => ['required', 'numeric', 'min:0', 'max:1000000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'file' => ['nullable', 'file', 'extensions:zip,pdf,rfa,rvt,rte,dwg', 'max:51200'],
        ];
    }

    private function fill(Product $product, Request $request, array $data): void
    {
        $product->name = $data['name'];
        $product->category_id = $data['category_id'] ?? null;
        $product->description = $data['description'] ?? null;
        $product->price_cents = (int) round($data['price'] * 100);
        $product->is_published = $request->boolean('is_published');

        if ($request->hasFile('image')) {
            if ($product->image_path) {
                File::delete(public_path($product->image_path));
            }
            $image = $request->file('image');
            $name = Str::uuid() . '.' . $image->extension();
            $image->move(public_path('uploads/products'), $name);
            $product->image_path = 'uploads/products/' . $name;
        }

        if ($request->hasFile('file')) {
            if ($product->file_path) {
                Storage::disk('local')->delete($product->file_path);
            }
            $file = $request->file('file');
            $product->file_path = $file->storeAs(
                'downloads',
                Str::uuid() . '.' . strtolower($file->getClientOriginalExtension()),
                'local'
            );
        }
    }
}