<!-- Sidebar -->
<div class="zSidebar" data-background="{{ asset('super_admin/images/sidebar-bg.png') }}">
    <div class="zSidebar-overlay"></div>
    <a href="{{ route('super_admin.dashboard') }}" class="d-block mx-26 mb-27 max-w-146 pt-23">
        <img class="max-h-35" src="{{ getSettingImage('app_logo') }}" alt="{{ getOption('app_name') }}"/>
    </a>
    <!-- Menu & Logout -->
    <div class="zSidebar-fixed">
        <ul class="zSidebar-menu" id="sidebarMenu">
            <li>
                <a href="{{ route('super_admin.dashboard') }}"
                   class="{{ $activeDashboard ?? '' }} d-flex align-items-center cg-10">
                    <div class="d-flex">
                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.88979 10.3929C6.14657 10.3929 5.62851 10.3924 5.22349 10.3635C4.82565 10.3351 4.59466 10.2819 4.4186 10.2051C3.89833 9.97813 3.48308 9.56288 3.25609 9.04261C3.17928 8.86655 3.12616 8.63556 3.09774 8.23773C3.0688 7.83271 3.06836 7.31465 3.06836 6.57143C3.06836 5.82821 3.0688 5.31015 3.09774 4.90513C3.12616 4.50729 3.17928 4.2763 3.25609 4.10024C3.48308 3.57997 3.89833 3.16473 4.4186 2.93773C4.59466 2.86092 4.82565 2.80781 5.22349 2.77938C5.6285 2.75045 6.14657 2.75 6.88979 2.75C7.63301 2.75 8.15107 2.75045 8.55609 2.77938C8.95392 2.80781 9.18491 2.86092 9.36097 2.93773C9.88124 3.16473 10.2965 3.57997 10.5235 4.10024C10.6003 4.2763 10.6534 4.50729 10.6818 4.90513C10.7108 5.31015 10.7112 5.82821 10.7112 6.57143C10.7112 7.31465 10.7108 7.83271 10.6818 8.23773C10.6534 8.63556 10.6003 8.86655 10.5235 9.04261C10.2965 9.56288 9.88124 9.97813 9.36097 10.2051C9.18491 10.2819 8.95392 10.3351 8.55609 10.3635C8.15107 10.3924 7.63301 10.3929 6.88979 10.3929Z"
                                stroke="white" stroke-opacity="0.7" stroke-width="1.5"/>
                            <path
                                d="M6.88979 21.25C6.14657 21.25 5.62851 21.2496 5.22349 21.2207C4.82565 21.1922 4.59466 21.1391 4.4186 21.0623C3.89833 20.8353 3.48308 20.4201 3.25609 19.8998C3.17928 19.7237 3.12616 19.4927 3.09774 19.0949C3.0688 18.6899 3.06836 18.1718 3.06836 17.4286C3.06836 16.6854 3.0688 16.1673 3.09774 15.7623C3.12616 15.3645 3.17928 15.1335 3.25609 14.9574C3.48308 14.4372 3.89833 14.0219 4.4186 13.7949C4.59466 13.7181 4.82565 13.665 5.22349 13.6366C5.6285 13.6076 6.14657 13.6072 6.88979 13.6072C7.63301 13.6072 8.15107 13.6076 8.55609 13.6366C8.95392 13.665 9.18491 13.7181 9.36097 13.7949C9.88124 14.0219 10.2965 14.4372 10.5235 14.9574C10.6003 15.1335 10.6534 15.3645 10.6818 15.7623C10.7108 16.1673 10.7112 16.6854 10.7112 17.4286C10.7112 18.1718 10.7108 18.6899 10.6818 19.0949C10.6534 19.4927 10.6003 19.7237 10.5235 19.8998C10.2965 20.4201 9.88124 20.8353 9.36097 21.0623C9.18491 21.1391 8.95392 21.1922 8.55609 21.2207C8.15107 21.2496 7.63301 21.25 6.88979 21.25Z"
                                stroke="white" stroke-opacity="0.7" stroke-width="1.5"/>
                            <path
                                d="M17.7472 10.3929C17.004 10.3929 16.4859 10.3924 16.0809 10.3635C15.6831 10.3351 15.4521 10.2819 15.276 10.2051C14.7558 9.97813 14.3405 9.56288 14.1135 9.04261C14.0367 8.86655 13.9836 8.63556 13.9552 8.23773C13.9262 7.83271 13.9258 7.31465 13.9258 6.57143C13.9258 5.82821 13.9262 5.31015 13.9552 4.90513C13.9836 4.50729 14.0367 4.2763 14.1135 4.10024C14.3405 3.57997 14.7558 3.16473 15.276 2.93773C15.4521 2.86092 15.6831 2.80781 16.0809 2.77938C16.4859 2.75045 17.004 2.75 17.7472 2.75C18.4904 2.75 19.0085 2.75045 19.4135 2.77938C19.8113 2.80781 20.0423 2.86092 20.2184 2.93773C20.7387 3.16473 21.1539 3.57997 21.3809 4.10024C21.4577 4.2763 21.5108 4.50729 21.5393 4.90513C21.5682 5.31015 21.5686 5.82821 21.5686 6.57143C21.5686 7.31465 21.5682 7.83271 21.5393 8.23773C21.5108 8.63556 21.4577 8.86655 21.3809 9.04261C21.1539 9.56288 20.7387 9.97813 20.2184 10.2051C20.0423 10.2819 19.8113 10.3351 19.4135 10.3635C19.0085 10.3924 18.4904 10.3929 17.7472 10.3929Z"
                                stroke="white" stroke-opacity="0.7" stroke-width="1.5"/>
                            <path
                                d="M17.7472 21.25C17.004 21.25 16.4859 21.2496 16.0809 21.2207C15.6831 21.1922 15.4521 21.1391 15.276 21.0623C14.7558 20.8353 14.3405 20.4201 14.1135 19.8998C14.0367 19.7237 13.9836 19.4927 13.9552 19.0949C13.9262 18.6899 13.9258 18.1718 13.9258 17.4286C13.9258 16.6854 13.9262 16.1673 13.9552 15.7623C13.9836 15.3645 14.0367 15.1335 14.1135 14.9574C14.3405 14.4372 14.7558 14.0219 15.276 13.7949C15.4521 13.7181 15.6831 13.665 16.0809 13.6366C16.4859 13.6076 17.004 13.6072 17.7472 13.6072C18.4904 13.6072 19.0085 13.6076 19.4135 13.6366C19.8113 13.665 20.0423 13.7181 20.2184 13.7949C20.7387 14.0219 21.1539 14.4372 21.3809 14.9574C21.4577 15.1335 21.5108 15.3645 21.5393 15.7623C21.5682 16.1673 21.5686 16.6854 21.5686 17.4286C21.5686 18.1718 21.5682 18.6899 21.5393 19.0949C21.5108 19.4927 21.4577 19.7237 21.3809 19.8998C21.1539 20.4201 20.7387 20.8353 20.2184 21.0623C20.0423 21.1391 19.8113 21.1922 19.4135 21.2207C19.0085 21.2496 18.4904 21.25 17.7472 21.25Z"
                                stroke="white" stroke-opacity="0.7" stroke-width="1.5"/>
                        </svg>
                    </div>
                    <span class="">{{ __('Dashboard') }}</span>
                </a>
            </li>
            @if(isAddonInstalled('ALUSAAS'))
                <li>
                    <a href="{{route('saas.super_admin.subscriptions.orders')}}" class="d-flex align-items-center cg-10 {{$activeSubscriptionIndex ?? ''}}">
                        <div class="d-flex  {{ isset($activeSubscriptionIndex) ? 'active' : 'collapsed' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                                <rect x="3.31836" y="6.00012" width="18" height="12" rx="2" stroke="white" stroke-opacity="0.7" stroke-width="1.5"/>
                                <path d="M5.31836 9.00012H8.31836" stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M16.3184 15.0001H19.3184" stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"/>
                                <circle cx="12.3184" cy="12.0001" r="2" stroke="white" stroke-opacity="0.7" stroke-width="1.5"/>
                            </svg>
                        </div>
                        <span class="">{{__('All Order')}}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('saas.super_admin.customer_list') }}"
                    class="d-flex align-items-center cg-10 {{ $showCustomerList ?? '' }}">
                        <div class="d-flex {{ isset($showCustomerList) ? 'active' : 'collapsed' }}">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="6" r="4" stroke="white" stroke-opacity="0.7"
                                        stroke-width="1.5"/>
                                <path d="M18 9C19.6569 9 21 7.88071 21 6.5C21 5.11929 19.6569 4 18 4" stroke="white"
                                    stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M6 9C4.34315 9 3 7.88071 3 6.5C3 5.11929 4.34315 4 6 4" stroke="white"
                                    stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"/>
                                <ellipse cx="12" cy="17" rx="6" ry="4" stroke="white"
                                        stroke-opacity="0.7" stroke-width="1.5"/>
                                <path d="M20 19C21.7542 18.6153 23 17.6411 23 16.5C23 15.3589 21.7542 14.3847 20 14"
                                    stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M4 19C2.24575 18.6153 1 17.6411 1 16.5C1 15.3589 2.24575 14.3847 4 14"
                                    stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <span class="">{{ __('Customers') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('saas.super_admin.packages.user')}}" class="d-flex align-items-center cg-10 {{$activePackageUser ?? ''}}">
                        <div class="d-flex  {{ isset($activePackageUser) ? 'active' : 'collapsed' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 23 23" fill="none">
                                <path d="M12.3398 0.61335L20.2461 5.17693C20.7646 5.47689 21.0846 6.02985 21.0846 6.62881V15.7569C21.0847 16.0514 21.0073 16.3407 20.8601 16.5957C20.7129 16.8508 20.5011 17.0625 20.2461 17.2098L12.3398 21.7733C12.085 21.9207 11.7957 21.9983 11.5013 21.9983C11.2069 21.9983 10.9176 21.9207 10.6628 21.7733L2.75651 17.2088C2.50164 17.0617 2.28998 16.85 2.14279 16.5952C1.9956 16.3403 1.91806 16.0512 1.91797 15.7569V6.62881C1.91797 6.02985 2.23805 5.47689 2.75651 5.17693L10.6628 0.61335C10.9176 0.465967 11.2069 0.388367 11.5013 0.388367C11.7957 0.388367 12.085 0.465967 12.3398 0.61335ZM11.3815 1.85727L4.07422 6.07585L11.5013 10.3634L18.9284 6.07585L11.6211 1.85727C11.5847 1.83605 11.5434 1.82487 11.5013 1.82487C11.4592 1.82487 11.4179 1.83605 11.3815 1.85727ZM12.2201 20.1835L19.5273 15.9649C19.5637 15.9439 19.5939 15.9137 19.6149 15.8774C19.6359 15.8411 19.6471 15.7999 19.6471 15.7579V7.32072L12.2201 11.6083V20.1835ZM3.35547 7.32168V15.7579C3.35547 15.8441 3.40147 15.9227 3.47526 15.9649L10.7826 20.1835V11.6093L3.35547 7.32168Z" fill="white" fill-opacity="0.7"/>
                            </svg>
                        </div>
                        <span class="">{{__('User Packages')}}</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('saas.super_admin.packages.index')}}" class="d-flex align-items-center cg-10 {{$activeSubscription ?? ''}}">
                        <div class="d-flex  {{ isset($activeSubscription) ? 'active' : 'collapsed' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 23 23" fill="none">
                                <path d="M12.3398 0.61335L20.2461 5.17693C20.7646 5.47689 21.0846 6.02985 21.0846 6.62881V15.7569C21.0847 16.0514 21.0073 16.3407 20.8601 16.5957C20.7129 16.8508 20.5011 17.0625 20.2461 17.2098L12.3398 21.7733C12.085 21.9207 11.7957 21.9983 11.5013 21.9983C11.2069 21.9983 10.9176 21.9207 10.6628 21.7733L2.75651 17.2088C2.50164 17.0617 2.28998 16.85 2.14279 16.5952C1.9956 16.3403 1.91806 16.0512 1.91797 15.7569V6.62881C1.91797 6.02985 2.23805 5.47689 2.75651 5.17693L10.6628 0.61335C10.9176 0.465967 11.2069 0.388367 11.5013 0.388367C11.7957 0.388367 12.085 0.465967 12.3398 0.61335ZM11.3815 1.85727L4.07422 6.07585L11.5013 10.3634L18.9284 6.07585L11.6211 1.85727C11.5847 1.83605 11.5434 1.82487 11.5013 1.82487C11.4592 1.82487 11.4179 1.83605 11.3815 1.85727ZM12.2201 20.1835L19.5273 15.9649C19.5637 15.9439 19.5939 15.9137 19.6149 15.8774C19.6359 15.8411 19.6471 15.7999 19.6471 15.7579V7.32072L12.2201 11.6083V20.1835ZM3.35547 7.32168V15.7579C3.35547 15.8441 3.40147 15.9227 3.47526 15.9649L10.7826 20.1835V11.6093L3.35547 7.32168Z" fill="white" fill-opacity="0.7"/>
                            </svg>
                        </div>
                        <span class="">{{__('Packages')}}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('saas.super_admin.custom_domain.index') }}"
                       class="{{ $activeCustomDomainRequest ?? '' }} d-flex align-items-center cg-10">
                        <div class="d-flex">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7.84308 3.80211C9.8718 2.6007 10.8862 2 12 2C13.1138 2 14.1282 2.6007 16.1569 3.80211L16.8431 4.20846C18.8718 5.40987 19.8862 6.01057 20.4431 7C21 7.98943 21 9.19084 21 11.5937V12.4063C21 14.8092 21 16.0106 20.4431 17C19.8862 17.9894 18.8718 18.5901 16.8431 19.7915L16.1569 20.1979C14.1282 21.3993 13.1138 22 12 22C10.8862 22 9.8718 21.3993 7.84308 20.1979L7.15692 19.7915C5.1282 18.5901 4.11384 17.9894 3.55692 17C3 16.0106 3 14.8092 3 12.4063V11.5937C3 9.19084 3 7.98943 3.55692 7C4.11384 6.01057 5.1282 5.40987 7.15692 4.20846L7.84308 3.80211Z"
                                    stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round" />
                                <circle cx="12" cy="12" r="3" stroke="white" stroke-width="1.5"
                                        stroke-opacity="0.7" />
                            </svg>
                        </div>
                        <span class="">{{ __('Domain Request') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('saas.super_admin.frontend-setting.index')}}"
                    class="d-flex align-items-center cg-10 {{ $showFrontendSectionList ?? '' }}">
                        <div class="d-flex {{ isset($activeFrontendList) ? 'active' : 'collapsed' }}">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7.84308 3.80211C9.8718 2.6007 10.8862 2 12 2C13.1138 2 14.1282 2.6007 16.1569 3.80211L16.8431 4.20846C18.8718 5.40987 19.8862 6.01057 20.4431 7C21 7.98943 21 9.19084 21 11.5937V12.4063C21 14.8092 21 16.0106 20.4431 17C19.8862 17.9894 18.8718 18.5901 16.8431 19.7915L16.1569 20.1979C14.1282 21.3993 13.1138 22 12 22C10.8862 22 9.8718 21.3993 7.84308 20.1979L7.15692 19.7915C5.1282 18.5901 4.11384 17.9894 3.55692 17C3 16.0106 3 14.8092 3 12.4063V11.5937C3 9.19084 3 7.98943 3.55692 7C4.11384 6.01057 5.1282 5.40987 7.15692 4.20846L7.84308 3.80211Z"
                                    stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"/>
                                <circle cx="12" cy="12" r="3" stroke="white" stroke-width="1.5"
                                        stroke-opacity="0.7"/>
                            </svg>
                        </div>
                        <span class="">{{ __('Frontend Settings') }}</span>
                    </a>
                </li>
            @endif
            <li>
                <a href="{{ route('super_admin.setting.application-settings') }}"
                    class="d-flex align-items-center cg-10 {{ $activeApplicationSetting ?? '' }}">
                    <div class="d-flex {{ isset($activeApplicationSetting) ? 'active' : 'collapsed' }}">
                        <svg width="20" height="22" viewBox="0 0 20 22" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M18.8074 6.62355L18.185 5.54346C17.6584 4.62954 16.4914 4.31426 15.5763 4.83866V4.83866C15.1406 5.09528 14.6208 5.16809 14.1314 5.04103C13.6421 4.91396 13.2233 4.59746 12.9676 4.16131C12.803 3.88409 12.7146 3.56833 12.7113 3.24598V3.24598C12.7261 2.72916 12.5311 2.22834 12.1708 1.85761C11.8104 1.48688 11.3153 1.2778 10.7982 1.27802H9.54423C9.0377 1.27801 8.55205 1.47985 8.19473 1.83888C7.83742 2.19791 7.63791 2.68453 7.64034 3.19106V3.19106C7.62533 4.23686 6.77321 5.07675 5.7273 5.07664C5.40494 5.07329 5.08919 4.98488 4.81197 4.82035V4.82035C3.89679 4.29595 2.72985 4.61123 2.20327 5.52516L1.53508 6.62355C1.00914 7.53633 1.32013 8.70255 2.23073 9.23225V9.23225C2.82263 9.57398 3.18726 10.2055 3.18726 10.889C3.18726 11.5725 2.82263 12.204 2.23073 12.5457V12.5457C1.32129 13.0719 1.00996 14.2353 1.53508 15.1453V15.1453L2.16666 16.2345C2.41338 16.6797 2.82734 17.0082 3.31693 17.1474C3.80652 17.2865 4.33137 17.2248 4.77535 16.976V16.976C5.21181 16.7213 5.73192 16.6515 6.22007 16.7821C6.70822 16.9128 7.12397 17.233 7.3749 17.6716C7.53943 17.9488 7.62784 18.2646 7.63119 18.5869V18.5869C7.63119 19.6435 8.48769 20.5 9.54423 20.5H10.7982C11.8512 20.5 12.7062 19.6491 12.7113 18.5961V18.5961C12.7088 18.088 12.9096 17.6 13.2689 17.2407C13.6282 16.8814 14.1162 16.6806 14.6243 16.6831C14.9459 16.6917 15.2604 16.7797 15.5397 16.9393V16.9393C16.4524 17.4653 17.6186 17.1543 18.1484 16.2437V16.2437L18.8074 15.1453C19.0625 14.7074 19.1325 14.1859 19.0019 13.6963C18.8714 13.2067 18.551 12.7893 18.1117 12.5366V12.5366C17.6725 12.2839 17.3521 11.8665 17.2215 11.3769C17.091 10.8872 17.161 10.3658 17.4161 9.9279C17.582 9.63827 17.8221 9.39814 18.1117 9.23225V9.23225C19.0169 8.70283 19.3271 7.54343 18.8074 6.63271V6.63271V6.62355Z"
                                  stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <circle cx="10.1752" cy="10.889" r="2.63616" stroke="white"
                                    stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <span class="">{{ __('General Settings') }}</span>
                </a>
            </li>

            <li>
                <a href="{{ route('super_admin.setting.configuration-settings') }}"
                    class="d-flex align-items-center cg-10 {{ $activeConfigurationSetting ?? '' }}">
                    <div class="d-flex {{ isset($activeConfigurationSetting) ? 'active' : 'collapsed' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21" fill="none">
                            <path d="M8.25 1.5H0.75V9H8.25V1.5Z" stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M19.875 20.25H12.375" stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12.375 12.75H19.875" stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12.375 16.5H19.875" stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M20.25 9H12L16.125 0.75L20.25 9Z" stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4.5 20.25C6.57107 20.25 8.25 18.5711 8.25 16.5C8.25 14.4289 6.57107 12.75 4.5 12.75C2.42893 12.75 0.75 14.4289 0.75 16.5C0.75 18.5711 2.42893 20.25 4.5 20.25Z" stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <span class="">{{ __('App Configuration') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('super_admin.setting.gateway.index') }}"
                   class="d-flex align-items-center cg-10 {{ $activeGatewaySetting ?? '' }}">
                    <div class="d-flex {{ isset($activeGatewaySetting) ? 'active' : 'collapsed' }}">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 8H10" stroke="white" stroke-width="1.5" stroke-opacity="0.7"
                                  stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M20.8333 9H18.2308C16.4465 9 15 10.3431 15 12C15 13.6569 16.4465 15 18.2308 15H20.8333C20.9167 15 20.9583 15 20.9935 14.9979C21.5328 14.965 21.9623 14.5662 21.9977 14.0654C22 14.0327 22 13.994 22 13.9167V10.0833C22 10.006 22 9.96726 21.9977 9.9346C21.9623 9.43384 21.5328 9.03496 20.9935 9.00214C20.9583 9 20.9167 9 20.8333 9Z"
                                stroke="white" stroke-width="1.5" stroke-opacity="0.7" />
                            <path
                                d="M20.965 9C20.8873 7.1277 20.6366 5.97975 19.8284 5.17157C18.6569 4 16.7712 4 13 4L10 4C6.22876 4 4.34315 4 3.17157 5.17157C2 6.34315 2 8.22876 2 12C2 15.7712 2 17.6569 3.17157 18.8284C4.34315 20 6.22876 20 10 20H13C16.7712 20 18.6569 20 19.8284 18.8284C20.6366 18.0203 20.8873 16.8723 20.965 15"
                                stroke="white" stroke-width="1.5" stroke-opacity="0.7" />
                            <path d="M17.9922 12H18.0012" stroke="white" stroke-opacity="0.7" stroke-width="2"
                                  stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <span class="">{{ __('Payment Getaway') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('super_admin.setting.languages.index') }}"
                    class="d-flex align-items-center cg-10 {{ $activeLanguagesSetting ?? '' }}">
                    <div class="d-flex {{ isset($activeLanguagesSetting) ? 'active' : 'collapsed' }}">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.3559 18.0028L16.4299 14.1599L14.5039 18.0028" stroke="white"
                                stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M14.8516 17.3188H18.0195" stroke="white" stroke-opacity="0.7" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M16.4274 21C13.9075 21 11.8555 18.9569 11.8555 16.4279C11.8555 13.9079 13.8985 11.856 16.4274 11.856C18.9474 11.856 20.9994 13.8989 20.9994 16.4279C20.9994 18.9569 18.9564 21 16.4274 21Z"
                                stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path
                                d="M5.71799 3H9.24597C11.109 3 12.009 3.90001 11.964 5.718V9.24597C12.009 11.109 11.109 12.009 9.24597 11.964H5.71799C3.9 12 3 11.1 3 9.23696V5.709C3 3.9 3.9 3 5.71799 3Z"
                                stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M9.31023 6.46484H5.65625" stroke="white" stroke-opacity="0.7" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M7.47266 5.85291V6.46489" stroke="white" stroke-opacity="0.7" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M8.38952 6.45587C8.38952 8.03086 7.15652 9.30885 5.64453 9.30885" stroke="white"
                                stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M9.30951 9.30897C8.65252 9.30897 8.05853 8.95796 7.64453 8.39996" stroke="white"
                                stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M3 14.7C3 18.1829 5.81699 20.9999 9.29997 20.9999L8.35497 19.4249" stroke="white"
                                stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M20.9992 9.29997C20.9992 5.81699 18.1822 3 14.6992 3L15.6442 4.57499"
                                stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                    <span class="">{{ __('Multi Language') }}</span>
                </a>
            </li>
            @if(isAddonInstalled('ALUSAAS'))
            <li>
                <a href="{{ route('super_admin.setting.currencies.index') }}"
                    class="d-flex align-items-center cg-10 {{ $activeCurrenciesSetting ?? '' }}">
                    <div class="d-flex {{ isset($activeCurrenciesSetting) ? 'active' : 'collapsed' }}">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M9.78182 3.89076C10.3457 3.41023 10.6276 3.16997 10.9224 3.02907C11.6042 2.7032 12.3968 2.7032 13.0786 3.02907C13.3734 3.16997 13.6553 3.41023 14.2192 3.89076C14.4436 4.08201 14.5558 4.17764 14.6757 4.25796C14.9504 4.44209 15.2589 4.56988 15.5833 4.63393C15.7249 4.66188 15.8718 4.6736 16.1658 4.69706C16.9043 4.75599 17.2735 4.78546 17.5816 4.89427C18.2941 5.14594 18.8546 5.7064 19.1062 6.41893C19.2151 6.72699 19.2445 7.09625 19.3035 7.83475C19.3269 8.12868 19.3386 8.27564 19.3666 8.41718C19.4306 8.74163 19.5584 9.05014 19.7426 9.32485C19.8229 9.44469 19.9185 9.55691 20.1098 9.78133C20.5903 10.3452 20.8305 10.6271 20.9714 10.9219C21.2973 11.6037 21.2973 12.3963 20.9714 13.0781C20.8305 13.3729 20.5903 13.6548 20.1098 14.2187C19.9185 14.4431 19.8229 14.5553 19.7426 14.6752C19.5584 14.9499 19.4306 15.2584 19.3666 15.5828C19.3386 15.7244 19.3269 15.8713 19.3035 16.1653C19.2445 16.9038 19.2151 17.273 19.1062 17.5811C18.8546 18.2936 18.2941 18.8541 17.5816 19.1058C17.2735 19.2146 16.9043 19.244 16.1658 19.303C15.8718 19.3264 15.7249 19.3381 15.5833 19.3661C15.2589 19.4301 14.9504 19.5579 14.6757 19.7421C14.5558 19.8224 14.4436 19.918 14.2192 20.1093C13.6553 20.5898 13.3734 20.8301 13.0786 20.971C12.3968 21.2968 11.6042 21.2968 10.9224 20.971C10.6276 20.8301 10.3457 20.5898 9.78182 20.1093C9.55739 19.918 9.44518 19.8224 9.32534 19.7421C9.05063 19.5579 8.74211 19.4301 8.41767 19.3661C8.27613 19.3381 8.12917 19.3264 7.83524 19.303C7.09673 19.244 6.72748 19.2146 6.41942 19.1058C5.70689 18.8541 5.14643 18.2936 4.89476 17.5811C4.78595 17.273 4.75648 16.9038 4.69755 16.1653C4.67409 15.8713 4.66236 15.7244 4.63442 15.5828C4.57037 15.2584 4.44257 14.9499 4.25845 14.6752C4.17813 14.5553 4.0825 14.4431 3.89125 14.2187C3.41072 13.6548 3.17045 13.3729 3.02956 13.0781C2.70369 12.3963 2.70369 11.6037 3.02956 10.9219C3.17045 10.6271 3.41072 10.3452 3.89125 9.78133C4.0825 9.55691 4.17813 9.4447 4.25845 9.32485C4.44257 9.05014 4.57037 8.74163 4.63442 8.41718C4.66236 8.27564 4.67409 8.12868 4.69755 7.83475C4.75648 7.09625 4.78595 6.72699 4.89476 6.41893C5.14643 5.7064 5.70689 5.14594 6.41942 4.89427C6.72748 4.78546 7.09674 4.75599 7.83524 4.69706C8.12917 4.6736 8.27613 4.66188 8.41767 4.63393C8.74211 4.56988 9.05063 4.44209 9.32534 4.25796C9.44518 4.17764 9.5574 4.08201 9.78182 3.89076Z"
                                stroke="white" stroke-width="1.5" stroke-opacity="0.7" />
                            <path d="M9 15L15 9" stroke="white" stroke-width="1.5" stroke-opacity="0.7"
                                stroke-linecap="round" />
                            <path
                                d="M15.5 14.5C15.5 15.0523 15.0523 15.5 14.5 15.5C13.9477 15.5 13.5 15.0523 13.5 14.5C13.5 13.9477 13.9477 13.5 14.5 13.5C15.0523 13.5 15.5 13.9477 15.5 14.5Z"
                                fill="white" />
                            <path
                                d="M10.5 9.5C10.5 10.0523 10.0523 10.5 9.5 10.5C8.94772 10.5 8.5 10.0523 8.5 9.5C8.5 8.94772 8.94772 8.5 9.5 8.5C10.0523 8.5 10.5 8.94772 10.5 9.5Z"
                                fill="white" />
                        </svg>
                    </div>
                    <span class="">{{ __('Currency Settings') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('super_admin.setting.email-template') }}"
                    class="d-flex align-items-center cg-10 {{ $activeEmailSetting ?? '' }}">
                    <div class="d-flex {{ isset($activeEmailSetting) ? 'active' : 'collapsed' }}">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M22 10C22.0185 10.7271 22 11.0542 22 12C22 15.7712 22 17.6569 20.8284 18.8284C19.6569 20 17.7712 20 14 20H10C6.22876 20 4.34315 20 3.17157 18.8284C2 17.6569 2 15.7712 2 12C2 8.22876 2 6.34315 3.17157 5.17157C4.34315 4 6.22876 4 10 4H13"
                                stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round" />
                            <path
                                d="M6 8L8.1589 9.79908C9.99553 11.3296 10.9139 12.0949 12 12.0949C13.0861 12.0949 14.0045 11.3296 15.8411 9.79908"
                                stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round" />
                            <circle cx="19" cy="5" r="3" stroke="white" stroke-opacity="0.7"
                                stroke-width="1.5" />
                        </svg>
                    </div>
                    <span class="">{{ __('Email Template') }}</span>
                </a>
            </li>
            @endif
            <li>
                <a href="{{ route('super_admin.version-update') }}"
                   class="{{ $activeVersionUpdate ?? '' }} d-flex align-items-center cg-10">
                    <div class="d-flex">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26"
                             fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M8.27884 4.92549C10.0763 3.88705 12.1654 3.46843 14.2242 3.73408C16.283 3.99973 18.1974 4.93491 19.6723 6.39559C21.1474 7.8563 22.1012 9.76146 22.387 11.8176C22.4661 12.3865 22.069 12.9118 21.5 12.9908C20.9311 13.0699 20.4058 12.6728 20.3268 12.1039C20.1038 10.4996 19.3597 9.01321 18.2088 7.87359C17.0581 6.73393 15.5644 6.00424 13.958 5.79697C12.3516 5.58971 10.7218 5.91633 9.31934 6.72653C8.39658 7.25961 7.60597 7.98262 6.99568 8.8407H8.87688C9.45125 8.8407 9.91688 9.30633 9.91688 9.8807C9.91688 10.4551 9.45125 10.9207 8.87688 10.9207H5.26014C5.24439 10.921 5.2286 10.921 5.21279 10.9207H4.71688C4.1425 10.9207 3.67688 10.4551 3.67688 9.8807V5.7207C3.67688 5.14633 4.1425 4.6807 4.71688 4.6807C5.29126 4.6807 5.75688 5.14633 5.75688 5.7207V7.04449C6.46258 6.20169 7.31439 5.48266 8.27884 4.92549ZM4.57373 13.0107C5.14264 12.9316 5.66792 13.3287 5.74698 13.8976C5.96993 15.5018 6.71412 16.9882 7.86498 18.1279C9.01582 19.2676 10.5094 19.9972 12.1157 20.2045C13.722 20.4118 15.352 20.0851 16.7545 19.2749C17.6772 18.7418 18.4679 18.0188 19.0782 17.1607H17.1969C16.6225 17.1607 16.1569 16.6951 16.1569 16.1207C16.1569 15.5463 16.6225 15.0807 17.1969 15.0807H20.8136C20.8294 15.0804 20.8451 15.0804 20.861 15.0807H21.3569C21.9313 15.0807 22.3969 15.5463 22.3969 16.1207V20.2807C22.3969 20.8551 21.9313 21.3207 21.3569 21.3207C20.7825 21.3207 20.3169 20.8551 20.3169 20.2807V18.957C19.6112 19.7998 18.7594 20.5189 17.7949 21.076C15.9975 22.1144 13.9083 22.533 11.8495 22.2673C9.79073 22.0017 7.87638 21.0665 6.40137 19.6059C4.92637 18.1451 3.97252 16.24 3.68678 14.1839C3.60772 13.6151 4.00482 13.0897 4.57373 13.0107Z"
                                  fill="white" fill-opacity="0.7"/>
                        </svg>
                    </div>
                    <span class="">{{ __('Version Update') }}</span>
                </a>
            </li>
            @if(isAddonInstalled('ALUSAAS'))
                <li>
                    <a href="{{route('saas.super_admin.contact-list')}}" class="d-flex align-items-center cg-10 {{$activeContactUs ?? ''}}">
                        <div class="d-flex  {{ isset($activeContactUs) ? 'active' : 'collapsed' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M17.7071 13.7071L20.3552 16.3552C20.7113 16.7113 20.7113 17.2887 20.3552 17.6448C18.43 19.57 15.3821 19.7866 13.204 18.153L11.6286 16.9714C9.88504 15.6638 8.33622 14.115 7.02857 12.3714L5.84701 10.796C4.21341 8.61788 4.43001 5.56999 6.35523 3.64477C6.71133 3.28867 7.28867 3.28867 7.64477 3.64477L10.2929 6.29289C10.6834 6.68342 10.6834 7.31658 10.2929 7.70711L9.27175 8.72825C9.10946 8.89054 9.06923 9.13846 9.17187 9.34373C10.3585 11.7171 12.2829 13.6415 14.6563 14.8281C14.8615 14.9308 15.1095 14.8905 15.2717 14.7283L16.2929 13.7071C16.6834 13.3166 17.3166 13.3166 17.7071 13.7071Z" stroke="white" stroke-opacity="0.7" stroke-width="1.5"/>
                            </svg>
                        </div>
                        <span class="">{{__('Contact Us')}}</span>
                    </a>
                </li>
            @endif
        </ul>

        <ul>
            <li class="d-inline-flex align-items-center cg-15 pt-17 px-25">
                <span class="align-items-center cg-10 has-subMenu-arrow">
                    {{ __('Version') }} : {{ getOption('current_version', 'v1.0') }}
                </span>
            </li>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="d-inline-flex align-items-center cg-15 pt-17 pb-30 px-25">
                <img src="{{ asset('assets/images/icon/logout.svg') }}" alt=""/>
                <p class="fs-14 fw-500 lh-16 text-white-70">{{ __('Logout') }}</p>
            </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </ul>

    </div>
</div>
