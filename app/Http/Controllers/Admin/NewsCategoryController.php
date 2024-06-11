<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsCategoryRequest;
use App\Http\Services\NewsCategoryService;
use App\Models\NewsCategory;
use App\Traits\ResponseTrait;
use Brian2694\Toastr\Toastr;
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
            $newsCategory = NewsCategory::orderBy('id','DESC');
            return datatables($newsCategory)
                ->addIndexColumn()
                ->addColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return '<span class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-0fa958 bg-0fa958-10">Active</span>';
                    } else {
                        return '<span class="zBadge-free">Deactivate</span>';
                    }
                })
                ->addColumn('action', function ($data){
                    return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                            <li class="d-flex gap-2">
                                <button onclick="getEditModal(\'' . route('admin.news.categories.info', $data->id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="'.__('Edit').'">
                                    <img src="' . asset('public/assets/images/icon/edit.svg') . '" alt="edit" />
                                </button>
                                <button onclick="deleteItem(\'' . route('admin.news.categories.delete', $data->id) . '\', \'newsCategoryDataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="'.__('Delete').'">
                                    <img src="' . asset('public/assets/images/icon/delete-1.svg') . '" alt="delete">
                                </button>
                            </li>
                        </ul>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.news.categories.index', $data);
    }

    public function store(NewsCategoryRequest $request)
    {
        // Generate the slug
        $slug = getSlug($request->name);

        // Create and save the news category
        $newsCategory = new NewsCategory();
        $newsCategory->name = $request->name;
        $newsCategory->slug = $slug;
        $newsCategory->posted_by = auth('admin')->id();
        $newsCategory->status = $request->status;
        $newsCategory->save();

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
        return $this->newsCategoryService->update($id, $request);
    }

    public function delete($id)
    {
        return $this->newsCategoryService->deleteById($id);
    }

}
