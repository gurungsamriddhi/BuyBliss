<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    protected $categoryModel;

    public function __construct(Category $categoryModel)
    {
        $this->categoryModel = $categoryModel;
    }

    public function all() {
        return $this->categoryModel->orderBy('name')->get();
    }
    public function find($id) {
        return $this->categoryModel->findOrFail($id);
    }
    public function create(array $data) {
        $this->categoryModel->create($data);

    }
    public function update($id, array $data) {
    $category= $this->find($id);
    $category->update($data);
    return $category;
    }
    public function destroy($id) {
        $category=$this->find($id);
        $category->delete();
        return true;
    }
}
