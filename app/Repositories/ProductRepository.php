<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Category;
use App\Repositories\Interfaces\ProductRepositoryInterface;


class ProductRepository implements ProductRepositoryInterface
{
    protected $productModel;
    protected $categoryModel;

    public function __construct(Product $productModel, Category $categoryModel)
    {
        $this->productModel = $productModel;
        $this->categoryModel=$categoryModel;
    }

    public function all()
    {
        return $this->productModel
        ->with('categories')
        ->orderby('name')
        ->get();
    }
    public function find($id)
    {
        return $this->productModel->findOrFail($id);
    }

    public function findwithCategories($id)
    {
        return $this->productModel
        ->with('categories')
        ->get();
    }
    public function listallcategories()
    {
        return $this->categoryModel->all();
    }

    public function create(array $data)
    {
        return $this->productModel->create($data);
    }
    public function update($id, array $data)
    {
        $Product = $this->find($id);
        $Product->update($data);
        return $Product;
    }
    public function destroy($id)
    {
        $Product = $this->find($id);
        $Product->delete();
        return true;
    }
}
