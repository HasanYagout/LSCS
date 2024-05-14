<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $data['pageTitle'] = __('Dashboard');

        return view('company.dashboard');
    }
}
