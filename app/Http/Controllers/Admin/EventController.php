<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Services\EventService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

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
        $data['categories'] = EventCategory::all();
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
        return view('admin.event.my-event', $data);
    }
    public function all(Request $request)
    {
        $data['title'] = __('All Event');
        $data['showEvent'] = 'show';
        $data['activeAllEvent'] = 'active';

        if ($request->ajax()) {
            return $this->eventService->allEvent();
        }

        return view('admin.event.all', $data);
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
    public function store(Request $request)
    {
        $event = new Event();
        $event->event_category_id = $request->event_category_id;
        $event->title = $request->title;
        $event->slug = getSlug($request->title) . '-' . rand(100000, 999999);

// Generate the new filename
        $date = now()->format('Ymd');
        $randomSlug = Str::random(6);
        $randomNumber = rand(100000, 999999);
        $newFilename = "{$date}_{$randomSlug}_{$randomNumber}.{$request->file('thumbnail')->getClientOriginalExtension()}";

// Move the file to the specified directory
        $request->file('thumbnail')->storeAs('public/admin/events', $newFilename);

        $event->thumbnail = $newFilename;
        $event->date = $request->date;
        $event->description = $request->description;
        $event->user_id = auth('admin')->id();
        $event->save();
        return $this->success([], getMessage(CREATED_SUCCESSFULLY));


    }
    public function details($slug)
    {
        $data['title'] = __('Event Details');
        $data['showEvent'] = 'show';
        $data['activeAllEvent'] = 'active';
        $data['event'] = Event::where('slug', $slug)->first();
        return view('admin.event.event-details', $data);
    }
    public function edit($slug)
    {
        $data['title'] = __('Edit Event');
        $data['categories'] = EventCategory::all();
        $data['event'] = $this->eventService->getEvent($slug);
        return view('admin.event.pending.edit', $data);
    }

    public function update(EventRequest $request, $slug)
    {
        return $this->eventService->update($request, $slug);
    }

    public function toggleStatus(Request $request)
    {
        $event = Event::find($request->id);
        if ($event) {
            $event->status = $event->status == STATUS_ACTIVE ? STATUS_INACTIVE : STATUS_ACTIVE;
            $event->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

    public function delete($id)
    {
        return $this->eventService->deleteById($id);
    }
}
