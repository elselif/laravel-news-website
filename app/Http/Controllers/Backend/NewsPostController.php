<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsPostController extends Controller
{
    public function AllNewsPost()
    {
        return view('backend.news.news_post');
    } //end method
}
