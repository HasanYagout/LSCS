<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NoticeRequest;
use App\Http\Services\NoticeCategoryService;
use App\Http\Services\NoticeService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    use ResponseTrait;
    public $noticeService;

    public function __construct()
    {
        $this->noticeService = new NoticeService();
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->noticeService->list();
        }
        $categoryService = new NoticeCategoryService();
        $data['title'] = __('Notice');
        $data['showManageNotice'] = 'show';
        $data['activeManageNotice'] = 'active';
        $data['categories'] = $categoryService->activeCategory();
        return view('admin.notices.index', $data);
    }

    public function store(NoticeRequest $request)
    {
        return  $this->noticeService->store($request);
    }

    public function info($id)
    {
        $categoryService = new NoticeCategoryService();
        $data['notice'] = $this->noticeService->getById($id);
        $data['categories'] = $categoryService->activeCategory();
        return view('admin.notices.edit-form', $data);
    }

    public function update($id, NoticeRequest $request)
    {
        return $this->noticeService->update($id, $request);
    }

    public function delete($id)
    {
        return $this->noticeService->deleteById($id);
    }
}
