<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PhotoGalleryRequest;
use App\Http\Services\ImageGalleryService;
use App\Models\Batch;
use App\Models\PhotoGallery;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ImageGalleryController extends Controller
{
    use ResponseTrait;

    private $imageGalleryService;

    public function __construct()
    {
        $this->imageGalleryService = new ImageGalleryService();
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->imageGalleryService->getAllData();
        }

        $data['title'] = __('Photo Gallery');
        $data['activeManageWebsiteSetting'] = 'active';
        $data['activeImageGallerySetting'] = 'active-color-one';
        return view('admin.website_settings.image_gallery.index', $data);
    }

    public function edit($id)
    {
        $data['gallery'] = PhotoGallery::findOrFail($id);
        return view('admin.website_settings.image_gallery.edit-form', $data);
    }


    public function store(PhotoGalleryRequest $request)
    {
        return $this->imageGalleryService->store($request);
    }

    public function update(PhotoGalleryRequest $request, $id)
    {
        return $this->imageGalleryService->update($request, $id);
    }

    public function delete($id)
    {
        return $this->imageGalleryService->deleteById($id);
    }
}
