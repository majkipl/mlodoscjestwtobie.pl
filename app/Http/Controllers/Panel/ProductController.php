<?php

namespace App\Http\Controllers\Panel;

use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        return view('panel/product/index');
    }

    public function create()
    {
        $categories = Category::all();

        return view('panel/product/form', [
            'categories' => $categories
        ]);
    }

    public function show(Product $product)
    {
        return view('panel/product/show', [
            'product' => $product
        ]);
    }

    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('panel/product/form', [
            'product' => $product,
            'categories' => $categories
        ]);
    }
}
