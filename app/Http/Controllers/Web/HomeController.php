<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Services\DashboardService;
use App\Http\Services\Frontend\HomeService;
use App\Models\Batch;
use App\Models\Department;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    use ResponseTrait;
    public $homeService;

    public function __construct()
    {
        $this->homeService = new HomeService();
    }

    public function index(Request $request)
    {
        $data['upcomingEvents'] = $this->homeService->getUpcomingEvent();
        $data['stories'] = $this->homeService->getStories(3);
        $data['photoGalleries'] = $this->homeService->getPhotoGalleries();
        $data['news'] = $this->homeService->getNews(3);
        $data['alumnus'] = $this->homeService->getAlumni(8);
        $data['totalAlumni'] = User::where('users.tenant_id', getTenantId())->where('role',USER_ROLE_ALUMNI)->where('status',STATUS_ACTIVE)->count();
        $data['totalDepartments'] = Department::where('tenant_id', getTenantId())->count();
        $data['totalSessions'] = Batch::where('tenant_id', getTenantId())->count();
        return view('web.index', $data);
    }

    public function page($slug)
    {
        $data['pageTitle'] = __(getOption($slug.'_title'));
        $data['description'] = getOption($slug.'_description');
        return view('web.page', $data);
    }

}
