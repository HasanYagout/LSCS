<?php

namespace App\Http\Services;

use App\Models\Event;
use App\Models\EventCategory;
use App\Traits\ResponseTrait;
use App\Models\FileManager;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventService
{
    use ResponseTrait;

    public function pending()
    {
        $eventPending = Event::with('category')->where('status', STATUS_ACTIVE)
            ->orderBy('id','DESC');

        return datatables($eventPending)
            ->addIndexColumn()
            ->addColumn('category', function ($data) {
                return '<p class="min-w-130 text-center zBadge">' . htmlspecialchars($data->category->name) . '</p>';
            })
            ->addColumn('date', function ($data) {
                return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->date)->format('jS F, h:i:s A');
            })
            ->addColumn('action', function ($data){
                $checked = $data->status == STATUS_ACTIVE ? 'checked' : '';
                return '<div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="statusSwitch' . $data->id . '" ' . $checked . ' onclick="toggleStatus(' . $data->id . ')">
                    </div>';
            })
            ->rawColumns(['type', 'action', 'category', 'date'])
            ->make(true);
    }


    public function allEvent()
    {
        $allEvent = Event::where('status', STATUS_ACTIVE)
            ->orWhere('status', STATUS_PENDING)
            ->orderBy('created_at', 'desc');
        return datatables($allEvent)
            ->addIndexColumn()
            ->addColumn('category', function ($data) {
                return '<p class="min-w-130 text-center zBadge">' . htmlspecialchars($data->category->name) . '</p>';
            })
            ->addColumn('date', function ($data) {
                return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->date)->format('jS F, h:i:s A');
            })
            ->addColumn('status', function ($data) {
                $checked = $data->status == STATUS_ACTIVE ? 'checked' : '';
                return '<div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="statusSwitch' . $data->id . '" ' . $checked . ' onclick="toggleStatus(' . $data->id . ')">
                    </div>';            })
            ->addColumn('action', function ($data){
                return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                            <li class="d-flex gap-2">
                                <button onclick="getEditModal(\'' . route('admin.event.edit', $data->slug) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="'.__('Edit').'">
                                    <img src="' . asset('public/assets/images/icon/edit.svg') . '" alt="edit" />
                                </button>

                                <button onclick="deleteItem(\'' . route('admin.event.delete', $data->id) . '\', \'myEventDataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="'.__('Delete').'">
                                    <img src="' . asset('public/assets/images/icon/delete-1.svg') . '" alt="delete">
                                </button>

                                <a href="'. route('admin.event.details', $data->slug) .'" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="view">
                                    <img src="' . asset('public/assets/images/icon/eye.svg') . '" alt="view">
                                </a>
                            </li>
                        </ul>';
            })
            ->rawColumns(['action','status', 'category', 'date'])
            ->make(true);
    }


    public function myEvent()
    {
        $event = Event::where('user_id', auth('admin')->id())->orderBy('created_at', 'desc');
        return datatables($event)
            ->addIndexColumn()
            ->addColumn('category', function ($data) {
                return '<p class="min-w-130 text-center zBadge">' . htmlspecialchars($data->category->name) . '</p>';
            })

            ->addColumn('date', function ($data) {
                return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->date)->format('jS F, h:i:s A');
            })

            ->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    return '<p class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-0fa958 bg-0fa958-10">'.__('Active').'</p>';
                } else {
                    return '<p class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-f5b40a bg-f5b40a-10">'.__('InActive').'</p>';
                }
            })

            ->rawColumns(['type', 'status', 'category', 'date'])
            ->make(true);
    }


    public function store($request)
    {
        try {
            DB::beginTransaction();

            // Check if an event with the same slug exists
            if (Event::where('slug', getSlug($request->title))->count() > 0) {
                $slug = getSlug($request->title) . '-' . rand(100000, 999999);
            } else {
                $slug = getSlug($request->title);
            }

            // Create a new Event model instance
            $event = new Event();

            // Assign values to the event model's properties
            $event->event_category_id = $request->event_category_id;
            $event->title = $request->title;
            $event->slug = $slug;
            // Generate the new filename for the thumbnail
            $date = now()->format('Ymd');
            $randomSlug = Str::random(6);
            $randomNumber = rand(100000, 999999);
            $newFilename = "{$date}_{$randomSlug}_{$randomNumber}.{$request->file('thumbnail')->getClientOriginalExtension()}";

            // Store the thumbnail file
            $request->file('thumbnail')->storeAs('public/admin/events', $newFilename);
            $event->thumbnail = $newFilename;

            // Assign other values to the event model's properties
            $event->date = $request->date;
            $event->description = $request->description;
            $event->user_id = auth('admin')->id();

            // Save the event model to the database
            $event->save();

            DB::commit();

            // Flash a success message to the session
            session()->flash('success', 'Event has been created.');

            // Redirect to a specific route or action
            return redirect()->route('admin.event.all');
        } catch (Exception $e) {
            DB::rollBack();
            // Handle the error case
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

    public function update($request, $currenSlug)
    {
        DB::beginTransaction();
        if (Event::where('slug', getSlug($request->title))->where('slug', '!=', $currenSlug)->count() > 0) {
            $slug = getSlug($request->title) . '-' . rand(100000, 999999);
        } else {
            $slug = getSlug($request->title);
        }

        try {
            $event = Event::where('slug', $currenSlug)->first();

            if(is_null($event)){
                return $this->error([], __('No Data Found'));
            }


            $event->title = $request->title;
            $event->slug = $slug;
            $event->event_category_id = $request->event_category_id;
            $event->date = $request->date;
            $event->description = $request->description;
            if($request->status != NULL){
                $event->status = $request->status;
            }
            if ($request->hasFile('thumbnail')) {
                // Get the original file extension
                Storage::delete('public/admin/notice/' . $event->thumbnail);

                $extension = $request->thumbnail->getClientOriginalExtension();

                // Generate the new file name
                $date = Carbon::now()->format('Ymd');
                $slug = Str::slug($request->title);
                $randomNumber = rand(1000, 9999);
                $newFileName = "{$date}_{$slug}_{$randomNumber}.{$extension}";
                // Save the file to the specified directory
                $request->thumbnail->storeAs('public/admin/events', $newFileName);


                // Get the file URL or ID depending on your file manager
                $event->thumbnail = $newFileName; // Assuming you want to save the file path
            }

            $event->save();
            DB::commit();
            session()->flash('success', 'Event has been updated.');
            return redirect()->route('admin.event.all');
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function getEvent($slug){
        return Event::where('slug', $slug)->first();
    }

    public function deleteById($id)
    {
        try {
            DB::beginTransaction();
            $event = event::where('id', $id)->first();
            Storage::delete('public/admin/events/' . $event->thumbnail);
            $event->delete();
            DB::commit();
            $message = getMessage(DELETED_SUCCESSFULLY);
            return redirect()->route('admin.event.all');
        } catch (\Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }
}
