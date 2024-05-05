<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PassingYearRequest;
use App\Http\Services\PassingYearService;
use App\Models\PassingYear;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class PassingYearController extends Controller
{
    use ResponseTrait;

    private $passingYearService;

    public function __construct()
    {
        $this->passingYearService = new PassingYearService();
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->passingYearService->getAllData();
        }
        $data['title'] = __('Passing Year Setting');
        $data['showManageApplicationSetting'] = 'show';
        $data['activePassingSetting'] = 'active-color-one';
        return view('admin.setting.passing-years.index', $data);
    }

    public function edit($id)
    {
        $data['passingYear'] = PassingYear::findOrFail($id);
        return view('admin.setting.passing-years.edit-form', $data);
    }


    public function store(PassingYearRequest $request)
    {
        return $this->passingYearService->store($request);
    }

    public function update(PassingYearRequest $request, $id)
    {
        return $this->passingYearService->update($request, $id);
    }

    public function delete($id)
    {
        return $this->passingYearService->deleteById($id);
    }
}
