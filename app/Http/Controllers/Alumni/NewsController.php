<?php

namespace App\Http\Controllers\Alumni;
use App\Models\News;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Services\NewsService;
use App\Http\Controllers\Controller;
use App\Http\Services\NewsTagService;
use App\Http\Services\NewsCategoryService;

class NewsController extends Controller
{

    use ResponseTrait;
    public $newsService;

    public function __construct()
    {
        $this->newsService = new NewsService();
    }

    public function index(Request $request){

        $categoryService = new NewsCategoryService();
        $tagService = new NewsTagService();
        $data['categories'] = $categoryService->activeCategory();
        $data['title']= 'All News List';
        $data['news']=News::all();
        return view('alumni.news.all-news', $data);
    }

    public function newsDetails($slug){
        $data['title']= 'News Details';
        $data['news']= News::where('slug',$slug)->first();
        return view('alumni.news.news-details', $data);
    }
}
