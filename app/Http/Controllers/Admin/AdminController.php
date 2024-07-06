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

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->adminService->list($request);
        }
        $data['pageTitle'] = __('List Admin');
        $data['activeAdmin'] = 'active';
        return view('admin.list', $data);
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

        return redirect()->route('admin.index')->with('success', 'Admin added successfully!');
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
