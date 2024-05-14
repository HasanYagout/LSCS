<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DepartmentRequest;
use App\Http\Services\DepartmentService;
use App\Models\Department;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    use ResponseTrait;

    private $departmentService;

    public function __construct()
    {
        $this->departmentService = new DepartmentService();
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->departmentService->getAllData();
        }

        $data['title'] = __('Department Setting');
        $data['showManageApplicationSetting'] = 'show';
        $data['activeDepartmentsSetting'] = 'active-color-one';
        return view('admin.setting.departments.index', $data);
    }

    public function edit($id)
    {
        $data['department'] = Department::findOrFail($id);
        return view('admin.setting.departments.edit-form', $data);
    }


    public function store(DepartmentRequest $request)
    {
        return $this->departmentService->store($request);
    }

    public function update(DepartmentRequest $request, $id)
    {
        return $this->departmentService->update($request, $id);
    }

    public function delete($id)
    {
        return $this->departmentService->deleteById($id);
    }
}
