<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller


{

    public function index(){
        
        return view('public.cart.index');

    }
    public function addToCart(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Please log in to add items to your cart.'], 401);
        }

        $productId = $request->input('product_id');
        if (!$productId) {
            return response()->json(['error' => 'Invalid product ID.'], 400);
        }

        $cart = session()->get('cart', []);
        if(!isset($cart[$productId])){
            $cart[$productId]=['quantity'=>1];

        }
        else{
            $cart[$productId]['quantity']++;
        }
        session()->put('cart', $cart);

        return response()->json(['success' => 'Product added to cart!']);
    }


    //returns the number of unique products in the cart
    public function count()
    {
        $cart = session()->get('cart', []);
        return response()->json(['count' => count($cart)]);
    }

    public function show()
    {
        return view('cart');
    }
}
