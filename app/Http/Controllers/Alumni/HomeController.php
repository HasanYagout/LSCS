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


        $data = [
            'pageTitle' => __('Timeline'),
            'activeHome' => 'active',
            'upcomingEvents' => $this->dashboardService->getUpcomingEvent()->getData()->data,
            'latestJobs' => $this->dashboardService->getLatestJobs()->getData()->data,
            'latestNews' => $this->dashboardService->getLatestNews()->getData()->data,
            'latestNotice' => $this->dashboardService->getLatestNotice()->getData()->data,
            'userInfo' => $user->alumni,
            'posts' => $this->dashboardService->getPosts(),
        ];
        return view('alumni.home', $data)->with('info','welcome'.$user->alumni->first_name);
    }


}
