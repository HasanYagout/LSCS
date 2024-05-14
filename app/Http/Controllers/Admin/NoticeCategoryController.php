<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NoticeCategoryRequest;
use App\Http\Services\NoticeCategoryService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class NoticeCategoryController extends Controller
{
    use ResponseTrait;
    public $noticeCategoryService;

    public function __construct()
    {
        $this->noticeCategoryService = new NoticeCategoryService();
    }

    public function index(Request $request)
    {
        $data['title'] = __('Notice Category');
        $data['showManageNotice'] = 'show';
        $data['activeNoticeCategory'] = 'active';
        if ($request->ajax()) {
            return $this->noticeCategoryService->list();
        }
        return view('admin.notices.categories.index', $data);
    }

    public function store(NoticeCategoryRequest $request)
    {
        return  $this->noticeCategoryService->store($request);
    }

    public function info($id)
    {
        $data['noticeCategory'] = $this->noticeCategoryService->getById($id);
        return view('admin.notices.categories.edit-form', $data);
    }

    public function update(NoticeCategoryRequest $request, $id)
    {
        return $this->noticeCategoryService->update($id, $request);
    }

    public function delete($id)
    {
        return $this->noticeCategoryService->deleteById($id);
    }

}
