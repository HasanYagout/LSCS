<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Services\DashboardService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class HomeController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        $this->dashboardService = new DashboardService();
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $userInfo = null;



        $userInfo=[
            1 => $user->admin,
            2=> $user->alumni,
            3=> $user->company,
        ];
        $data = [
            'pageTitle' => __('Timeline'),
            'activeHome' => 'active',
            'upcomingEvents' => $this->dashboardService->getUpcomingEvent()->getData()->data,
            'latestJobs' => $this->dashboardService->getLatestJobs()->getData()->data,
            'latestNews' => $this->dashboardService->getLatestNews()->getData()->data,
            'latestNotice' => $this->dashboardService->getLatestNotice()->getData()->data,
            'user' => auth('alumni')->user(),
            'userInfo' => $userInfo[$user->role_id],
            'posts' => $this->dashboardService->getPosts(),
        ];
        return view('alumni.home', $data)->with('info','welcome'.$userInfo[$user->role_id]->first_name);
    }


}
