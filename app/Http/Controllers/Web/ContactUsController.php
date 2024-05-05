<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactUsRequest;
use App\Http\Services\ContactUsService;
use App\Traits\ResponseTrait;

class ContactUsController extends Controller
{
    use ResponseTrait;
    protected $contactUsService;

    public function __construct()
    {
        $this->contactUsService = new ContactUsService();
    }

    public function contactUs()
    {
        $data['pageTitle'] = __('Contact Us');
        return view('web.contact-us', $data);
    }

    public function store(ContactUsRequest $request)
    {
        return  $this->contactUsService->store($request);
    }

}
