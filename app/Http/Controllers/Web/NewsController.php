<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Services\Frontend\HomeService;
use App\Http\Services\NewsService;
use App\Traits\ResponseTrait;

class NewsController extends Controller
{
    use ResponseTrait;
    public $homeService;
    public $newsService;

    public function __construct()
    {
        $this->homeService = new HomeService();
        $this->newsService = new NewsService();
    }

    public function news()
    {
        $data['title'] = __('News');
        $data['allNews'] = $this->homeService->getNews(6);
        return view('web.news.all_news', $data);
    }

    public function newsDetails($slug)
    {
        $data['title'] = __('News');
        $data['news'] = $this->newsService->getNewsBySlug($slug);;
        return view('web.news.news_details', $data);
    }

}
