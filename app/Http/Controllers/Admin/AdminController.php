<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\AdminService;
use App\Http\Services\AlumniService;
use App\Http\Services\UserService;
use App\Models\Admin;
use App\Models\Alumni;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\PassingYear;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    use ResponseTrait;

    public $adminService;


    public function __construct()
    {
        $this->adminService = new AdminService();

    }
    public function delete($id)
    {

        return $this->adminService->deleteById($id);
    }

    public function edit($id)
    {
        $data['admin'] = $this->adminService->getById($id);
        return view('admin.edit-form', $data);
    }
    public function status(Request $request,$id)
    {

        try {
            $admin = Admin::findOrFail($id); // Find admin by ID

            $admin->status = $request->status; // Update status
            $admin->save(); // Save changes

            $roleName = ''; // Assuming you have a method to fetch role name
            if ($admin->role_id == USER_ROLE_ADMIN) {
                $roleName = 'Admin';
            } else {
                $roleName = 'Instructor';
            }

            return response()->json(['message' => $roleName . ' status changed successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update status.'], 500);
        }

    }

    public function add()
    {
        $data['pageTitle'] = __('Add Instructor');
        $data['activeInstructor'] = 'active';
        return view('admin.add', $data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'mobile' => 'required|string|unique:admins|max:20',
        ]);

        // Store the admin
        $admin = new Admin();
        $admin->first_name = $request->input('first_name');
        $admin->last_name = $request->input('last_name');
        $admin->email = $request->input('email');
        $admin->mobile = $request->input('mobile');
        $admin->password = bcrypt('12345678'); // Default password hashed
        $admin->image = ''; // Default password hashed
        $admin->role_id=$request->input('type');
        $admin->status=1;
        $admin->save();

        return redirect()->route('admin.add')->with('success', 'Admin added successfully!');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $allInstructors = Admin::where('status', 1)
                ->orWhere('status',0)
                ->orderBy('id', 'desc');
            return datatables($allInstructors)
                ->addIndexColumn()
                ->addColumn('image', function ($data) {
                    return '<img onerror="this.onerror=null; this.src=\'' . asset('public/assets/images/no-image.jpg') . '\';" src="' . asset('public/storage/admin/' . auth('admin')->user()->image) . '" alt="Company Logo" class="rounded avatar-xs max-h-35">';

                })
                ->addColumn('first_name', function ($data) {
                    return $data->first_name;
                })
                ->addColumn('last_name', function ($data) {
                    return $data->last_name;
                })
                ->addColumn('email', function ($data) {
                    return $data->email;
                })
                ->addColumn('type', function ($data) {

                    return '<p class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16' . ($data->role_id == '1' ? ' text-0fa958 bg-0fa958-10' : ' text-f5b40a bg-f5b40a-10') . '">' . $data->role->name . '</p>';
                })
                ->addColumn('reset_password', function ($data) {
                    return '<button onclick="resetPassword(\''. route('admin.reset-password', ['id' => $data->id]) . '\', ' . $data->id . ')" class="bg-f1a527 btn btn-sm text-white">Reset Password</button>';
                })
                ->addColumn('status', function ($data) {
                    $checked = $data->status ? 'checked' : '';
                    return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                <li class="d-flex gap-2">
                    <div class="form-check form-switch">
                        <input class="form-check-input toggle-status" type="checkbox" data-id="' . $data->id . '" id="toggleStatus' . $data->id . '" ' . $checked . '>
                        <label class="form-check-label" for="toggleStatus' . $data->id . '"></label>
                    </div>
                </li>
            </ul>';
                })
                ->addColumn('action', function ($data){
                    return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                            <li class="d-flex gap-2">
                                <button onclick="getEditModal(\'' . route('admin.edit', $data->id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="'.__('Edit').'">
                                    <img src="' . asset('public/assets/images/icon/edit.svg') . '" alt="edit" />
                                </button>

                                <button onclick="deleteItem(\'' . route('admin.delete', $data->id) . '\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="'.__('Delete').'">
                                    <img src="' . asset('public/assets/images/icon/delete-1.svg') . '" alt="delete">
                                </button>
                            </li>
                        </ul>';
                })
                ->rawColumns(['action','reset_password','status', 'type', 'image'])
                ->make(true);
        }
    }
    public function resetPassword(Request $request, $id)
    {

        try {
            $admin = Admin::findOrFail($id); // Find admin by ID

            // Generate a new password
            $newPassword = '12345678'; // Generate your new password securely

            // Update admin's password
            $admin->password = bcrypt($newPassword);
            $admin->save();
            Auth::guard('admin')->logout();
            // Return success response
            return response()->json(['message' => 'Password reset successfully.']);

        } catch (\Exception $e) {
            // Return error response if reset fails
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
