<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Services\Frontend\HomeService;
use App\Http\Services\UserService;
use App\Traits\ResponseTrait;

class MembershipController extends Controller
{
    use ResponseTrait;
    public $homeService;

    public function __construct()
    {
        $this->homeService = new HomeService();
    }

    public function membership()
    {
        $data['title'] = __('Get Membership');
        $data['all_membership'] = $this->homeService->getMembership();
        $userService = new UserService();
        $data['user'] = $userService->userData();
        return view('web.membership.index', $data);
    }

}
