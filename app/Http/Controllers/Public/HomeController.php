<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('public.home');
    }

    public function about()
    {
        return view('public.about');
    }
    
    public function blog(){
        return view('public.blog');
    }
    public function services(){
        return view('public.services');
    }
}
