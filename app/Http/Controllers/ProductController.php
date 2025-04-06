<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use App\Models\Brand;
use App\Models\Type;

class ProductController extends Controller
{
    // Index - shows the list of products with filtering
    public function index(Request $request)
    {
        $query = Product::with(['images', 'brand', 'type']);
        
        // Add filters if they exist in the request
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }
        
        if ($request->filled('type_id')) {
            $query->where('type_id', $request->type_id);
        }
        
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        
        $products = $query->latest()->get();
        $brands = Brand::all();
        $types = Type::all();
        
        return view('admin.products.index', compact('products', 'brands', 'types'));
    }

    // Create - shows the form to add a product
    public function create()
    {
        $brands = Brand::all();
        $types = Type::all();
        return view('admin.products.create', compact('brands', 'types'));
    }

    // Store - saves a new product
    public function store(ProductRequest $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'brand_id' => 'nullable|exists:brand,id',
            'type_id' => 'nullable|exists:types,id',
            'images' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $product = Product::create($request->only([
            'name', 'description', 'price', 'stock', 'brand_id', 'type_id'
        ]));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('products', $imageName, 'public');
                $product->images()->create([
                    'image_path' => $imagePath
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product added successfully!');
    }

    // Edit - shows the form to edit a product
    public function edit(Product $product)
    {
        $brands = Brand::all();
        $types = Type::all();
        return view('admin.products.edit', compact('product', 'brands', 'types'));
    }

    // Update - updates an existing product
    public function update(ProductRequest $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'brand_id' => 'nullable|exists:brand,id',
            'type_id' => 'nullable|exists:types,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $product->update($request->only([
            'name', 'description', 'price', 'stock', 'brand_id', 'type_id'
        ]));

        if ($request->hasFile('images')) {
            // Optionally delete old images if replacing
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }

            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('products', $imageName, 'public');
                $product->images()->create(['image_path' => $imagePath]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    // Destroy - delete product (and its images optionally)
    public function destroy(Product $product)
    {
        // Delete associated images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}