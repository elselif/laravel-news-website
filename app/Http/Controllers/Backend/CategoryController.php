<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;

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



    } // end method

    public function EditCategory($id){

        $category = Category::findOrFail($id); // get category by id

        return view('backend.category.category_edit', compact('category')); // return view with category

    } // end method

    public function UpdateCategory(Request $request) {

        $cat_id = $request->id; // get category id from form
         
        Category::findOrFail($cat_id)->update([ // find category by id and update
            'category_name' => $request->category_name, // get category name from form
            'category_slug' => strtolower(str_replace(' ','-', $request -> category_name)), // get category slug from form
        ]);


        $notification = array(
            'message' => 'Category Updated Successfully',
            'alert-type' => 'success'
        );

        return Redirect()->route('all.category')->with($notification);



    } // end method

    public function DeleteCategory($id){

        Category::findOrFail($id)->delete(); // find category by id and delete

        $notification = array(
            'message' => 'Category Deleted Successfully',
            'alert-type' => 'success'
        );

        return Redirect()->back()->with($notification);

    } // end method

    /////////////////////////////// Subcategory All///////////////////////////////

    public function AllSubcategory(){
            
            $subcategories = Subcategory::latest()->get(); // get all subcategories from database
    
            return view('backend.subcategory.subcategory_all', compact('subcategories')); // return view with subcategories
    
        } // end method

        public function AddSubcategory(){
    
            $categories = Category::latest()->get(); // get all categories from database
    
            return view('backend.subcategory.subcategory_add', compact('categories')); // return view with categories
    
        } // end method

        public function StoreSubCategory(Request $request){

            SubCategory::insert([
                'category_id' => $request->category_id, // get category id from form
                'subcategory_name' => $request->subcategory_name, // get category name from form
                'subcategory_slug' => strtolower(str_replace(' ','-', $request -> subcategory_name)), // get category slug from form
            ]);
    
    
            $notification = array(
                'message' => 'SubCategory Inserted Successfully',
                'alert-type' => 'success'
            );
    
            return Redirect()->route('all.subcategory')->with($notification);
    
    
    
        } // end method



    


}
