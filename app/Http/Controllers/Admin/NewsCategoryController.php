<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsCategoryRequest;
use App\Http\Services\NewsCategoryService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class NewsCategoryController extends Controller
{
    use ResponseTrait;
    public $newsCategoryService;

    public function __construct()
    {
        $this->newsCategoryService = new NewsCategoryService();
    }

    public function index(Request $request)
    {
        $data['title'] = __('News Category');
        $data['showManageNews'] = 'show';
        $data['activeNewsCategory'] = 'active';
        if ($request->ajax()) {
            return $this->newsCategoryService->list();
        }
        return view('admin.news.categories.index', $data);
    }

    public function store(NewsCategoryRequest $request)
    {
        return  $this->newsCategoryService->store($request);
    }

    public function info($id)
    {
        $data['newsCategory'] = $this->newsCategoryService->getById($id);
        return view('admin.news.categories.edit-form', $data);
    }

    public function update(NewsCategoryRequest $request, $id)
    {
        return $this->newsCategoryService->update($id, $request);
    }

    public function delete($id)
    {
        return $this->newsCategoryService->deleteById($id);
    }

}
