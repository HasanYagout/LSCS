<?php

namespace App\Http\Controllers\Admin;

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
