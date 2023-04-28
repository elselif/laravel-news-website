<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\NewsPost;
use Intervention\Image\Facades\Image;
use Carbon\Carbon; 



class NewsPostController extends Controller
{
    public function AllNewsPost()
    {
        $allnews = NewsPost::latest()->get(); //NewsPost bir model sınıfıdır ve news_posts tablosuna karşılık gelir. latest() yöntemi, en son oluşturulan haberleri en üstte olacak şekilde sıralar. get() yöntemi ise sorguyu yürütür ve sonucu bir koleksiyon olarak döndürür.
        return view('backend.news.all_news_post', compact('allnews'));
    } //end method

    public function AddNewsPost()
    {
        $categories = Category::latest()->get();
        $subcategories = SubCategory::latest()->get();
        $adminuser = User::where('role','admin')->latest()->get();
        
        return view('backend.news.add_news_post', compact('categories', 'subcategories','adminuser'));
    } //end method

    public function StoreNewsPost(Request $request)
    {
        $image = $request -> file('image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension(); //hexdec() yöntemi, onaltılık sayı sisteminden ondalık sayı sistemine dönüştürür. uniqid() yöntemi, benzersiz bir ID oluşturur. getClientOriginalExtension() yöntemi, yüklenen dosyanın uzantısını döndürür.
        Image::make($image)->resize(784,436)->save('upload/news/'.$name_gen); //make() yöntemi, yeni bir görüntü örneği oluşturur. resize() yöntemi, görüntüyü yeniden boyutlandırır. save() yöntemi, görüntüyü belirtilen yola kaydeder.
        $save_url = 'upload/news'.$name_gen;

        NewsPost::insert([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'user_id' => $request->user_id,
            'news_title' => $request->news_title,
            'news_title_slug' => strtolower(str_replace(' ','-',$request->news_title)),

            'news_details' => $request->news_details,
            'tags' => $request->tags,

            'breaking_news' => $request->breaking_news,
            'top_slider' => $request->top_slider,
            'first_section_three' => $request->first_section_three,
            'first_section_nine' => $request->first_section_nine,

            'post_date' => date('d-m-Y'),
            'post_month' => date('F'),
            'image' => $save_url,
            'created_at' => Carbon::now(),  

        ]); //end insert method
        $notification = array(
            'message' => 'News Post Inserted Successfully',
            'alert-type' => 'success'

        );
        return redirect()->route('all.news.post')->with($notification);
        
    } //end method

    public function EditNewsPost($id)
    {   
        $categories = Category::latest()->get();
        $subcategories = SubCategory::latest()->get();
        $adminuser = User::where('role','admin')->latest()->get();
        $newspost = NewsPost::findOrFail($id);
        return view('backend.news.edit_news_post', compact('categories', 'subcategories','adminuser','newspost'));
    } //end method


    public function UpdateNewsPost(Request $request){

        $newspost_id = $request->id;

        if ($request->file('image')) {

        $image = $request->file('image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(784,436)->save('upload/news/'.$name_gen);
        $save_url = 'upload/news/'.$name_gen;

        NewsPost::findOrFail($newspost_id)->update([

            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'user_id' => $request->user_id,
            'news_title' => $request->news_title,
            'news_title_slug' => strtolower(str_replace(' ','-',$request->news_title)),

            'news_details' => $request->news_details,
            'tags' => $request->tags,

            'breaking_news' => $request->breaking_news,
            'top_slider' => $request->top_slider,
            'first_section_three' => $request->first_section_three,
            'first_section_nine' => $request->first_section_nine,

            'post_date' => date('d-m-Y'),
            'post_month' => date('F'),
            'image' => $save_url,
            'updated_at' => Carbon::now(),  

        ]);

         $notification = array(
            'message' => 'News Post Updated with Image Successfully',
            'alert-type' => 'success'

        );
        return redirect()->route('all.news.post')->with($notification);


        }else{

             NewsPost::findOrFail($newspost_id)->update([

            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'user_id' => $request->user_id,
            'news_title' => $request->news_title,
            'news_title_slug' => strtolower(str_replace(' ','-',$request->news_title)),

            'news_details' => $request->news_details,
            'tags' => $request->tags,

            'breaking_news' => $request->breaking_news,
            'top_slider' => $request->top_slider,
            'first_section_three' => $request->first_section_three,
            'first_section_nine' => $request->first_section_nine,

            'post_date' => date('d-m-Y'),
            'post_month' => date('F'), 
            'updated_at' => Carbon::now(),  

        ]);

         $notification = array(
            'message' => 'News Post Updated without Image Successfully',
            'alert-type' => 'success'

        );
        return redirect()->route('all.news.post')->with($notification);

        } 

    }// End Method
 


    }




