<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Services\EventService;
use App\Http\Services\Frontend\HomeService;
use App\Traits\ResponseTrait;

class EventController extends Controller
{
    use ResponseTrait;
    public $homeService;
    public $eventService;

    public function __construct()
    {
        $this->homeService = new HomeService();
        $this->eventService = new EventService();
    }

    public function event()
    {
        $data['title'] = __('Event');
        $data['allEvent'] = $this->homeService->getEvent(6);
        return view('web.events.all_event', $data);
    }

    public function eventDetails($slug)
    {
        $data['title'] = __('Event');
        $data['event'] = $this->eventService->getEvent($slug);
        return view('web.events.event_details', $data);
    }

}
