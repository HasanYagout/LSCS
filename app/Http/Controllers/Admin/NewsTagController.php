<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsTagRequest;
use App\Http\Services\NewsTagService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class NewsTagController extends Controller
{
    use ResponseTrait;
    public $newsTagService;

    public function __construct()
    {
        $this->newsTagService = new NewsTagService();
    }

    public function index(Request $request)
    {
        $data['title'] = __('News Tags');
        $data['showManageNews'] = 'show';
        $data['activeNewsTag'] = 'active';
        if ($request->ajax()) {
            return $this->newsTagService->list();
        }
        return view('admin.news.tags.index', $data);
    }

    public function store(NewsTagRequest $request)
    {
        return  $this->newsTagService->store($request);
    }
    public function info($id)
    {
        $data['newsTag'] = $this->newsTagService->getById($id);
        return view('admin.news.tags.edit-form', $data);
    }
    public function update(NewsTagRequest $request, $id)
    {
        return $this->newsTagService->update($id, $request);
    }
    public function delete($id)
    {
        return $this->newsTagService->deleteById($id);
    }
}
