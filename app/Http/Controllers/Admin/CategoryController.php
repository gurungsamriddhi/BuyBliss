<?php
//this controller belongs to the Admin sub namespace 
namespace App\Http\Controllers\Admin;
//base controller class from Laravel Framework
use App\Http\Controllers\Controller;
//http request handling class
use Illuminate\Http\Request;
//category eloquent model
use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;


//categorycontroller inherits from Laravel's base controller
class CategoryController extends Controller
{

    protected $categoryRepository;
    public function __construct(CategoryRepositoryInterface $categoryRepository){
        $this->categoryRepository=$categoryRepository;

    }

    public function index()
    {
        $categories = $this->categoryRepository->all();
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
        $this->categoryRepository->create($request->all());
        return redirect()->route('admin.categories.index')->with('success', 'Category added.');
    }
    //show edit form for specific category
    public function edit($id)
    {
        $category=$this->categoryRepository->find($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => [
                    'required',
                    'regex: /^[A-Za-z\s]+$/',
                    'unique:categories,name,' . $id,
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
        $this->categoryRepository->update($id, $request->all());
        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }

    public function destroy($id)
    {
        $this->categoryRepository->destroy($id);
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted.');
    }
}
