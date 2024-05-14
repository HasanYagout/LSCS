<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Membership;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Services\UserService;
use App\Models\UserMembershipPlan;
use App\Http\Controllers\Controller;
use App\Http\Services\MembershipService;
use App\Http\Requests\Admin\MembershipRequest;

class MembershipController extends Controller
{
    use ResponseTrait;
    public $membershipService;

    public function __construct()
    {
        $this->membershipService = new MembershipService();
    }

    public function index(Request $request)
    {
        $data['title'] = __('Membership Plan');
        $data['showMembership'] = 'show';
        $data['activeMembershipCreate'] = 'active';
        if ($request->ajax()) {
            return $this->membershipService->list();
        }
        return view('admin.membership.index', $data);
    }

    public function list(Request $request)
    {
        $data['title'] = __('Member List');
        $data['showMembership'] = 'show';
        $data['activeMemberList'] = 'active';
        if ($request->ajax()) {
            return $this->membershipService->memberList();
        }
        return view('admin.membership.list', $data);
    }

    public function store(MembershipRequest $request)
    {
        return  $this->membershipService->store($request);
    }

    public function edit($slug)
    {
        $data['membership'] = Membership::where('slug', $slug)->first();
        return view('admin.membership.edit', $data);
    }

    public function update($slug, MembershipRequest $request)
    {
        return $this->membershipService->update($slug, $request);
    }

    public function delete($id)
    {
        return $this->membershipService->deleteById($id);
    }

}
