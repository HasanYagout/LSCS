<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EventCategoryRequest;
use App\Http\Services\EventCategoryService;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;

class EventCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     use ResponseTrait;
    public $eventCategoryService;

    public function __construct()
    {
        $this->eventCategoryService = new EventCategoryService();
    }

    public function index(Request $request)
    {
        $data['title'] = __('Event Category');
        $data['showEvent'] = 'show';
        $data['activeEventCategory'] = 'active';
        if ($request->ajax()) {
            return $this->eventCategoryService->list();
        }
        return view('admin.event.category.index', $data);

    }

    public function store(EventCategoryRequest $request)
    {
        return  $this->eventCategoryService->store($request);
    }

    public function info($id)
    {
        $data['eventCategory'] = $this->eventCategoryService->getById($id);
        return view('admin.event.category.edit-form', $data);
    }

    public function update(EventCategoryRequest $request, $id)
    {
        return $this->eventCategoryService->update($id, $request);
    }

    public function delete($id)
    {
        return $this->eventCategoryService->deleteById($id);
    }


}
