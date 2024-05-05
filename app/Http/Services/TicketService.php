<?php

namespace App\Http\Services;

use App\Models\EventTicket;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class TicketService
{
    use ResponseTrait;

    public function list()
    {
        $ticket = EventTicket::where('user_id', auth()->id())->where('tenant_id', getTenantId())
            ->with('event')
            ->orderBy('event_id', 'DESC')
            ->get();
             return datatables($ticket)
            ->addIndexColumn()
            ->addColumn('event', function ($data) {
                return '<p>' . htmlspecialchars($data->event->title) . '</p>';
            })
            ->addColumn('date', function ($data) {
                return '<p>' . $data->event->date . '</p>';
            })
            ->addColumn('location', function ($data) {
                return '<p>' . htmlspecialchars($data->event->location) . '</p>';
            })
            ->addColumn('type', function ($data) {
                if ($data->event->type == 1) {
                    return '<span class="zBadge-free">Free</span>';
                } else {
                    return '<span class="zBadge-paid">Paid</span>';
                }
            })
            ->addColumn('action', function ($data){
                return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                            <li class="d-flex gap-2">
                                <a onclick="getTicketModal(\'' . route('event.single-ticket', $data->id) . '\'' . ', \'#ticketViewModal\')" href="#" class="d-block min-w-130 text-decoration-underline fw-600 text-1b1c17" data-bs-toggle="modal" data-bs-target="#ticketViewModal">'.__("Download").'</a>
                            </li>
                        </ul>';
            })
            ->rawColumns(['action', 'type', 'date', 'event', 'location'])
            ->make(true);
    }

    public function getTicket($id)
    {
        return EventTicket::where('id', $id)->with('user.alumni')->where('tenant_id', getTenantId())->first();
    }

}
