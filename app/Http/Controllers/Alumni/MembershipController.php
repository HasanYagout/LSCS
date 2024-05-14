<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Http\Services\MembershipService;
use App\Http\Services\UserService;
use App\Models\Membership;
use App\Traits\ResponseTrait;

class MembershipController extends Controller
{
    use ResponseTrait;
    public $membershipService;

    public function __construct()
    {
        $this->membershipService = new MembershipService();
    }

    public function membershipPackage(){
        $data['title'] = __('Membership');
        $data['activeMembershipPack'] = 'active';
        $data['allMembership'] = Membership::where('status', STATUS_ACTIVE)->where('tenant_id', getTenantId())->get();
        $userService = new UserService();
        $data['user'] = $userService->userData();
        return view('alumni.membership.membership-package', $data);
    }
}
