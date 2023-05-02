<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsPost;
use App\Models\Category;

class IndexController extends Controller
{
    public function Index(){

        return view('frontend.index');

    } //End method

    public function NewsDetails($id,$slug){

        $news = NewsPost::findOrFail($id);

        $tags = $news->tags;
        $tags_all = explode(',',$tags);

        $cat_id = $news->category_id;
        $relatedNews = NewsPost::where('category_id',$cat_id)-> where('id','!=',$id) ->orderBy('id','desc')->limit(6)->get();

        return view('frontend.news.news_details', compact('news','tags_all','relatedNews'));

    }


     public function CatWiseNews($id,$slug)
     {
        $news = NewsPost::where('status',1)->where('category_id',$id)->orderBy('id','desc')->get();

        $breadcat = Category::where('id',$id)->first();

        $newstwo = NewsPost::where('status',1)->where('category_id',$id)->orderBy('id','desc')->limit(2)->get();


        return view('frontend.news.category_news', compact('news','breadcat','newstwo'));
     }

}
