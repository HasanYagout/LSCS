<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsRequest;
use App\Http\Services\NewsCategoryService;
use App\Http\Services\NewsService;
use App\Http\Services\NewsTagService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

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
            return $this->newsService->list();
        }
        $categoryService = new NewsCategoryService();
        $tagService = new NewsTagService();
        $data['title'] = __('News');
        $data['showManageNews'] = 'show';
        $data['activeManageNews'] = 'active';
        $data['categories'] = $categoryService->activeCategory();
        $data['tags'] = $tagService->activeTag();
        return view('admin.news.index', $data);
    }

    public function store(NewsRequest $request)
    {
        return $this->newsService->store($request);
    }

    public function info($id)
    {
        $categoryService = new NewsCategoryService();
        $tagService = new NewsTagService();
        $data['news'] = $this->newsService->getById($id);
        $data['categories'] = $categoryService->activeCategory();
        $data['tags'] = $tagService->activeTag();
        $data['oldTags'] = $data['news']->tags->pluck('id')->toArray();
        return view('admin.news.edit-form', $data);
    }

    public function update($id, NewsRequest $request)
    {
        return $this->newsService->update($id, $request);
    }

    public function delete($id)
    {
        return $this->newsService->deleteById($id);
    }
}
