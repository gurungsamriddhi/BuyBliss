<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
protected $productRepository;
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository=$productRepository;
    }
    // Display all products
    public function index()
    {
        $products = $this->productRepository->all();
        return view('admin.products.index', compact('products'));
    }

    // Show create form
    public function create()
    {
        $categories = $this->productRepository->listallcategories();
        return view('admin.products.create', compact('categories'));
    }

    // Store new product
    public function store(Request $request)
    {
        //dd($request->all());

        $request->validate([
            'name' => [
                'required',
                'unique:products,name',
                'regex:/^[A-Za-z0-9\s]+$/',
                'max:100',
            ],
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'categories' => 'required|array',
        ]);

        // if($validator->fails()){
        //     dd($validator->errors()->all());
        // }

        $data = $request->only(['name', 'description', 'price']);

        // Handle image upload
        //public<products
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product =$this->productRepository->create($data);

        // Attach categories
        $product->categories()->sync($request->categories ?? []);

        return redirect()->route('admin.products.index')->with('success', 'Product added successfully.');
    }

    // Show edit form
    public function edit($id)
    {
        $product=$this-> productRepository->find($id);
        $categories = $this->productRepository->listallcategories();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Update existing product
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:products,name,' . $id,
            'description' => 'nullable|string|max:500',
            'price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'categories' => 'nullable|array',
        ]);

        $data = $request->only(['name', 'description', 'price']);

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        // Update product
        $updatedProduct = $this->productRepository->update($id, $data);

        // Sync categories
        $updatedProduct->categories()->sync($request->categories ?? []);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Delete product
     */
    public function destroy($id)
    {
        $this->productRepository->destroy($id);
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
