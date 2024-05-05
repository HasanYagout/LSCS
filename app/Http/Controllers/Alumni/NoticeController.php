<?php

namespace App\Http\Controllers\Alumni;
use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function allNotice(){
        $data['title']= 'All Notices';
        $data['Allnotice']= Notice::all();
        return view('alumni.notice.all-notice', $data);
    }

    public function noticeDetails($slug){
        $data['title']= 'Notice Details';
        $data['notice']= Notice::where('slug', $slug)->first();
        return view('alumni.notice.notice-details', $data);
    }
}
