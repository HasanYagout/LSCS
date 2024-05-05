<?php

namespace App\Http\Services;

use App\Models\Event;
use App\Models\EventCategory;
use App\Traits\ResponseTrait;
use App\Models\FileManager;
use Exception;
use Illuminate\Support\Facades\DB;

class EventService
{
    use ResponseTrait;

    public function pending()
    {
        $eventPending = Event::where('events.status', STATUS_PENDING)
            ->join('event_categories', 'event_categories.id', '=', 'events.event_category_id')
            ->where('events.tenant_id', getTenantId())
            ->select('events.*', 'event_categories.name')
            ->orderBy('events.id','DESC');

        return datatables($eventPending)
            ->addIndexColumn()
            ->addColumn('category', function ($data) {
                return '<p class="min-w-130 text-center zBadge">' . htmlspecialchars($data->name) . '</p>';
            })
            ->addColumn('type', function ($data) {
                if ($data->type == 1) {
                    return '<span class="zBadge-free">'.__('Free').'</span>';
                } else {
                    return '<span class="zBadge-paid">'.__('Paid').'</span>';
                }
            })
            ->addColumn('date', function ($data) {
                return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->date)->format('jS F, h:i:s A');
            })

            ->addColumn('action', function ($data){
                return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                            <li class="d-flex gap-2">
                                <button onclick="getEditModal(\'' . route('event.edit', $data->slug) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="'.__('Edit').'">
                                    <img src="' . asset('assets/images/icon/edit.svg') . '" alt="edit" />
                                </button>

                                <button onclick="deleteItem(\'' . route('event.delete', $data->id) . '\', \'eventPendingDataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="'.__('Delete').'">
                                    <img src="' . asset('assets/images/icon/delete-1.svg') . '" alt="delete">
                                </button>
                                <a href="'. route('event.details', $data->slug) .'" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="View">
                                    <img src="' . asset('assets/images/icon/eye.svg') . '" alt="view">
                                </a>
                            </li>
                        </ul>';
            })
            ->rawColumns(['type', 'action', 'category', 'date'])
            ->make(true);
    }


    public function allEvent()
    {
        $allEvent = Event::where('status', STATUS_ACTIVE)->where('tenant_id', getTenantId())->orderBy('created_at', 'desc');
        return datatables($allEvent)
            ->addIndexColumn()
            ->addColumn('category', function ($data) {
                return '<p class="min-w-130 text-center zBadge">' . htmlspecialchars($data->category->name) . '</p>';
            })
            ->addColumn('type', function ($data) {
                if ($data->type == 1) {
                    return '<span class="zBadge-free">'.__('Free').'</span>';
                } else {
                    return '<span class="zBadge-paid">'.__('Paid').'</span>';
                }
            })
            ->addColumn('date', function ($data) {
                return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->date)->format('jS F, h:i:s A');
            })
            ->addColumn('action', function ($data){
                return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                            <li class="d-flex gap-2">
                                <a href="'. route('event.details', $data->slug) .'" class="d-block text-decoration-underline fw-600 text-1b1c17">'.__('Reservation').'</a>
                            </li>
                        </ul>';
            })
            ->rawColumns(['type', 'action', 'category', 'date'])
            ->make(true);
    }


    public function myEvent()
    {
        $event = Event::where('user_id', auth()->id())->where('tenant_id', getTenantId())->orderBy('created_at', 'desc');
        return datatables($event)
            ->addIndexColumn()
            ->addColumn('category', function ($data) {
                return '<p class="min-w-130 text-center zBadge">' . htmlspecialchars($data->category->name) . '</p>';
            })
            ->addColumn('type', function ($data) {
                if ($data->type == 1) {
                    return '<span class="zBadge-free">'.__('Free').'</span>';
                } else {
                    return '<span class="zBadge-paid">'.__('Paid').'</span>';
                }
            })
            ->addColumn('date', function ($data) {
                return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->date)->format('jS F, h:i:s A');
            })

            ->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    return '<p class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-0fa958 bg-0fa958-10">'.__('Approved').'</p>';
                } else {
                    return '<p class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-f5b40a bg-f5b40a-10">'.__('Pending').'</p>';
                }
            })

            ->addColumn('action', function ($data){
                return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                            <li class="d-flex gap-2">
                                <button onclick="getEditModal(\'' . route('event.edit', $data->slug) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="'.__('Edit').'">
                                    <img src="' . asset('assets/images/icon/edit.svg') . '" alt="edit" />
                                </button>

                                <button onclick="deleteItem(\'' . route('event.delete', $data->id) . '\', \'myEventDataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="'.__('Delete').'">
                                    <img src="' . asset('assets/images/icon/delete-1.svg') . '" alt="delete">
                                </button>

                                <a href="'. route('event.details', $data->slug) .'" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="view">
                                    <img src="' . asset('assets/images/icon/eye.svg') . '" alt="view">
                                </a>
                            </li>
                        </ul>';
            })

            ->rawColumns(['type', 'action', 'status', 'category', 'date'])
            ->make(true);
    }


    public function store($request)
    {
        try {
            DB::beginTransaction();
            if (Event::where('slug', getSlug($request->title))->where('tenant_id', getTenantId())->withTrashed()->count() > 0) {
                $slug = getSlug($request->title) . '-' . rand(100000, 999999);
            } else {
                $slug = getSlug($request->title);
            }
            $event = new Event();
            $event->title = $request->title;
            $event->event_category_id = $request->event_category_id;
            $event->slug = $slug;
            $event->date = date("Y-m-d H:i:s", strtotime($request->date));
            $event->type = $request->type;
            $event->location = $request->location;
            if($request->type == EVENT_TYPE_PAID){
                $event->price = $request->price;
            }
            $event->number_of_ticket = $request->number_of_ticket;
            $event->number_of_ticket_left = $request->number_of_ticket;
            $event->description = $request->description;
            $event->user_id = auth()->id();
            $event->tenant_id = getTenantId();

            if ($request->hasFile('thumbnail')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('event', $request->thumbnail);
                $event->thumbnail = $uploaded->id;
            }

            if ($request->hasFile('ticket_image')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('event', $request->ticket_image);
                $event->ticket_image = $uploaded->id;
            }

            $event->save();
            DB::commit();
            return $this->success([], getMessage(CREATED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

    public function update($request, $currenSlug)
    {
        DB::beginTransaction();
        if (Event::where('slug', getSlug($request->title))->where('tenant_id', getTenantId())->where('slug', '!=', $currenSlug)->withTrashed()->count() > 0) {
            $slug = getSlug($request->title) . '-' . rand(100000, 999999);
        } else {
            $slug = getSlug($request->title);
        }

        try {
            $event = Event::where('slug', $currenSlug)->where('tenant_id', getTenantId())->with('eventTicket')->first();

            if(is_null($event)){
                return $this->error([], __('No Data Found'));
            }

            $soldTicket = count($event->eventTicket);

            if($soldTicket > (int) $request->number_of_ticket){
                return $this->error([], __('Number of ticket should be more than '. $soldTicket));
            }

            $event->title = $request->title;
            $event->slug = $slug;
            $event->event_category_id = $request->event_category_id;
            $event->date = $request->date;
            $event->type = $request->type;
            $event->location = $request->location;
            if($request->type == EVENT_TYPE_PAID){
                $event->price = $request->price;
            }else{
                $event->price = 0;
            }
            $event->number_of_ticket = $request->number_of_ticket;
            $event->number_of_ticket_left = $request->number_of_ticket - $soldTicket;
            $event->description = $request->description;
            if($request->status != NULL){
                $event->status = $request->status;
            }
            if ($request->hasFile('thumbnail')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('event', $request->thumbnail);
                $event->thumbnail = $uploaded->id;
            }
            if ($request->hasFile('ticket_image')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('event', $request->ticket_image);
                $event->ticket_image = $uploaded->id;
            }
            $event->save();
            DB::commit();
            $message = getMessage(UPDATED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function getEvent($slug){
        return Event::where('slug', $slug)->where('tenant_id', getTenantId())->first();
    }

    public function deleteById($id)
    {
        try {
            DB::beginTransaction();
            $event = event::where('id', $id)->first();
            $event->delete();
            DB::commit();
            $message = getMessage(DELETED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }
}
