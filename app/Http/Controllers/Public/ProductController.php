<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $products=Product::with('categories')->paginate('30');
        return view('public.products.index',compact('products'));
    }
    public function show($id){
        //findorfail prevent showing empty pages for invalid ids
        $product =Product::with('categories')->findorFail($id);
        return view('public.products.show',compact('product'));
    }
}
