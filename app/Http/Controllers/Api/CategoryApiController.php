<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryApiController extends Controller
{
    protected $categoryRepository;
    //laravel automatically provides the actual repository object when creating the controller
    // $this->categoryRepository = new CategoryRepository(); 
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $categories = $this->categoryRepository->all();
        return response()->json(['data' => $categories], Response::HTTP_OK);
    }

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

        $category = $this->categoryRepository->create($request->all());
        return response()->json(['data' => $category, 'message' => 'Category created'], Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $category = $this->categoryRepository->find($id);
        return response()->json(['data' => $category], Response::HTTP_OK);
    }

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

        $category = $this->categoryRepository->update($id, $request->all());
        return response()->json(['data' => $category, 'message' => 'Category updated'], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $this->categoryRepository->destroy($id);
        return response()->json(['message' => 'Category deleted'], Response::HTTP_NO_CONTENT);
    }
}
