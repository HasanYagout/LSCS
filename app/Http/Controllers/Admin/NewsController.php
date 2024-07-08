<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsRequest;
use App\Http\Services\NewsCategoryService;
use App\Http\Services\NewsService;
use App\Http\Services\NewsTagService;
use App\Models\FileManager;
use App\Models\News;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    use ResponseTrait;
    public $newsService;

    public function __construct()
    {
        $this->newsService = new NewsService();
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
          return $this->newsService->list($request);
        }
        $categoryService = new NewsCategoryService();
        $tagService = new NewsTagService();
        $data['title'] = __('News');
        $data['showManageNews'] = 'show';
        $data['activeManageNews'] = 'active';
        $data['categories'] = $categoryService->activeCategory();

        return view('admin.news.index', $data);
    }

    public function store(NewsRequest $request)
    {
       return $this->newsService->store($request);
    }

    public function info($id)
    {
        $categoryService = new NewsCategoryService();
        $data['news'] = $this->newsService->getById($id);
        $data['categories'] = $categoryService->activeCategory();
        return view('admin.news.edit-form', $data);
    }

    public function update($id, NewsRequest $request)
    {
        return $this->newsService->update($id, $request);

    }
    public function details($slug){
        $data['title']= 'News Details';
        $data['news']= News::where('slug',$slug)->first();
        return view('admin.news.details', $data);
    }

    public function delete($id)
    {
        return $this->newsService->deleteById($id);
    }
}
