<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Services\DashboardService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class HomeController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        $this->dashboardService = new DashboardService();
    }

    public function index(Request $request)
    {
        $data['pageTitle'] = __('Timeline');
        $data['activeHome'] = 'active';
        $data['upcomingEvents'] = $this->dashboardService->getUpcomingEvent()->getData()->data;
        $data['latestJobs'] = $this->dashboardService->getLatestJobs()->getData()->data;
        $data['latestNews'] = $this->dashboardService->getLatestNews()->getData()->data;
        $data['latestNotice'] = $this->dashboardService->getLatestNotice()->getData()->data;
        $data['user'] = auth()->user();
        return view('alumni.home', $data);
    }

    public function loadMorePost(Request $request)
    {
        return $this->dashboardService->getMorePost($request);
    }
}
