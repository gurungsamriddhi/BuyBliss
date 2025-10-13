<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // Display all products
    public function index()
    {
        $products = Product::with('categories')->get();
        return view('admin.products.index', compact('products'));
    }

    // Show create form
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // Store new product
    public function store(Request $request)
    {
        //dd($request->all());

        $request->validate([
            'name' =>[ 
                'required',
                'unique:products,name',
                'regex:/^[A-Za-z0-9\s]+$/',
                'max:100',
], 
           'description' => 'nullable|string|max:500',
            'price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'categories' => 'nullable|array',
],
[ 
    'name.required'=>'Name field cannot be empty.',
    'name.unique'=>'This Product name already exists.',
    'name.regex'=>'Name can only contain letters, numbers and spaces.'


           
        ]);

        // if($validator->fails()){
        //     dd($validator->errors()->all());
        // }

        $data = $request->only(['name', 'description', 'price']);

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($data);

        // Attach categories
        $product->categories()->sync($request->categories ?? []);

        return redirect()->route('admin.products.index')->with('success', 'Product added successfully.');
    }

    // Show edit form
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Update existing product
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|unique:products,name,' . $product->id,
            'description' => 'nullable|string|max:500',
            'price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'categories' => 'nullable|array',
        ]);

        $data = $request->only(['name', 'description', 'price']);

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        // Sync categories
        $product->categories()->sync($request->categories ?? []);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    // Delete product
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
