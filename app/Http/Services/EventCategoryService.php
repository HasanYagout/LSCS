<?php

namespace App\Http\Services;

use App\Models\EventCategory;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class EventCategoryService
{
    use ResponseTrait;

    public function list($request)
    {
        $query = EventCategory::query();
        if ($request->has('search') && $request->search['value'] != '') {
            $search = $request->search['value'];
            $query->where('name', 'like', "%{$search}%");
        }
        $query->orderBy('id','DESC');
        return datatables($query)
            ->addIndexColumn()
            ->addColumn('action', function ($data){
                return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                            <li class="d-flex gap-2">
                                <button onclick="getEditModal(\'' . route('admin.eventCategory.info', $data->id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="'.__('Edit').'">
                                    <img src="' . asset('public/assets/images/icon/edit.svg') . '" alt="edit" />
                                </button>
                                <button onclick="deleteItem(\'' . route('admin.eventCategory.delete', $data->id) . '\', \'eventCategoryDataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="'.__('Delete').'">
                                    <img src="' . asset('public/assets/images/icon/delete-1.svg') . '" alt="delete">
                                </button>
                            </li>
                        </ul>';
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }


    public function store($request)
    {
        try {
            DB::beginTransaction();
            $eventCategory = new EventCategory();
            $eventCategory->name = $request->name;;
            $eventCategory->save();
            DB::commit();
            session()->flash('success', 'Event Category has been created.');
            return redirect()->route('admin.eventCategory.index');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

    public function update($id, $request)
    {
        DB::beginTransaction();
        try {
            $newsCategory = EventCategory::findOrFail($id);
            $newsCategory->name = $request->name;
            $newsCategory->save();
            DB::commit();
            session()->flash('success', 'Event Category has been updated.');
            return redirect()->route('admin.eventCategory.index');
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function getById($id)
    {
        return EventCategory::findOrFail($id);
    }

    public function deleteById($id)
    {
        try {
            DB::beginTransaction();
            $category = EventCategory::where('id', $id)->firstOrFail();
            $category->delete();
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
