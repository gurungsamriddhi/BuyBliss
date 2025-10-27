<?php
namespace App\Repositories\Interfaces;
use App\Models\Category;


// interface that has method declaratio->abstract methods
//must be implemented by the class that inherits this interface
interface CategoryRepositoryInterface{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function destroy($id);
}