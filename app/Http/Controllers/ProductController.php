<?php

namespace App\Http\Controllers; // <-- THIS MUST BE EXACTLY THIS

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller // <-- This extends the original Controller.php
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::with('category')->get(); // Eager load category to avoid N+1
        return view('products.index', compact('categories', 'products'));
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}