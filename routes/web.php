<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\NewsPostController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[IndexController::class,'Index']);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function (){

    Route::get('/dashboard', [UserController::class, 'UserDashboard'])->name('dashboard');
    Route::post('/user/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::get('/change/password', [UserController::class, 'ChangePassword'])->name('change.password');
    Route::post('/user/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.password.store');


}); //end user middleware

require __DIR__.'/auth.php';

Route::middleware(['auth','role:admin'])->group(function (){



Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');

Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');

Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');

Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');


}); //end admin middleware

Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->middleware(RedirectIfAuthenticated::class)->name('admin.login');

Route::get('/admin/logout/page', [AdminController::class, 'AdminLogoutPage'])->name('admin.logout.page');

Route::middleware(['auth','role:admin'])->group(function (){

Route::get('/admin/category', [CategoryController::class, 'Category'])->name('category');


// Category all Routes

Route::controller(CategoryController::class)->group(function (){

    Route::get('/all/category', 'AllCategory')->name('all.category'); 
    Route::get('/add/category', 'AddCategory')->name('add.category'); 
    Route::post('/store/category', 'StoreCategory')->name('category.store'); 
    Route::get('/edit/category/{id}', 'EditCategory')->name('edit.category'); 
    Route::post('/update/category/', 'UpdateCategory')->name('category.update'); 
    Route::get('/delete/category/{id}', 'DeleteCategory')->name('delete.category');

});

// subCategory all Routes

Route::controller(CategoryController::class)->group(function (){

    Route::get('/all/subcategory', 'AllSubCategory')->name('all.subcategory'); 
    Route::get('/add/subcategory', 'AddSubCategory')->name('add.subcategory'); 
    Route::post('/store/subcategory', 'StoreSubCategory')->name('subcategory.store'); 
    Route::get('/edit/subcategory/{id}', 'EditSubCategory')->name('edit.subcategory'); 
    Route::post('/update/subcategory', 'UpdateSubCategory')->name('subcategory.updated'); 
    Route::get('/delete/subcategory/{id}', 'DeleteSubCategory')->name('delete.subcategory');
    Route::get('/subcategory/ajax/{category_id}', 'GetSubCategory');
});

//Admin User all route

Route::controller(AdminController::class)->group(function (){

    Route::get('/all/admin', 'AllAdmin')->name('all.admin'); 
    Route::get('/add/admin', 'AddAdmin')->name('add.admin'); 
    Route::post('/store/admin', 'StoreAdmin')->name('admin.store'); 
    Route::get('/edit/admin/{id}', 'EditAdmin')->name('edit.admin'); 
    Route::post('/update/admin', 'UpdateAdmin')->name('admin.update'); 
    Route::get('/delete/admin/{id}', 'DeleteAdmin')->name('delete.admin');
    Route::get('/inactive/admin/user/{id}', 'InactiveAdminUser')->name('inactive.admin.user');
    Route::get('/active/admin/user/{id}', 'ActiveAdminUser')->name('active.admin.user');

}); //end 

// news post all route
Route::controller(NewsPostController::class)->group(function (){

    Route::get('/all/news/post', 'AllNewsPost')->name('all.news.post'); 
    Route::get('/add/news/post', 'AddNewsPost')->name('add.news.post'); 
    Route::post('/store/news/post', 'StoreNewsPost')->name('store.news.post'); 
    Route::get('/edit/news/post/{id}', 'EditNewsPost')->name('edit.news.post'); 
    Route::post('/update/news/post','UpdateNewsPost')->name('update.news.post');
    Route::get('/delete/news/post/{id}','DeleteNewsPost')->name('delete.news.post');
    Route::get('/inactive/news/post/{id}','InactiveNewsPost')->name('inactive.news.post');
    Route::get('/active/news/post/{id}','ActiveNewsPost')->name('active.news.post');

}); 



}); // end admin middleware


// access for all

Route::get('/news/details/{id}/{slug}',[IndexController::class, 'NewsDetails']);
Route::get('/news/category/{id}/{slug}',[IndexController::class, 'CatWiseNews']);
Route::get('/news/subcategory/{id}/{slug}',[IndexController::class, 'SubCatWiseNews']);
Route::get('/lang/change',[IndexController::class, 'Change'])->name('changeLang');

// end access for all


