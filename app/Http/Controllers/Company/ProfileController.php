<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {

        $data['pageTitle'] = 'Profile';
        $data['navAccountSettingActiveClass'] = 'mm-active';
        $data['subNavProfileActiveClass'] = 'mm-active';
        return view('company.profile.index', $data);
    }
}
