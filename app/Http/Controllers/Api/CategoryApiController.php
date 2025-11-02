<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;

class CategoryApiController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of categories.
     */
    public function index()
    {
        try {
            $categories = $this->categoryRepository->all();
            return response()->json([
                'success' => true,
                'data' => $categories,
                'message' => 'Categories retrieved successfully.'
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve categories.',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'regex:/^[A-Za-z\s]+$/',
                'unique:categories,name',
                'max:50',
            ],
            'description' => 'nullable|string|max:500',
        ], [
            'name.required' => 'Name field cannot be empty.',
            'name.regex' => 'Name should only contain letters.',
            'name.unique' => 'This name already exists.',
            'name.max' => 'Name cannot be longer than 50 characters.',
            'description.max' => 'Description cannot be longer than 500 characters.',
        ]);

        try {
            $data = $request->only(['name', 'description']);
            $category = $this->categoryRepository->create($data);

            return response()->json([
                'success' => true,
                'data' => $category,
                'message' => 'Category created successfully.'
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create category.',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified category.
     */
    public function show($id)
    {
        try {
            $category = $this->categoryRepository->find($id);

            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found.'
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'success' => true,
                'data' => $category,
                'message' => 'Category retrieved successfully.'
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve category.',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                'regex:/^[A-Za-z\s]+$/',
                'unique:categories,name,' . $id,
                'max:50',
            ],
            'description' => 'nullable|string|max:500',
        ], [
            'name.required' => 'Name field cannot be empty.',
            'name.regex' => 'Name should only contain letters.',
            'name.unique' => 'Name already exists.',
            'name.max' => 'Name cannot be longer than 50 characters.',
            'description.max' => 'Description cannot be longer than 500 characters.',
        ]);

        try {
            $category = $this->categoryRepository->find($id);

            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found.'
                ], Response::HTTP_NOT_FOUND);
            }

            $data = $request->only(['name', 'description']);
            $updatedCategory = $this->categoryRepository->update($id, $data);

            return response()->json([
                'success' => true,
                'data' => $updatedCategory,
                'message' => 'Category updated successfully.'
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update category.',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy($id)
    {
        try {
            $category = $this->categoryRepository->find($id);

            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found.'
                ], Response::HTTP_NOT_FOUND);
            }

            $this->categoryRepository->destroy($id);

            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully.'
            ], Response::HTTP_OK); // Changed to 200 for consistency
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete category.',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
