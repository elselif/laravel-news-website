<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function AllCategory(){


        $categories = Category::latest()->get(); // get all categories from database

        return view('backend.category.category_all', compact('categories')); // return view with categories

    } // end method
}
