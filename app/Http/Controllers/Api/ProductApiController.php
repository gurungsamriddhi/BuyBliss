<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Exception;

class ProductApiController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of products.
     */
    public function index()
    {
        try {
            $products = $this->productRepository->all();
            return response()->json([
                'success' => true,
                'data' => $products,
                'message' => 'Products retrieved successfully.'
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve products.',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
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
            'categories.*' => 'exists:categories,id',
        ]);

        try {
            $data = $request->only(['name', 'description', 'price']);

            // Handle image upload
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('products', 'public');
                $data['image'] = $path;
                // Optionally return full URL
                $data['image_url'] = Storage::url($path);
            }

            $product = $this->productRepository->create($data);

            // Sync categories
            $product->categories()->sync($request->categories);

            // Reload product with categories
            $product->load('categories');

            return response()->json([
                'success' => true,
                'data' => $product,
                'message' => 'Product created successfully.'
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create product.',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified product.
     */
    public function show(string $id)
    {
        try {
            $product = $this->productRepository->find($id);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found.'
                ], Response::HTTP_NOT_FOUND);
            }

            $product->load('categories');

            return response()->json([
                'success' => true,
                'data' => $product,
                'message' => 'Product retrieved successfully.'
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve product.',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:products,name,' . $id . '|regex:/^[A-Za-z0-9\s]+$/|max:100',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        try {
            $product = $this->productRepository->find($id);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found.'
                ], Response::HTTP_NOT_FOUND);
            }

            $data = $request->only(['name', 'description', 'price']);

            // Handle image upload (optional on update)
            if ($request->hasFile('image')) {
                // Delete old image
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }

                $path = $request->file('image')->store('products', 'public');
                $data['image'] = $path;
                $data['image_url'] = Storage::url($path);
            }

            $updatedProduct = $this->productRepository->update($id, $data);

            // Sync categories
            $updatedProduct->categories()->sync($request->categories ?? []);

            // Reload with fresh data
            $updatedProduct->load('categories');

            return response()->json([
                'success' => true,
                'data' => $updatedProduct,
                'message' => 'Product updated successfully.'
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product.',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = $this->productRepository->find($id);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found.'
                ], Response::HTTP_NOT_FOUND);
            }

            // Delete image from storage
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $this->productRepository->destroy($id);

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully.'
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete product.',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
