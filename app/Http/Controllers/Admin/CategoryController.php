<?php
//this controller belongs to the Admin sub namespace 
namespace App\Http\Controllers\Admin;
//base controller class from Laravel Framework
use App\Http\Controllers\Controller;
//http request handling class
use Illuminate\Http\Request;
//category eloquent model
use App\Models\Category;


//categorycontroller inherits from Laravel's base controller
class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    //Handle form submission to create a new category
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => [
                    'required',
                    //only letters, numbers and spaces is allowed
                    'regex:/^[A-Za-z\s]+$/',
                    'unique:categories,name',
                    'max:50',
                ],

                'description' => 'nullable|string|max:500',
            ],
            [
                //field.rule =>custom valiudation message
                'name.required' => 'Name field cannot be empty.',
                'name.regex' => 'Name should only contain letters.',
                'name.unique' => 'This name already exists. Please choose another name.',
                'name.max' => 'Name cannot be longer than 50 characters.',
                'description.max' => 'Description cannot be longer than 500 characters.',
            ]
        );
        Category::create($request->all());
        return redirect()->route('admin.categories.index')->with('success', 'Category added.');
    }
    //show edit form for specific category
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate(
            [
                'name' => [
                    'required',
                    'regex: /^[A-Za-z\s]+$/',
                    'unique:categories,name,' . $category->id,
                    'max:50',
                ],

                'description' => 'nullable|string|max:500',
            ],
            [
                'name.required' => 'Name field cannot be empty.',
                'name.regex' => 'Name should only contain letters.',
                'name.unique' => 'Name already exists.',
                'name.max' => 'Name cannot be longer than 50 characters.',
                'description.max' => 'Description cannot be longer than 500 characters.',
            ]
        );
        $category->update($request->all());
        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted.');
    }
}
