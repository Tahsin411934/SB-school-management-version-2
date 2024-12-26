<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
class HomeController extends Controller
{
    //
    public function homePage(){
        // $products = Product::with(['category', 'subCategory'])->get();
        // return view('index' ,compact('products'));
        return view('admin.pages.login');
    }
}