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

    public function AddCategory(){

        return view('backend.category.category_add');

    } // end method

    public function StoreCategory(Request $request){

        Category::insert([
            'category_name' => $request->category_name, // get category name from form
            'category_slug' => strtolower(str_replace(' ','-', $request -> category_name)), // get category slug from form
        ]);


        $notification = array(
            'message' => 'Category Inserted Successfully',
            'alert-type' => 'success'
        );

        return Redirect()->route('all.category')->with($notification);



    }
}
