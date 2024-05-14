<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;



class WebsiteSettingController extends Controller
{
    use ResponseTrait;

    public function commonSetting()
    {
        $data['title'] = __("Common Setting");
        $data['activeManageWebsiteSetting'] = 'active';
        $data['subWebsiteSettingActiveClass'] = 'active-color-one';
        return view('admin.website_settings.common')->with($data);
    }

    public function bannerSetting()
    {
        $data['title'] = __("Banner Setting");
        $data['activeManageWebsiteSetting'] = 'active';
        $data['bannerSettingActiveClass'] = 'active-color-one';
        return view('admin.website_settings.banner-settings')->with($data);
    }

    public function whyYouShouldJoinUs()
    {
        $data['title'] = __("Why Join With Us");
        $data['activeManageWebsiteSetting'] = 'active';
        $data['whyJoinWithUsActiveClass'] = 'active-color-one';
        return view('admin.website_settings.why-you-should-join-us')->with($data);
    }

    public function aboutUs()
    {
        $data['title'] = __("About Us");
        $data['activeManageWebsiteSetting'] = 'active';
        $data['aboutUsActiveClass'] = 'active-color-one';
        return view('admin.website_settings.about-us')->with($data);
    }

    public function privacyPolicy()
    {
        $data['title'] = __("Privacy Policy");
        $data['activeManageWebsiteSetting'] = 'active';
        $data['privacyPolicyActiveClass'] = 'active-color-one';
        return view('admin.website_settings.privacy-policy')->with($data);
    }

    public function cookiePolicy()
    {
        $data['title'] = __("Cookie Policy");
        $data['activeManageWebsiteSetting'] = 'active';
        $data['cookiePolicyActiveClass'] = 'active-color-one';
        return view('admin.website_settings.cookie-policy')->with($data);
    }

    public function termsCondition()
    {
        $data['title'] = __("Terms And Condition");
        $data['activeManageWebsiteSetting'] = 'active';
        $data['termsConditionActiveClass'] = 'active-color-one';
        return view('admin.website_settings.terms-condition')->with($data);
    }

    public function refundPolicy()
    {
        $data['title'] = __("Refund Policy");
        $data['activeManageWebsiteSetting'] = 'active';
        $data['refundPolicyActiveClass'] = 'active-color-one';
        return view('admin.website_settings.refund-policy')->with($data);
    }

    public function contactUs(Request $request )
    {
        if ($request->ajax()) {
            $contactUs = ContactUs::where('tenant_id', getTenantId())->orderBy('id', 'DESC');
            return datatables($contactUs)
                ->make(true);
        }

        $data['title'] = __("Contact Us");
        $data['activeManageWebsiteSetting'] = 'active';
        $data['contactUsActiveClass'] = 'active-color-one';
        return view('admin.website_settings.contact-us')->with($data);
    }
}
