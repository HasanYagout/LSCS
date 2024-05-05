<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EditUserRequest;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use App\Traits\General;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    use General;

    public function index()
    {
        $data['title'] = 'All Users';
        $data['users'] = User::whereRole(1)->paginate(25);
        $data['navUserParentActiveClass'] = 'mm-active';
        $data['navUserParentShowClass'] = 'mm-show';
        $data['subNavUserActiveClass'] = 'mm-active';
        return view('admin.user.index', $data);
    }

    public function create()
    {
        $data['title'] = 'Add User';
        $data['navUserParentActiveClass'] = 'mm-active';
        $data['navUserParentShowClass'] = 'mm-show';
        $data['subNavUserCreateActiveClass'] = 'mm-active';
        $data['roles'] = Role::all();
        return view('admin.user.create', $data);
    }


    public function store(UserRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $user->password = Hash::make($request->password);
        $user->role = 1;
        $user->assignRole($request->role_name);
        $user->email_verified_at = Carbon::now()->format("Y-m-d H:i:s");
        $user->save();
        return $this->controlRedirection($request, 'user', 'User');

    }

    public function edit($id)
    {
        $data['title'] = 'Edit User';
        $data['navUserParentActiveClass'] = 'mm-active';
        $data['navUserParentShowClass'] = 'mm-show';
        $data['subNavUserActiveClass'] = 'mm-active';
        $data['roles'] = Role::all();
        $data['user'] = User::find($id);
        return view('admin.user.edit', $data);
    }

    public function update(EditUserRequest $request, $id)
    {
        if (User::whereEmail($request->email)->where('id', '!=', $id)->count() > 0)
        {
            $this->showToastrMessage('warning', 'Email already exist');
            return redirect()->back();
        }
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->address = $request->address;
        if ($request->role_name)
        {
            DB::table('model_has_roles')->where('role_id', $user->roles->first()->id)->where('model_id', $id)->delete();
        }
        $user->assignRole($request->role_name);
        $user->save();
        return $this->controlRedirection($request, 'user', 'User');

    }

    public function delete($id)
    {
        User::whereId($id)->delete();

        $this->showToastrMessage('error', 'User has been deleted');
        return redirect()->back();
    }

}
