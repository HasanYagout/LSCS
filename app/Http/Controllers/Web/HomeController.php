<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Services\DashboardService;
use App\Http\Services\Frontend\HomeService;
use App\Models\Alumni;
use App\Models\Batch;
use App\Models\Company;
use App\Models\Department;
use App\Models\Event;
use App\Models\JobPost;
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
        $data['news'] = $this->homeService->getNews(3);
        $data['alumnus'] = $this->homeService->getAlumni(8);
        $data['totalAlumni'] = Alumni::count();
        $data['totalCompanies'] = Company::count();
        $data['totalJobs'] = JobPost::count();
        return view('web.index', $data);
    }

    public function page($slug)
    {
        $data['pageTitle'] = __(getOption($slug.'_title'));
        $data['description'] = getOption($slug.'_description');
        return view('web.page', $data);
    }

}
