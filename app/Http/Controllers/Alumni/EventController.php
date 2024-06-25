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
        $data['events']=Event::where('status',STATUS_ACTIVE)->paginate(15);
        return view('alumni.event.pending', $data);
    }

    public function all(Request $request)
    {
        $data['title'] = __('All Event');
        $data['showEvent'] = 'show';
        $data['activeAllEvent'] = 'active';

        // Start the query for fetching events
        $query = Event::query();

        // Check if there is a search term
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            // Modify the query to filter based on the search term
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%");

            });
        }

        // Continue with status filtering
        $query->where(function($q) {
            $q->where('status', STATUS_ACTIVE)
                ->orWhere('status', STATUS_INACTIVE);
        });

        // Execute the query and paginate results
        $data['events'] = $query->paginate(15);

        return view('alumni.event.all', $data);
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




}
