<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsCategoryRequest;
use App\Http\Services\NewsCategoryService;
use App\Models\NewsCategory;
use App\Traits\ResponseTrait;
use Brian2694\Toastr\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
            return $this->newsCategoryService->list($request);
        }
        return view('admin.news.categories.index', $data);
    }

    public function store(NewsCategoryRequest $request)
    {
        $this->newsCategoryService->store($request);
        // Flash a success message to the session
        session()->flash('success', 'News category created successfully.');
        // Redirect back with a success message
        return redirect()->route('admin.news.categories.index');
    }

    public function info($id)
    {
        $data['newsCategory'] = $this->newsCategoryService->getById($id);
        return view('admin.news.categories.edit-form', $data);
    }

    public function update(NewsCategoryRequest $request, $id)
    {
        $newsCategory = $this->newsCategoryService->update($id, $request);

        // Flash a success message to the session
        session()->flash('success', 'News category updated successfully.');

        // Redirect back with a success message
        return redirect()->route('admin.news.categories.index');
    }

    public function delete($id)
    {
        return $this->newsCategoryService->deleteById($id);
    }

}
