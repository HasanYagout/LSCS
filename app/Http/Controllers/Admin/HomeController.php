<?php

namespace App\Http\Controllers\Admin;

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

        switch ($user->role_id) {
            case 1:
                $userInfo = $user->admin;
                break;
            case 2:
                $userInfo = $user->company;
                break;
            case 3:
                $userInfo = $user->alumni;
                break;
            default:
                abort(403, 'Unauthorized action.');
        }

        $data = [
            'pageTitle' => __('Timeline'),
            'activeHome' => 'active',
            'upcomingEvents' => $this->dashboardService->getUpcomingEvent()->getData()->data,
            'latestJobs' => $this->dashboardService->getLatestJobs()->getData()->data,
            'latestNews' => $this->dashboardService->getLatestNews()->getData()->data,
            'latestNotice' => $this->dashboardService->getLatestNotice()->getData()->data,
            'userInfo' => $userInfo,
            'posts' => $this->dashboardService->getPosts(),
        ];

        return view('admin.home', $data);
    }

    public function loadMorePost(Request $request)
    {
        return $this->dashboardService->getMorePost($request);
    }
}
