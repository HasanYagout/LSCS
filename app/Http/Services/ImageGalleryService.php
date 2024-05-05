<?php

namespace App\Http\Services;

use App\Models\FileManager;
use App\Models\PhotoGallery;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class ImageGalleryService
{
    use ResponseTrait;

    public function getAllData()
    {
        $imageGalleryes = PhotoGallery::orderBy('id', 'DESC');
        return datatables($imageGalleryes)
            ->addIndexColumn()
            ->addColumn('photo', function ($data) {
                return '<img src="' . getFileUrl($data->photo) . '" alt="icon" class="max-h-35 rounded avatar-xs tbl-user-image">';
            })
            ->addColumn('action', function ($data){
                return '<ul class="align-items-center cg-5 d-flex justify-content-end">
                            <li class="d-flex gap-2">
                                <button onclick="getEditModal(\'' . route('admin.setting.website-settings.image_galleries.edit', $data->id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo">
                                    <img src="' . asset('assets/images/icon/edit.svg') . '" alt="edit" />
                                </button>
                                <button onclick="deleteItem(\'' . route('admin.setting.website-settings.image_galleries.delete', $data->id) . '\', \'photoGalleryDataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="'.__('Delete').'">
                                    <img src="' . asset('assets/images/icon/delete-1.svg') . '" alt="delete">
                                </button>
                            </li>
                        </ul>';
            })
            ->rawColumns(['action', 'photo'])
            ->make(true);
    }


    public function store($request)
    {
        DB::beginTransaction();
        try {
            $imageGallery = new PhotoGallery();
            $imageGallery->caption = $request->caption;
            if ($request->hasFile('photo')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('image-galleries', $request->photo);
                $imageGallery->photo = $uploaded->id;
            }
            $imageGallery->tenant_id = getTenantId();
            $imageGallery->save();

            DB::commit();

            $message = getMessage(CREATED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $imageGallery = PhotoGallery::findOrfail($id);
            $imageGallery->caption = $request->caption;
            $imageGallery->status = $request->status;
            if ($request->hasFile('photo')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('image-galleries', $request->photo);
                $imageGallery->photo = $uploaded->id;
            }
            $imageGallery->save();

            DB::commit();

            $message = getMessage(UPDATED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function getById($id)
    {
        return PhotoGallery::findOrFail($id);
    }

    public function deleteById($id)
    {

        try {
            DB::beginTransaction();
            $imageGallery = PhotoGallery::findOrFail($id);
            $imageGallery->delete();
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
