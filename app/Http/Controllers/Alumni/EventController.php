<?php

namespace App\Http\Controllers\Alumni;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\EventCategory;
use App\Traits\ResponseTrait;
use App\Http\Requests\EventRequest;
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
        return view('alumni.event.eventCreate.create', $data);
    }

    public function store(EventRequest $request)
    {
        if(isAddonInstalled('ALUSAAS') && getPackageLimit(PACKAGE_RULE_EVENT_LIMIT) != -1 && getPackageLimit(PACKAGE_RULE_EVENT_LIMIT) <= 0){
            return $this->error([], __('The event create limit has been finished please upgrade the plan from admin panel'));
        }
        return  $this->eventService->store($request);
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

    public function all(Request $request)
    {
        $data['title'] = __('All Event');
        $data['showEvent'] = 'show';
        $data['activeAllEvent'] = 'active';
        if ($request->ajax()) {
            return $this->eventService->allEvent();
        }
        return view('alumni.event.allEvent.index', $data);
    }

    public function details($slug)
    {
        $data['title'] = __('Event Details');
        $data['showEvent'] = 'show';
        $data['activeAllEvent'] = 'active';
        $data['event'] = Event::where('slug', $slug)->first();
        return view('alumni.event.event-details', $data);
    }

    public function myEvent(Request $request)
    {
        $data['title'] = __('My Event');
        $data['showEvent'] = 'show';
        $data['activeMyEvent'] = 'active';
        if ($request->ajax()) {
            return $this->eventService->myEvent();
        }
        return view('alumni.event.myEvent.index', $data);
    }

    public function edit($slug)
    {
        $data['title'] = __('Edit Event');
        $data['categories'] = EventCategory::where('tenant_id', getTenantId())->get();
        $data['event'] = $this->eventService->getEvent($slug);
        return view('admin.event.pending.edit', $data);
    }

    public function update(EventRequest $request, $slug)
    {
        return $this->eventService->update($request, $slug);
    }

    public function delete($id)
    {
        return $this->eventService->deleteById($id);
    }


}
