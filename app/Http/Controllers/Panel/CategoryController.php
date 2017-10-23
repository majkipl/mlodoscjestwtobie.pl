<?php

namespace App\Http\Controllers\Panel;

use App\Models\Category;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        return view('panel/category/index');
    }

    public function create()
    {
        return view('panel/category/form', []);
    }

    public function show(Category $category)
    {
        return view('panel/category/show', [
            'category' => $category
        ]);
    }

    public function edit(Category $category)
    {
        return view('panel/category/form', [
            'category' => $category
        ]);
    }
}
