<?php

namespace App\Http\Services;

use App\Models\Notice;
use App\Models\FileManager;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NoticeService
{
    use ResponseTrait;

    public function list( $request)
    {

        $query = Notice::query()->select('notices.*', 'notice_categories.name as category_name')
            ->join('notice_categories', 'notices.notice_category_id', '=', 'notice_categories.id');

        // Handle ordering
        if ($request->has('order') && $request->has('columns')) {
            foreach ($request->order as $order) {
                $orderBy = $request->columns[$order['column']]['data'];
                $orderDirection = $order['dir'];
                if ($orderBy == 'category') {
                    $query->orderBy('notice_categories.name', $orderDirection);
                } else {
                    $query->orderBy($orderBy, $orderDirection);
                }
            }
        } else {
            $query->orderBy('notices.id', 'desc');
        }

        if ($request->has('search') && $request->search['value'] != '') {
            $search = $request->search['value'];
            $query->where(function($q) use ($search) {
                $q->where('notices.title', 'like', "%{$search}%")
                    ->orWhere('notice_categories.name', 'like', "%{$search}%");
            });
        }

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('image', function ($data) {
                return '<img onerror="this.onerror=null; this.src=\'' . asset('public/assets/images/no-image.jpg') . '\';" src="' . asset('public/storage/admin/notice'.'/'.$data->image) . '" alt="icon" class="rounded avatar-xs max-h-35">';
            })
            ->addColumn('title', function ($data) {
                return $data->title;
            })
            ->addColumn('category', function ($data) {
                return htmlspecialchars($data->category_name);
            })
            ->addColumn('status', function ($data) {
                if ($data->status == STATUS_ACTIVE) {
                    return '<span class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-0fa958 bg-0fa958-10">'.__('Published').'</span>';
                } else {
                    return '<span class="zBadge-free">'.__('Deactivate').'</span>';
                }
            })
            ->addColumn('action', function ($data) {
                return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                    <li class="d-flex gap-2">
                        <button onclick="getEditModal(\'' . route('admin.notices.info', $data->id) . '\', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="'.__('Edit').'">
                            <img src="' . asset('public/assets/images/icon/edit.svg') . '" alt="edit" />
                        </button>
                        <button onclick="deleteItem(\'' . route('admin.notices.delete', $data->id) . '\', \'noticeDataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="'.__('Delete').'">
                            <img src="' . asset('public/assets/images/icon/delete-1.svg') . '" alt="delete">
                        </button>
                    </li>
                </ul>';
            })
            ->rawColumns(['status', 'image', 'action'])
            ->make(true);
    }







    public function store($request)
    {
        try {
            $user = Auth::user();
            DB::beginTransaction();
            if (Notice::where('slug', getSlug($request->title))->count() > 0) {
                $slug = getSlug($request->title) . '-' . rand(100000, 999999);
            } else {
                $slug = getSlug($request->title);
            }
            $notice = new Notice();
            $notice->title = $request->title;
            $notice->slug = $slug;
            $notice->notice_category_id = $request->category_id;
            $notice->details = $request->details;
            $notice->status = $request->status;
            $notice->posted_by = $user->id;
            if ($request->hasFile('image')) {
                // Get the original file extension
                $extension = $request->image->getClientOriginalExtension();

                // Generate the new file name
                $date = Carbon::now()->format('Ymd');
                $slug = Str::slug($request->title);
                $randomNumber = rand(1000, 9999);
                $newFileName = "{$date}_{$slug}_{$randomNumber}.{$extension}";
                // Save the file to the specified directory
                $request->image->storeAs('public/admin/notice', $newFileName);


                // Get the file URL or ID depending on your file manager
                $notice->image = $newFileName; // Assuming you want to save the file path
            }


            $notice->save();

            DB::commit();
            session()->flash('success', 'Notice Created Successfully');
            return redirect()->route('admin.notices.index');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage());
        }
    }

    public function update($id, $request)
    {
        try {
            DB::beginTransaction();
            if (Notice::where('slug', getSlug($request->title))->where('id', '!=', $id)->count() > 0) {
                $slug = getSlug($request->title) . '-' . rand(100000, 999999);
            } else {
                $slug = getSlug($request->title);
            }
            $notice = Notice::where('id', $id)->firstOrFail();
            $notice->title = $request->title;
            $notice->slug = $slug;
            $notice->notice_category_id = $request->category_id;
            $notice->details = $request->details;
            $notice->status = $request->status;
            if ($request->hasFile('image')) {
                // Get the original file extension
                $extension = $request->image->getClientOriginalExtension();
                Storage::delete('public/admin/notice/' . $notice->image);

                // Generate the new file name
                $date = Carbon::now()->format('Ymd');
                $slug = Str::slug($request->title);
                $randomNumber = rand(1000, 9999);
                $newFileName = "{$date}_{$slug}_{$randomNumber}.{$extension}";
                // Save the file to the specified directory
                $request->image->storeAs('public/admin/notice', $newFileName);


                // Get the file URL or ID depending on your file manager
                $notice->image = $newFileName; // Assuming you want to save the file path
            }


            $notice->save();

            DB::commit();
            session()->flash('success', 'Notice Updated Successfully');
            return redirect()->route('admin.notices.index');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

    public function getById($id)
    {
        return Notice::with(['category'])->where('id', $id)->firstOrFail();
    }

    public function getNoticeBySlug($slug)
    {
        return Notice::where('slug', $slug)->with(['category'])->firstOrFail();
    }

    public function getFirst()
    {
        return Notice::where('status', STATUS_ACTIVE)->with(['category'])->first();
    }

    public function deleteById($id)
    {
        try {
            DB::beginTransaction();

            $notice = Notice::where('id', $id)->firstOrFail();
            Storage::delete('public/admin/notice/' . $notice->image);

            $notice->delete();

            DB::commit();

            // Flash a success message to the session
            session()->flash('success', 'Notice Deleted Successfully');

            // Redirect to a specific route or action
            return redirect()->route('admin.notices.index');
        } catch (\Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function getAllActive($limit = NULL)
    {
        $first = $this->getFirst()?->id;
        if(is_null($limit)){
            return Notice::where('status', STATUS_ACTIVE)->where('id', '!=', $first)->with(['category'])->paginate(6);
        }else{
            return Notice::where('status', STATUS_ACTIVE)->limit($limit)->with(['category'])->get();
        }
    }
}
