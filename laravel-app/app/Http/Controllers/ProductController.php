<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Products $product)
    {
        $products = Products::where('status', 1)->where('quantity', '>', 0)->inRandomOrder()->take(4)->get();
        return view('products.show', compact('product', 'products'));
    }

    public function index(Request $request)
    {
        $products = Products::search($request->search)->filter()->where('status', 1)->where('quantity', '>', 0)->paginate(9);
        $categories = Categories::where('status', 1)->get();

        return view('products.menu', compact('products', 'categories'));
    }
}
