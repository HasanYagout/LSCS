<?php

namespace App\Http\Controllers\Alumni;
use App\Models\EventTicket;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Services\TicketService;
use Exception;

class TicketController extends Controller
{

    use ResponseTrait;
    public $ticketService;

    public function __construct()
    {
        $this->ticketService = new TicketService();
    }

    public function myTicket(Request $request)
    {
        $data['title'] = __('My Ticket');
        $data['showEvent'] = 'show';
        $data['activeTicket'] = 'active';
        if ($request->ajax()) {
            return $this->ticketService->list();
        }
        return view('alumni.event.myTicket.index', $data);
    }

    public function singleTicket($id)
    {
        $data['ticket'] = $this->ticketService->getTicket($id);
        return view('alumni.event.myTicket.ticket-modal', $data);
    }
}
