<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Services\Frontend\HomeService;
use App\Http\Services\NoticeService;
use App\Traits\ResponseTrait;

class NoticeController extends Controller
{
    use ResponseTrait;
    public $homeService;
    public $noticeService;

    public function __construct()
    {
        $this->homeService = new HomeService();
        $this->noticeService = new NoticeService();
    }

    public function notice()
    {
        $data['title'] = __('Notice Board');
        $data['allNotice'] = $this->homeService->getNotice(6);
        return view('web.notice.all_notice', $data);
    }

    public function noticeDetails($slug)
    {
        $data['title'] = __('Notice Board');
        $data['notice'] = $this->noticeService->getNoticeBySlug($slug);;
        return view('frontend.notice.notice_details', $data);
    }

}
