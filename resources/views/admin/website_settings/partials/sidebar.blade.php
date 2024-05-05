<div class="email__sidebar bg-style">
    <div class="sidebar__item">
        <ul class="d-flex flex-column rg-15 sidebar__mail__nav">
            <li>
                <a href="{{ route('admin.setting.website-settings.index') }}"
                   class="align-items-center flex list-item list-item">
                    <span class="fa fa-gear fs-14 text-707070"></span>
                    <span class="font-bold fs-14 hover-color-one text-1b1c17 {{ @$subWebsiteSettingActiveClass }}">{{__('Common Setting')}}</span>
                </a>
            </li>
            <li>
                <a class="align-items-center flex list-item list-item"
                   href="{{ route('admin.setting.website-settings.banner.setting') }}">
                    <span class="fa fa-gear fs-14 text-707070"></span>
                    <span class="font-bold fs-14 hover-color-one text-1b1c17 {{ @$bannerSettingActiveClass }}">{{ __('Banner Setting') }}</span>
                </a>
            </li>
            <li>
                <a class="align-items-center flex list-item list-item"
                   href="{{ route('admin.setting.website-settings.why-you-should-join-us') }}">
                    <span class="fa fa-gear fs-14 text-707070"></span>
                    <span class="font-bold fs-14 hover-color-one text-1b1c17 {{ @$whyJoinWithUsActiveClass }}">{{ __('Why Join With Us') }}</span>
                </a>
            </li>
            <li>
                <a class="align-items-center flex list-item list-item"
                   href="{{ route('admin.setting.website-settings.about-us') }}">
                    <span class="fa fa-gear fs-14 text-707070"></span>
                    <span class="font-bold fs-14 hover-color-one text-1b1c17 {{ @$aboutUsActiveClass }}">{{ __('About Us') }}</span>
                </a>
            </li>
            <li>
                <a class="align-items-center flex list-item list-item"
                   href="{{ route('admin.setting.website-settings.image_galleries.index') }}">
                    <span class="fa fa-gear fs-14 text-707070"></span>
                    <span class="font-bold fs-14 hover-color-one text-1b1c17 {{ @$activeImageGallerySetting }}">{{ __('Image Gallery') }}</span>
                </a>
            </li>
            <li>
                <a class="align-items-center flex list-item list-item"
                   href="{{ route('admin.setting.website-settings.privacy-policy') }}">
                    <span class="fa fa-gear fs-14 text-707070"></span>
                    <span class="font-bold fs-14 hover-color-one text-1b1c17 {{ @$privacyPolicyActiveClass }}">{{ __('Privacy Policy') }}</span>
                </a>
            </li>
            <li>
                <a class="align-items-center flex list-item list-item"
                   href="{{ route('admin.setting.website-settings.cookie-policy') }}">
                    <span class="fa fa-gear fs-14 text-707070"></span>
                    <span class="font-bold fs-14 hover-color-one text-1b1c17 {{ @$cookiePolicyActiveClass }}">{{ __('Cookie Policy') }}</span>
                </a>
            </li>
            <li>
                <a class="align-items-center flex list-item list-item"
                   href="{{ route('admin.setting.website-settings.terms-condition') }}">
                    <span class="fa fa-gear fs-14 text-707070"></span>
                    <span class="font-bold fs-14 hover-color-one text-1b1c17 {{ @$termsConditionActiveClass }}">{{ __('Terms And Condition') }}</span>
                </a>
            </li>
            <li>
                <a class="align-items-center flex list-item list-item"
                   href="{{ route('admin.setting.website-settings.refund-policy') }}">
                    <span class="fa fa-gear fs-14 text-707070"></span>
                    <span class="font-bold fs-14 hover-color-one text-1b1c17 {{ @$refundPolicyActiveClass }}">{{ __('Refund Policy') }}</span>
                </a>
            </li>
            <li>
                <a class="align-items-center flex list-item list-item"
                   href="{{ route('admin.setting.website-settings.contact-us') }}">
                    <span class="fa fa-gear fs-14 text-707070"></span>
                    <span class="font-bold fs-14 hover-color-one text-1b1c17 {{ @$contactUsActiveClass }}">{{ __('Contact Us') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>
