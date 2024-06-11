<?php


namespace App\Http\Services\Frontend;

use App\Models\Alumni;
use App\Models\Event;
use App\Models\JobPost;
use App\Models\Membership;
use App\Models\News;
use App\Models\Notice;
use App\Models\PhotoGallery;
use App\Models\Story;
use App\Models\User;
use App\Traits\ResponseTrait;

class HomeService
{
    use ResponseTrait;

    public function getUpcomingEvent(){
        $upcomingEvents = Event::where('date', '>', now())->orderBy('date', 'ASC')->where('status', STATUS_ACTIVE)->with('category')->get();
        return $upcomingEvents;
    }
//    public function getPhotoGalleries(){
//        $photoGallery = PhotoGallery::where('photo_galleries.tenant_id', getTenantId())->where('status', STATUS_ACTIVE)->get();
//        return $photoGallery;
//    }

    public function getAlumni($limit){
        return Alumni::orderBy('id', 'DESC')
        ->limit($limit)->get();
    }

    public function getEvent($limit){
        return Event::where('status', STATUS_ACTIVE)->orderBy('created_at', 'desc')->paginate($limit);
    }

    public function getNews($limit){
        return News::where('status', STATUS_ACTIVE)->with(['category', 'author'])->orderBy('id','DESC')->paginate($limit);
    }

    public function getNotice($limit){
        return Notice::where('notices.tenant_id', getTenantId())->where('status', STATUS_ACTIVE)->with(['category'])->orderBy('id','DESC')->paginate($limit);
    }

    public function getMembership(){
        return Membership::where('membership_plans.tenant_id', getTenantId())->where('status', STATUS_ACTIVE)->orderBy('id','DESC')->get();
    }

    public function getJob($limit){
        return JobPost::where('jobs.tenant_id', getTenantId())->where('status',JOB_STATUS_APPROVED)->orderBy('id','desc')->paginate($limit);
    }

    public function getStories($limit){
        return Story::where('status',STATUS_ACTIVE)->orderBy('id','desc')->with('user')->paginate($limit);
    }


}
