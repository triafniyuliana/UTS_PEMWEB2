<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 
use App\Models\Categories;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * GET: dashboard/products
     * Menampilkan daftar produk.
     */
    public function index(Request $request)
    {
    $q = $request->q;

        $products = Product::with('category')
                        ->where('name', 'like', '%' . $q . '%')
                        ->orWhere('description', 'like', '%' . $q . '%')
                        ->paginate(10);

        return view('dashboard.products.index', compact('products', 'q'));
        
    }

    public function create()
    {
        $categories = Categories::all();

        return view('dashboard.products.create', compact('categories'));
    }
    

    public function show(string $id)
    {
        $products = Product::find($id);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Categories::all();

        return view('dashboard.products.edit', compact('product', 'categories'));
    }

    /**
     * POST: dashboard/products
     * Menyimpan produk baru.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'product_category_id' => 'nullable|exists:product_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $product = new Product; 
        $product->product_category_id = $request->product_category_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('uploads/products', $imageName, 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('products.index')
            ->with('successMessage', 'Product Berhasil Disimpan');
    }

    /**
     * PUT/PATCH: dashboard/products/{product}
     * Memperbarui produk yang ada.
     */
    public function update(Request $request, string $id)
    {
        
        $validated = $request->validate([
            'product_category_id' => 'nullable|exists:product_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $product = Product::find($id);
        $product->product_category_id = $request->product_category_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('uploads/products', $imageName, 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('products.index')
            ->with('successMessage', 'Product Berhasil Diperbarui');
    }

    /**
     * DELETE: dashboard/products/{product}
     * Menghapus produk.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id); 

        $product->delete();

        return redirect()->route('products.index')
            ->with('successMessage', 'Data Berhasil Dihapus');
    }
}
