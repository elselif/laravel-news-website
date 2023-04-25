<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\NewsPost;

class NewsPostController extends Controller
{
    public function AllNewsPost()
    {
        $allnews = NewsPost::latest()->get(); //NewsPost bir model sınıfıdır ve news_posts tablosuna karşılık gelir. latest() yöntemi, en son oluşturulan haberleri en üstte olacak şekilde sıralar. get() yöntemi ise sorguyu yürütür ve sonucu bir koleksiyon olarak döndürür.
        return view('backend.news.all_news_post', compact('allnews'));
    } //end method
}
