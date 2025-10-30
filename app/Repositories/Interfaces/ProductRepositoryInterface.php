<?php

namespace App\Repositories\Interfaces;



interface ProductRepositoryInterface
{
    public function all();
    public function find($id);
    public function listallcategories();
    public function findwithCategories($id);
    public function create(array $data);
    public function update($id, array $data);
    public function destroy($id);
}