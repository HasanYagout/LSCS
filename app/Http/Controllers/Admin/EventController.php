<?php

namespace App\Http\Controllers\Admin;

use App\Models\EventCategory;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Services\EventService;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    use ResponseTrait;
    public $eventService;

    public function __construct()
    {
        $this->eventService = new EventService();
    }
    public function create(Request $request)
    {
        $data['title'] = __('Create Event');
        $data['showEvent'] = 'show';
        $data['activeEventCreate'] = 'active';
        $data['categories'] = EventCategory::where('tenant_id', getTenantId())->get();
        // if ($request->ajax()) {
        //     return $this->eventService->list();
        // }
        return view('admin.event.eventCreate.create', $data);
    }
    public function myEvent(Request $request)
    {
        $data['title'] = __('My Event');
        $data['showEvent'] = 'show';
        $data['activeMyEvent'] = 'active';
        if ($request->ajax()) {
            return $this->eventService->myEvent();
        }
        return view('admin.event.myEvent.index', $data);
    }
    public function all(Request $request)
    {
        $data['title'] = __('All Event');
        $data['showEvent'] = 'show';
        $data['activeAllEvent'] = 'active';
        if ($request->ajax()) {
            return $this->eventService->allEvent();
        }
        return view('admin.event.allEvent.index', $data);
    }

    public function pending(Request $request){
        $data['title'] = __('Pending Event');
        $data['showEvent'] = 'show';
        $data['activeEventPending'] = 'active';
        if ($request->ajax()) {
            return $this->eventService->pending();
        }
        return view('admin.event.pending.index', $data);
    }
}
