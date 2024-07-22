@php
    use Illuminate\Support\Facades\Auth;

    $authenticatedUser = Auth::user();
    $userInfo = null;

    if ($authenticatedUser) {
        switch ($authenticatedUser->role_id) {
            case 1:
                $userInfo = $authenticatedUser->admin;
                $role = 'admin';
                break;
            case 2:
                $userInfo = $authenticatedUser->alumni;
                $role = 'alumni';
                break;
            case 3:
                $userInfo = $authenticatedUser->alumni;
                $role = 'company';
                break;
        }
    }
@endphp

@if($authenticatedUser && $userInfo)
    <div class="zSidebar">
        <div class="zSidebar-overlay"></div>
        <!-- Logo -->
        <a href="{{ route('index') }}" class="d-block mx-26">
            <img class="max-h-69 d-block m-auto" src="{{ asset('public/frontend/images/liu-logo.png') }}"
                 alt="LIU Logo"/>
        </a>
        <!-- Menu & Logout -->
        <div class="zSidebar-fixed">
            <ul class="zSidebar-menu" id="sidebarMenu">
                @if($role=='admin'||$role=='alumni')
                    <li>
                        <a href="{{ route($role.'.home') }}"
                           class="{{ $activeHome ?? '' }} d-flex align-items-center cg-10">
                            <div class="d-flex">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 22 20"
                                     fill="none">
                                    <path d="M1.71387 11.4286L10.9996 2.14285L20.2853 11.4286" stroke="white"
                                          stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"
                                          stroke-linejoin="round"/>
                                    <path d="M4.57129 8.57144L4.57129 17.8572H17.4284V8.57144" stroke="white"
                                          stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"
                                          stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <span class="">{{ __('Home') }}</span>
                        </a>
                    </li>
                @endif
                @if($role == 'alumni')

                    <li>
                        <a href="{{route('alumni.notices.index')}}"
                           class="{{ $activeManageNotice ?? '' }} d-flex align-items-center cg-10 {{ isset($showNotice) ? 'active' : 'collapsed' }}">
                            <div class="d-flex">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="10" cy="10" r="9.25" stroke="white" stroke-opacity="0.7"
                                            stroke-width="1.5"/>
                                    <path
                                        d="M9.18262 11.7393L9.08008 4.81445H10.7207L10.6113 11.7393H9.18262ZM9.90039 15.0957C9.61328 15.0957 9.37174 15.0023 9.17578 14.8154C8.98438 14.624 8.88867 14.3893 8.88867 14.1113C8.88867 13.8288 8.98438 13.5941 9.17578 13.4072C9.37174 13.2158 9.61328 13.1201 9.90039 13.1201C10.1829 13.1201 10.4199 13.2158 10.6113 13.4072C10.8073 13.5941 10.9053 13.8288 10.9053 14.1113C10.9053 14.3893 10.8073 14.624 10.6113 14.8154C10.4199 15.0023 10.1829 15.0957 9.90039 15.0957Z"
                                        fill="white" fill-opacity="0.7"/>
                                </svg>
                            </div>
                            <span class="">{{ __('Notice') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('alumni.news.index')}}"
                           class="{{ $activeManageNews ?? '' }} d-flex align-items-center cg-10">
                            <div class="d-flex">
                                <svg width="20" height="18" viewBox="0 0 20 18" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M1 1V15C1 15.5304 1.21071 16.0391 1.58579 16.4142C1.96086 16.7893 2.46957 17 3 17H17C17.5304 17 18.0391 16.7893 18.4142 16.4142C18.7893 16.0391 19 15.5304 19 15V5H15"
                                        stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"/>
                                    <path
                                        d="M1 1H15V15C15 15.5304 15.2107 16.0391 15.5858 16.4142C15.9609 16.7893 16.4696 17 17 17M11 5H5M11 9H7"
                                        stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <span class="">{{ __('News') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="#recommendation_menu" data-bs-toggle="collapse" role="button"
                           aria-expanded="{{ isset($showRecommendationManagement) ? 'true' : '' }}" aria-controls="cvs"
                           class="d-flex align-items-center cg-10 {{ isset($showRecommendationManagement) ? 'active' : 'collapsed' }}">
                            <div class="d-flex">
                                <svg width="25" height="26" viewBox="0 0 25 26" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <rect x="5.20801" y="5.11185" width="14.5833" height="17.7083" rx="2" stroke="white"
                                          stroke-opacity="0.7" stroke-width="1.5"/>
                                    <path d="M9.375 10.3202H15.625" stroke="white" stroke-opacity="0.7"
                                          stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M9.375 14.4868H15.625" stroke="white" stroke-opacity="0.7"
                                          stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M9.375 18.6535H13.5417" stroke="white" stroke-opacity="0.7"
                                          stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <span class="">{{__('Recommendation')}}</span>
                        </a>
                        <div class="collapse {{ $showRecommendationManagement ?? '' }}" id="recommendation_menu"
                             data-bs-parent="#sidebarMenu">
                            <ul class="zSidebar-submenu">
                                <li><a class="d-flex align-items-center {{$activeRecommendation??''}} cg-10"
                                       href="{{ route('alumni.recommendation.index') }}">{{ __('list') }}</a></li>
                                <li><a class="d-flex align-items-center {{$activeRequest??''}} cg-10"
                                       href="{{ route('alumni.recommendation.create') }}">{{ __('Request') }}</a></li>
                            </ul>
                        </div>
                    </li>
                        <li>
                            <a href="#cvs" data-bs-toggle="collapse" role="button"
                               aria-expanded="{{ isset($showProfileManagement) ? 'true' : '' }}" aria-controls="cvs"
                               class="d-flex align-items-center cg-10 {{ isset($showProfileManagement) ? 'active' : 'collapsed' }}">
                                <div class="d-flex">
                                    <svg width="25" height="26" viewBox="0 0 25 26" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <rect x="5.20801" y="5.11185" width="14.5833" height="17.7083" rx="2" stroke="white"
                                              stroke-opacity="0.7" stroke-width="1.5"/>
                                        <path d="M9.375 10.3202H15.625" stroke="white" stroke-opacity="0.7"
                                              stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M9.375 14.4868H15.625" stroke="white" stroke-opacity="0.7"
                                              stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M9.375 18.6535H13.5417" stroke="white" stroke-opacity="0.7"
                                              stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                </div>
                                <span class="">{{__('Profile')}}</span>
                            </a>
                            <div class="collapse {{ $showProfileManagement ?? '' }}" id="cvs" data-bs-parent="#sidebarMenu">
                                <ul class="zSidebar-submenu">
                                    <li><a href="{{ route('alumni.profile.index') }}"
                                           class="{{ $activeProfile ?? '' }} d-flex align-items-center cg-10">{{ __('Profile') }}</a>
                                    </li>
                                    <li><a class="{{ $activeAllJobPostList ?? '' }}"
                                           href="{{ route('alumni.images') }}">{{ __('Graduation Images') }}</a></li>
                                </ul>
                            </div>
                        </li>
                @endif


                @if($role == 'admin')
                    <li>
                            <a href="{{ route('admin.dashboard') }}"
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
                    <li>
                        <a href="#storyMenu" data-bs-toggle="collapse" role="button"
                           aria-expanded="{{ isset($showStoryManagement) ? 'true' : 'collapsed' }}"
                           aria-controls="storyMenu"
                           class="d-flex align-items-center cg-10 {{ isset($showStoryManagement) ? 'active' : 'collapsed' }}">
                            <div class="d-flex">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="26" viewBox="0 0 25 26"
                                     fill="none">
                                    <path
                                        d="M20.0934 4.00108L20.1195 4.75063V4.75063L20.0934 4.00108ZM16.7072 4.4451L16.4921 3.72661V3.72661L16.7072 4.4451ZM14.0356 5.6885L13.6599 5.03937L13.6599 5.03937L14.0356 5.6885ZM4.87402 4.0551L4.82801 4.80369L4.87402 4.0551ZM7.72663 4.4451L7.91799 3.71992L7.91799 3.71992L7.72663 4.4451ZM10.8294 5.75723L10.4788 6.42024L10.8294 5.75723ZM13.9919 20.1203L14.3447 20.7822L13.9919 20.1203ZM17.1799 18.7629L16.9885 18.0378L17.1799 18.7629ZM20.0018 18.3748L20.0487 19.1234L20.0018 18.3748ZM10.9147 20.1203L10.5619 20.7822H10.5619L10.9147 20.1203ZM7.72663 18.7629L7.91799 18.0378H7.91799L7.72663 18.7629ZM4.9047 18.3748L4.85788 19.1234H4.85788L4.9047 18.3748ZM3.75 16.4093V5.87288H2.25V16.4093H3.75ZM22.6565 16.4093V5.81181H21.1565V16.4093H22.6565ZM20.0673 3.25154C18.9906 3.28904 17.5796 3.40106 16.4921 3.72661L16.9223 5.16359C17.8143 4.89658 19.0624 4.78745 20.1195 4.75063L20.0673 3.25154ZM16.4921 3.72661C15.5467 4.00964 14.4853 4.56168 13.6599 5.03937L14.4113 6.33762C15.2146 5.87269 16.1517 5.39429 16.9223 5.16359L16.4921 3.72661ZM4.82801 4.80369C5.74061 4.85978 6.77153 4.96874 7.53527 5.17028L7.91799 3.71992C7.00565 3.47917 5.8534 3.36388 4.92003 3.30651L4.82801 4.80369ZM7.53527 5.17028C8.44003 5.40902 9.55596 5.93224 10.4788 6.42024L11.18 5.09421C10.2385 4.59634 8.99693 4.00463 7.91799 3.71992L7.53527 5.17028ZM14.3447 20.7822C15.281 20.283 16.4378 19.7344 17.3713 19.4881L16.9885 18.0378C15.8773 18.331 14.5924 18.9503 13.6391 19.4585L14.3447 20.7822ZM17.3713 19.4881C18.1263 19.2889 19.1429 19.18 20.0487 19.1234L19.955 17.6263C19.0279 17.6843 17.891 17.7996 16.9885 18.0378L17.3713 19.4881ZM11.2675 19.4585C10.3142 18.9503 9.02921 18.331 7.91799 18.0378L7.53527 19.4881C8.46871 19.7344 9.6255 20.283 10.5619 20.7822L11.2675 19.4585ZM7.91799 18.0378C7.01549 17.7996 5.8786 17.6843 4.95152 17.6263L4.85788 19.1234C5.76364 19.18 6.78023 19.2889 7.53527 19.4881L7.91799 18.0378ZM21.1565 16.4093C21.1565 17.0343 20.6378 17.5836 19.955 17.6263L20.0487 19.1234C21.4623 19.035 22.6565 17.8848 22.6565 16.4093H21.1565ZM22.6565 5.81181C22.6565 4.40713 21.5375 3.20032 20.0673 3.25154L20.1195 4.75063C20.6757 4.73125 21.1565 5.18885 21.1565 5.81181H22.6565ZM2.25 16.4093C2.25 17.8848 3.44425 19.035 4.85788 19.1234L4.95152 17.6263C4.26877 17.5836 3.75 17.0343 3.75 16.4093H2.25ZM13.6391 19.4585C12.9022 19.8513 12.0044 19.8513 11.2675 19.4585L10.5619 20.7822C11.7398 21.4101 13.1667 21.4101 14.3447 20.7822L13.6391 19.4585ZM13.6599 5.03937C12.8986 5.47998 11.9509 5.50181 11.18 5.09421L10.4788 6.42024C11.7131 7.07288 13.2095 7.03314 14.4113 6.33762L13.6599 5.03937ZM3.75 5.87288C3.75 5.23574 4.25397 4.76841 4.82801 4.80369L4.92003 3.30651C3.42171 3.21443 2.25 4.43377 2.25 5.87288H3.75Z"
                                        fill="white" fill-opacity="0.7"/>
                                    <path d="M12.4531 6.68213V21" stroke="white" stroke-opacity="0.7"
                                          stroke-width="1.5"/>
                                    <path d="M5.83594 9.65613L9.61725 10.6015" stroke="white" stroke-opacity="0.7"
                                          stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M5.83594 13.4375L9.61725 14.3828" stroke="white" stroke-opacity="0.7"
                                          stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M19.0703 13.4375L15.289 14.3828" stroke="white" stroke-opacity="0.7"
                                          stroke-width="1.5" stroke-linecap="round"/>
                                    <path
                                        d="M19.0704 6.34753V10.1386C19.0704 10.3991 19.0704 10.5293 18.9807 10.582C18.891 10.6346 18.7684 10.5764 18.5231 10.4599L17.3488 9.90207C17.2658 9.86265 17.2243 9.84294 17.1797 9.84294C17.1351 9.84294 17.0936 9.86265 17.0106 9.90207L15.8363 10.4599C15.591 10.5764 15.4684 10.6346 15.3787 10.582C15.2891 10.5293 15.2891 10.3991 15.2891 10.1386V7.71828"
                                        stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <span class="">{{__('Manage Stories')}}</span>
                        </a>
                        <div class="collapse {{ $showStoryManagement ?? '' }}" id="storyMenu"
                             data-bs-parent="#sidebarMenu">
                            <ul class="zSidebar-submenu">
                                <li><a class="{{ $activeStoryCreate ?? '' }}"
                                       href="{{ route('admin.stories.create') }}">{{ __('Create Story') }}</a></li>
                                <li><a class="{{ $activePendingStoryList ?? '' }}"
                                       href="{{ route('admin.stories.active') }}">{{ __('Active Story') }}</a></li>
                                <li><a class="{{ $activeMyStoryList ?? '' }}"
                                       href="{{ route('admin.stories.my-story') }}">{{ __('My Story') }}</a></li>
                                <li><a class="{{ $activeAllStoryList ?? '' }}"
                                       href="{{ route('admin.stories.all') }}">{{ __('All Story') }}</a></li>
                            </ul>
                        </div>
                    </li>
                    <li>
                            <a href="#companiesMenu" data-bs-toggle="collapse" role="button"
                               aria-expanded="{{ isset($showCompanyManagement) ? 'true' : 'collapsed' }}"
                               aria-controls="companiesMenu"
                               class="d-flex align-items-center cg-10 {{ isset($showCompanyManagement) ? 'active' : 'collapsed' }}">
                                <div class="d-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                         class="bi bi-building text-white-70" viewBox="0 0 16 16">
                                        <path
                                            d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z"/>
                                        <path
                                            d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1zm11 0H3v14h3v-2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V15h3z"/>
                                    </svg>
                                </div>
                                <span class="">{{__('Manage Companies')}}</span>
                            </a>
                            <div class="collapse {{ $showCompanyManagement ?? '' }}" id="companiesMenu"
                                 data-bs-parent="#sidebarMenu">
                                <ul class="zSidebar-submenu">
                                    <li><a class="{{ $activeAllCompanyList ?? '' }}"
                                           href="{{ route('admin.company.all') }}">{{ __('All') }}</a></li>
                                    <li><a class="{{ $activePendingCompanyList ?? '' }}"
                                           href="{{ route('admin.company.pending') }}">{{ __('Pending') }}</a></li>
                                    <li><a class="{{ $activeCompanyActiveList ?? '' }}"
                                           href="{{ route('admin.company.active') }}">{{ __('Active') }}</a></li>
                                </ul>
                            </div>
                        </li>
                    <li>
                            <a href="#manage-news-menu" data-bs-toggle="collapse" role="button"
                               aria-expanded="{{ isset($showManageNews) ? 'true' : 'false' }}"
                               aria-controls="manage-news-menu"
                               class="d-flex align-items-center cg-10 {{ isset($showManageNews) ? 'active' : 'collapsed' }}">
                                <div class="d-flex">
                                    <svg width="20" height="18" viewBox="0 0 20 18" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M1 1V15C1 15.5304 1.21071 16.0391 1.58579 16.4142C1.96086 16.7893 2.46957 17 3 17H17C17.5304 17 18.0391 16.7893 18.4142 16.4142C18.7893 16.0391 19 15.5304 19 15V5H15"
                                            stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"/>
                                        <path
                                            d="M1 1H15V15C15 15.5304 15.2107 16.0391 15.5858 16.4142C15.9609 16.7893 16.4696 17 17 17M11 5H5M11 9H7"
                                            stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <span class="">{{ __('Manage News') }}</span>
                            </a>
                            <div class="collapse {{ $showManageNews ?? '' }}" id="manage-news-menu"
                                 data-bs-parent="#sidebarMenu">
                                <ul class="zSidebar-submenu">
                                    <li><a class="{{ $activeNewsCategory ?? '' }}"
                                           href="{{ route('admin.news.categories.index') }}">{{ __('Category') }}</a></li>
                                    <li><a class="{{ $activeManageNews ?? '' }}"
                                           href="{{ route('admin.news.index') }}">{{ __('News') }}</a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="#jobPost" data-bs-toggle="collapse" role="button"
                               aria-expanded="{{ isset($showJobPostManagement) ? 'true' : '' }}" aria-controls="jobPost"
                               class="d-flex align-items-center cg-10 {{ isset($showJobPostManagement) ? 'active' : 'collapsed' }}">
                                <div class="d-flex">
                                    <svg width="25" height="26" viewBox="0 0 25 26" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <rect x="5.20801" y="5.11185" width="14.5833" height="17.7083" rx="2" stroke="white"
                                              stroke-opacity="0.7" stroke-width="1.5"/>
                                        <path d="M9.375 10.3202H15.625" stroke="white" stroke-opacity="0.7" stroke-width="1.5"
                                              stroke-linecap="round"/>
                                        <path d="M9.375 14.4868H15.625" stroke="white" stroke-opacity="0.7" stroke-width="1.5"
                                              stroke-linecap="round"/>
                                        <path d="M9.375 18.6535H13.5417" stroke="white" stroke-opacity="0.7" stroke-width="1.5"
                                              stroke-linecap="round"/>
                                    </svg>
                                </div>
                                <span class="">{{__('Manage Jobs')}}</span>
                            </a>
                            <div class="collapse {{ $showJobPostManagement ?? '' }}" id="jobPost" data-bs-parent="#sidebarMenu">
                                <ul class="zSidebar-submenu">
                                    @if($role != 'alumni')
                                        <li>
                                            <a class="{{ $activeJobPostCreate ?? '' }}"
                                               href="{{ route($role.'.jobs.create') }}">{{ __('Create Post') }}</a>
                                        </li>
                                        @if($role == 'admin')
                                            <li>
                                                <a class="{{ $activeMyJobPostList ?? '' }}"
                                                   href="{{ route($role.'.jobs.my-job-post') }}">{{ __('My Post') }}</a>
                                            </li>
                                        @endif
                                    @endif
                                    <li>
                                        <a class="{{ $activePendingJobPostList ?? '' }}"
                                           href="{{ route($role.'.jobs.pending') }}">{{ __('Pending Jobs') }}</a>
                                    </li>
                                    <li>
                                        <a class="{{ $activeAllJobPostList ?? '' }}"
                                           href="{{ route($role.'.jobs.all-job-post') }}">{{ __('All Jobs') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    <li>
                            <a href="#manage-notice-menu" data-bs-toggle="collapse" role="button"
                               aria-expanded="{{ isset($showManageNotice) ? 'true' : 'false' }}"
                               aria-controls="manage-notice-menu"
                               class="d-flex align-items-center cg-10 {{ isset($showManageNotice) ? 'active' : 'collapsed' }}">
                                <div class="d-flex">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="10" cy="10" r="9.25" stroke="white" stroke-opacity="0.7"
                                                stroke-width="1.5"/>
                                        <path
                                            d="M9.18262 11.7393L9.08008 4.81445H10.7207L10.6113 11.7393H9.18262ZM9.90039 15.0957C9.61328 15.0957 9.37174 15.0023 9.17578 14.8154C8.98438 14.624 8.88867 14.3893 8.88867 14.1113C8.88867 13.8288 8.98438 13.5941 9.17578 13.4072C9.37174 13.2158 9.61328 13.1201 9.90039 13.1201C10.1829 13.1201 10.4199 13.2158 10.6113 13.4072C10.8073 13.5941 10.9053 13.8288 10.9053 14.1113C10.9053 14.3893 10.8073 14.624 10.6113 14.8154C10.4199 15.0023 10.1829 15.0957 9.90039 15.0957Z"
                                            fill="white" fill-opacity="0.7"/>
                                    </svg>
                                </div>
                                <span class="">{{ __('Manage Notice') }}</span>
                            </a>
                            <div class="collapse {{ $showManageNotice ?? '' }}" id="manage-notice-menu"
                                 data-bs-parent="#sidebarMenu">
                                <ul class="zSidebar-submenu">
                                    <li><a class="{{ $activeNoticeCategory ?? '' }}"
                                           href="{{ route('admin.notices.categories.index') }}">{{ 'Category' }}</a></li>
                                    <li><a class="{{ $activeManageNotice ?? '' }}"
                                           href="{{ route($role.'.notices.index') }}">{{ 'Notice' }}</a></li>
                                </ul>
                            </div>
                        </li>
                    <li>
                        <a href="{{ route('admin.alumni.list') }}"
                           class="{{ $activeAlumniList ?? '' }} d-flex align-items-center cg-10">
                            <div class="d-flex">
                                <svg width="25" height="18" viewBox="0 0 25 18" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M23.9065 10.6875C23.8245 10.7491 23.7311 10.7939 23.6317 10.8193C23.5323 10.8448 23.4289 10.8504 23.3273 10.8359C23.2257 10.8214 23.128 10.787 23.0398 10.7348C22.9515 10.6825 22.8744 10.6133 22.8128 10.5313C22.3419 9.89831 21.729 9.38477 21.0234 9.03196C20.3178 8.67916 19.5392 8.49695 18.7503 8.50001C18.5967 8.5 18.4464 8.45469 18.3184 8.36975C18.1904 8.28481 18.0903 8.16402 18.0306 8.02247C17.99 7.92635 17.9691 7.82309 17.9691 7.71876C17.9691 7.61444 17.99 7.51117 18.0306 7.41505C18.0903 7.2735 18.1904 7.15271 18.3184 7.06777C18.4464 6.98283 18.5967 6.93753 18.7503 6.93751C19.1886 6.93747 19.6182 6.8145 19.9902 6.58257C20.3621 6.35064 20.6616 6.01904 20.8546 5.62544C21.0475 5.23184 21.1262 4.79202 21.0817 4.35593C21.0373 3.91984 20.8714 3.50497 20.6029 3.15843C20.3345 2.8119 19.9742 2.54759 19.5631 2.39554C19.152 2.24348 18.7064 2.20977 18.2771 2.29824C17.8478 2.3867 17.4518 2.5938 17.1343 2.896C16.8168 3.1982 16.5903 3.58339 16.4808 4.00782C16.4551 4.10721 16.4101 4.20058 16.3484 4.28258C16.2867 4.36459 16.2094 4.43364 16.121 4.48578C16.0326 4.53792 15.9347 4.57214 15.8331 4.58648C15.7315 4.60082 15.628 4.595 15.5286 4.56935C15.4292 4.5437 15.3359 4.49872 15.2539 4.43699C15.1718 4.37526 15.1028 4.29798 15.0507 4.20957C14.9985 4.12115 14.9643 4.02333 14.95 3.92169C14.9356 3.82006 14.9414 3.71659 14.9671 3.6172C15.1192 3.02864 15.4066 2.4837 15.8063 2.02575C16.2061 1.56779 16.7072 1.20946 17.2699 0.97926C17.8325 0.749062 18.4411 0.653353 19.0472 0.699748C19.6533 0.746143 20.2403 0.933362 20.7613 1.24651C21.2823 1.55965 21.7231 1.99008 22.0485 2.50354C22.3739 3.01701 22.575 3.59933 22.6358 4.20419C22.6965 4.80904 22.6153 5.41973 22.3985 5.98766C22.1817 6.55558 21.8354 7.06508 21.387 7.4756C22.4493 7.93555 23.3728 8.66545 24.0657 9.59278C24.1273 9.67507 24.172 9.76869 24.1973 9.86828C24.2226 9.96787 24.228 10.0715 24.2133 10.1732C24.1985 10.2749 24.1638 10.3726 24.1111 10.4609C24.0585 10.5492 23.989 10.6262 23.9065 10.6875ZM18.6448 16.7031C18.7014 16.7921 18.7393 16.8915 18.7564 16.9955C18.7735 17.0994 18.7694 17.2058 18.7443 17.3081C18.7193 17.4105 18.6738 17.5067 18.6105 17.591C18.5473 17.6753 18.4677 17.7459 18.3765 17.7986C18.2853 17.8514 18.1843 17.8851 18.0797 17.8978C17.9751 17.9105 17.869 17.9019 17.7678 17.8726C17.6666 17.8432 17.5724 17.7937 17.4909 17.727C17.4093 17.6603 17.3421 17.5777 17.2933 17.4844C16.8011 16.6511 16.1002 15.9604 15.2597 15.4807C14.4192 15.0009 13.4681 14.7486 12.5003 14.7486C11.5325 14.7486 10.5814 15.0009 9.74089 15.4807C8.90038 15.9604 8.19947 16.6511 7.70732 17.4844C7.65848 17.5777 7.59126 17.6603 7.50971 17.727C7.42815 17.7937 7.33394 17.8432 7.23274 17.8726C7.13155 17.9019 7.02546 17.9105 6.92087 17.8978C6.81627 17.8851 6.71532 17.8514 6.6241 17.7986C6.53288 17.7459 6.45326 17.6753 6.39005 17.591C6.32683 17.5067 6.28132 17.4105 6.25625 17.3081C6.23119 17.2058 6.22708 17.0994 6.24418 16.9955C6.26128 16.8915 6.29924 16.7921 6.35576 16.7031C7.11318 15.4017 8.26806 14.3776 9.65068 13.7813C8.87268 13.1856 8.30091 12.3611 8.01572 11.4237C7.73054 10.4862 7.74629 9.48301 8.06076 8.555C8.37522 7.62698 8.9726 6.82084 9.76892 6.24989C10.5652 5.67894 11.5204 5.37188 12.5003 5.37188C13.4801 5.37188 14.4354 5.67894 15.2317 6.24989C16.028 6.82084 16.6254 7.62698 16.9398 8.555C17.2543 9.48301 17.27 10.4862 16.9849 11.4237C16.6997 12.3611 16.1279 13.1856 15.3499 13.7813C16.7325 14.3776 17.8874 15.4017 18.6448 16.7031ZM12.5003 13.1875C13.1184 13.1875 13.7225 13.0042 14.2365 12.6609C14.7504 12.3175 15.1509 11.8294 15.3874 11.2584C15.6239 10.6874 15.6858 10.059 15.5652 9.45285C15.4447 8.84666 15.147 8.28984 14.71 7.8528C14.273 7.41576 13.7161 7.11814 13.11 6.99756C12.5038 6.87698 11.8754 6.93886 11.3044 7.17539C10.7334 7.41191 10.2453 7.81245 9.90195 8.32635C9.55857 8.84026 9.37529 9.44444 9.37529 10.0625C9.37529 10.8913 9.70453 11.6862 10.2906 12.2722C10.8766 12.8583 11.6715 13.1875 12.5003 13.1875ZM7.03154 7.71876C7.03154 7.51156 6.94923 7.31285 6.80272 7.16633C6.65621 7.01982 6.45749 6.93751 6.25029 6.93751C5.81194 6.93747 5.38239 6.8145 5.01042 6.58257C4.63845 6.35064 4.33898 6.01904 4.14603 5.62544C3.95307 5.23184 3.87437 4.79202 3.91885 4.35593C3.96333 3.91984 4.12921 3.50497 4.39766 3.15843C4.66611 2.8119 5.02637 2.54759 5.4375 2.39554C5.84863 2.24348 6.29417 2.20977 6.7235 2.29824C7.15283 2.3867 7.54875 2.5938 7.86628 2.896C8.18382 3.1982 8.41024 3.58339 8.51982 4.00782C8.57162 4.20855 8.70104 4.38048 8.8796 4.48578C9.05817 4.59109 9.27125 4.62115 9.47197 4.56935C9.6727 4.51755 9.84462 4.38813 9.94993 4.20957C10.0552 4.03101 10.0853 3.81792 10.0335 3.6172C9.88139 3.02864 9.59402 2.4837 9.19425 2.02575C8.79448 1.56779 8.29334 1.20946 7.73072 0.97926C7.16809 0.749062 6.5595 0.653353 5.95338 0.699748C5.34725 0.746143 4.76032 0.933362 4.23928 1.24651C3.71825 1.55965 3.27749 1.99008 2.95207 2.50354C2.62666 3.01701 2.42557 3.59933 2.36481 4.20419C2.30406 4.80904 2.3853 5.41973 2.60209 5.98766C2.81888 6.55558 3.16523 7.06508 3.61357 7.4756C2.55233 7.93599 1.6299 8.66585 0.937793 9.59278C0.876172 9.67486 0.83132 9.76827 0.805799 9.86768C0.780277 9.96709 0.774586 10.0706 0.78905 10.1722C0.803514 10.2738 0.837849 10.3715 0.890096 10.4599C0.942343 10.5482 1.01148 10.6254 1.09355 10.687C1.17563 10.7486 1.26904 10.7935 1.36845 10.819C1.46786 10.8445 1.57132 10.8502 1.67293 10.8358C1.77454 10.8213 1.87231 10.787 1.96065 10.7347C2.04899 10.6825 2.12617 10.6133 2.18779 10.5313C2.65868 9.89831 3.2716 9.38477 3.97721 9.03196C4.68282 8.67916 5.4614 8.49695 6.25029 8.50001C6.45749 8.50001 6.65621 8.4177 6.80272 8.27119C6.94923 8.12468 7.03154 7.92596 7.03154 7.71876Z"
                                        fill="white" fill-opacity="0.7"/>
                                </svg>
                            </div>
                            <span class="">{{ __('Alumni') }}</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route($role.'.index') }}"
                           class="{{ $activeAdmin ?? '' }} d-flex align-items-center cg-10">
                            <div class="d-flex">
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M19.7274 21.3923C19.2716 20.1165 18.2672 18.9892 16.8701 18.1851C15.4729 17.381 13.7611 16.9452 12 16.9452C10.2389 16.9452 8.52706 17.381 7.12991 18.1851C5.73276 18.9892 4.72839 20.1165 4.27259 21.3923"
                                        stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"/>
                                    <circle cx="12" cy="8.94522" r="4" stroke="white" stroke-opacity="0.7"
                                            stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <span class="">{{ __('Admins') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.students.index') }}"
                           class="{{ $showManageStudents ?? '' }} d-flex align-items-center cg-10">
                            <div class="d-flex">
                                <svg width="25" height="18" viewBox="0 0 25 18" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M23.9065 10.6875C23.8245 10.7491 23.7311 10.7939 23.6317 10.8193C23.5323 10.8448 23.4289 10.8504 23.3273 10.8359C23.2257 10.8214 23.128 10.787 23.0398 10.7348C22.9515 10.6825 22.8744 10.6133 22.8128 10.5313C22.3419 9.89831 21.729 9.38477 21.0234 9.03196C20.3178 8.67916 19.5392 8.49695 18.7503 8.50001C18.5967 8.5 18.4464 8.45469 18.3184 8.36975C18.1904 8.28481 18.0903 8.16402 18.0306 8.02247C17.99 7.92635 17.9691 7.82309 17.9691 7.71876C17.9691 7.61444 17.99 7.51117 18.0306 7.41505C18.0903 7.2735 18.1904 7.15271 18.3184 7.06777C18.4464 6.98283 18.5967 6.93753 18.7503 6.93751C19.1886 6.93747 19.6182 6.8145 19.9902 6.58257C20.3621 6.35064 20.6616 6.01904 20.8546 5.62544C21.0475 5.23184 21.1262 4.79202 21.0817 4.35593C21.0373 3.91984 20.8714 3.50497 20.6029 3.15843C20.3345 2.8119 19.9742 2.54759 19.5631 2.39554C19.152 2.24348 18.7064 2.20977 18.2771 2.29824C17.8478 2.3867 17.4518 2.5938 17.1343 2.896C16.8168 3.1982 16.5903 3.58339 16.4808 4.00782C16.4551 4.10721 16.4101 4.20058 16.3484 4.28258C16.2867 4.36459 16.2094 4.43364 16.121 4.48578C16.0326 4.53792 15.9347 4.57214 15.8331 4.58648C15.7315 4.60082 15.628 4.595 15.5286 4.56935C15.4292 4.5437 15.3359 4.49872 15.2539 4.43699C15.1718 4.37526 15.1028 4.29798 15.0507 4.20957C14.9985 4.12115 14.9643 4.02333 14.95 3.92169C14.9356 3.82006 14.9414 3.71659 14.9671 3.6172C15.1192 3.02864 15.4066 2.4837 15.8063 2.02575C16.2061 1.56779 16.7072 1.20946 17.2699 0.97926C17.8325 0.749062 18.4411 0.653353 19.0472 0.699748C19.6533 0.746143 20.2403 0.933362 20.7613 1.24651C21.2823 1.55965 21.7231 1.99008 22.0485 2.50354C22.3739 3.01701 22.575 3.59933 22.6358 4.20419C22.6965 4.80904 22.6153 5.41973 22.3985 5.98766C22.1817 6.55558 21.8354 7.06508 21.387 7.4756C22.4493 7.93555 23.3728 8.66545 24.0657 9.59278C24.1273 9.67507 24.172 9.76869 24.1973 9.86828C24.2226 9.96787 24.228 10.0715 24.2133 10.1732C24.1985 10.2749 24.1638 10.3726 24.1111 10.4609C24.0585 10.5492 23.989 10.6262 23.9065 10.6875ZM18.6448 16.7031C18.7014 16.7921 18.7393 16.8915 18.7564 16.9955C18.7735 17.0994 18.7694 17.2058 18.7443 17.3081C18.7193 17.4105 18.6738 17.5067 18.6105 17.591C18.5473 17.6753 18.4677 17.7459 18.3765 17.7986C18.2853 17.8514 18.1843 17.8851 18.0797 17.8978C17.9751 17.9105 17.869 17.9019 17.7678 17.8726C17.6666 17.8432 17.5724 17.7937 17.4909 17.727C17.4093 17.6603 17.3421 17.5777 17.2933 17.4844C16.8011 16.6511 16.1002 15.9604 15.2597 15.4807C14.4192 15.0009 13.4681 14.7486 12.5003 14.7486C11.5325 14.7486 10.5814 15.0009 9.74089 15.4807C8.90038 15.9604 8.19947 16.6511 7.70732 17.4844C7.65848 17.5777 7.59126 17.6603 7.50971 17.727C7.42815 17.7937 7.33394 17.8432 7.23274 17.8726C7.13155 17.9019 7.02546 17.9105 6.92087 17.8978C6.81627 17.8851 6.71532 17.8514 6.6241 17.7986C6.53288 17.7459 6.45326 17.6753 6.39005 17.591C6.32683 17.5067 6.28132 17.4105 6.25625 17.3081C6.23119 17.2058 6.22708 17.0994 6.24418 16.9955C6.26128 16.8915 6.29924 16.7921 6.35576 16.7031C7.11318 15.4017 8.26806 14.3776 9.65068 13.7813C8.87268 13.1856 8.30091 12.3611 8.01572 11.4237C7.73054 10.4862 7.74629 9.48301 8.06076 8.555C8.37522 7.62698 8.9726 6.82084 9.76892 6.24989C10.5652 5.67894 11.5204 5.37188 12.5003 5.37188C13.4801 5.37188 14.4354 5.67894 15.2317 6.24989C16.028 6.82084 16.6254 7.62698 16.9398 8.555C17.2543 9.48301 17.27 10.4862 16.9849 11.4237C16.6997 12.3611 16.1279 13.1856 15.3499 13.7813C16.7325 14.3776 17.8874 15.4017 18.6448 16.7031ZM12.5003 13.1875C13.1184 13.1875 13.7225 13.0042 14.2365 12.6609C14.7504 12.3175 15.1509 11.8294 15.3874 11.2584C15.6239 10.6874 15.6858 10.059 15.5652 9.45285C15.4447 8.84666 15.147 8.28984 14.71 7.8528C14.273 7.41576 13.7161 7.11814 13.11 6.99756C12.5038 6.87698 11.8754 6.93886 11.3044 7.17539C10.7334 7.41191 10.2453 7.81245 9.90195 8.32635C9.55857 8.84026 9.37529 9.44444 9.37529 10.0625C9.37529 10.8913 9.70453 11.6862 10.2906 12.2722C10.8766 12.8583 11.6715 13.1875 12.5003 13.1875ZM7.03154 7.71876C7.03154 7.51156 6.94923 7.31285 6.80272 7.16633C6.65621 7.01982 6.45749 6.93751 6.25029 6.93751C5.81194 6.93747 5.38239 6.8145 5.01042 6.58257C4.63845 6.35064 4.33898 6.01904 4.14603 5.62544C3.95307 5.23184 3.87437 4.79202 3.91885 4.35593C3.96333 3.91984 4.12921 3.50497 4.39766 3.15843C4.66611 2.8119 5.02637 2.54759 5.4375 2.39554C5.84863 2.24348 6.29417 2.20977 6.7235 2.29824C7.15283 2.3867 7.54875 2.5938 7.86628 2.896C8.18382 3.1982 8.41024 3.58339 8.51982 4.00782C8.57162 4.20855 8.70104 4.38048 8.8796 4.48578C9.05817 4.59109 9.27125 4.62115 9.47197 4.56935C9.6727 4.51755 9.84462 4.38813 9.94993 4.20957C10.0552 4.03101 10.0853 3.81792 10.0335 3.6172C9.88139 3.02864 9.59402 2.4837 9.19425 2.02575C8.79448 1.56779 8.29334 1.20946 7.73072 0.97926C7.16809 0.749062 6.5595 0.653353 5.95338 0.699748C5.34725 0.746143 4.76032 0.933362 4.23928 1.24651C3.71825 1.55965 3.27749 1.99008 2.95207 2.50354C2.62666 3.01701 2.42557 3.59933 2.36481 4.20419C2.30406 4.80904 2.3853 5.41973 2.60209 5.98766C2.81888 6.55558 3.16523 7.06508 3.61357 7.4756C2.55233 7.93599 1.6299 8.66585 0.937793 9.59278C0.876172 9.67486 0.83132 9.76827 0.805799 9.86768C0.780277 9.96709 0.774586 10.0706 0.78905 10.1722C0.803514 10.2738 0.837849 10.3715 0.890096 10.4599C0.942343 10.5482 1.01148 10.6254 1.09355 10.687C1.17563 10.7486 1.26904 10.7935 1.36845 10.819C1.46786 10.8445 1.57132 10.8502 1.67293 10.8358C1.77454 10.8213 1.87231 10.787 1.96065 10.7347C2.04899 10.6825 2.12617 10.6133 2.18779 10.5313C2.65868 9.89831 3.2716 9.38477 3.97721 9.03196C4.68282 8.67916 5.4614 8.49695 6.25029 8.50001C6.45749 8.50001 6.65621 8.4177 6.80272 8.27119C6.94923 8.12468 7.03154 7.92596 7.03154 7.71876Z"
                                        fill="white" fill-opacity="0.7"/>
                                </svg>
                            </div>
                            <span class="">{{ __('Students') }}</span>
                        </a>
                    </li>

                @endif
                {{--                @if ($authenticatedUser!='company'&&auth($authenticatedUser)->user()->role_id!=USER_ROLE_INSTRUCTOR)--}}
                {{--                    <li>--}}
                {{--                        <a href="#myEvent" data-bs-toggle="collapse" role="button" aria-controls="myEvent" class="d-flex align-items-center cg-10 {{ isset($showEvent) ? 'active' : 'collapsed' }}" aria-expanded="{{ isset($showEvent) ? 'true' : 'false' }}">--}}
                {{--                            <div class="d-flex">--}}
                {{--                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
                {{--                                    <rect x="3" y="6" width="18" height="15" rx="2" stroke="white" stroke-width="1.5"/>--}}
                {{--                                    <path d="M4 11H20" stroke="white" stroke-width="1.5" stroke-linecap="round"/>--}}
                {{--                                    <path d="M9 16H15" stroke="white" stroke-width="1.5" stroke-linecap="round"/>--}}
                {{--                                    <path d="M8 3L8 7" stroke="white" stroke-width="1.5" stroke-linecap="round"/>--}}
                {{--                                    <path d="M16 3L16 7" stroke="white" stroke-width="1.5" stroke-linecap="round"/>--}}
                {{--                                </svg>--}}
                {{--                            </div>--}}
                {{--                            <span class="">{{ __('Manage Events') }}</span>--}}
                {{--                        </a>--}}
                {{--                        <div class="collapse {{ $showEvent ?? '' }}" id="myEvent" data-bs-parent="#sidebarMenu">--}}
                {{--                            <ul class="zSidebar-submenu">--}}
                {{--                                @if ($authenticatedUser=='admin')--}}
                {{--                                    <li><a class="{{ $activeEventCategory ?? '' }}" href="{{ route($authenticatedUser.'.eventCategory.index') }}">{{ __('Event Category') }}</a></li>--}}
                {{--                                    <li><a class="{{ $activeEventCreate ?? '' }}" href="{{ route($authenticatedUser.'.event.create') }}">{{ __('Create Event') }}</a></li>--}}
                {{--                                    <li><a class="{{ $activeMyEvent ?? '' }}" href="{{ route($authenticatedUser.'.event.my-event') }}">{{ __('My Event') }}</a></li>--}}
                {{--                                @endif--}}
                {{--                                <li><a class="{{ $activeEventPending ?? '' }}" href="{{ route($authenticatedUser.'.event.pending') }}">{{ __('Pending Events') }}</a></li>--}}
                {{--                                <li><a class="{{ $activeAllEvent ?? '' }}" href="{{ route($authenticatedUser.'.event.all') }}">{{ __('All Events') }}</a></li>--}}
                {{--                            </ul>--}}
                {{--                        </div>--}}
                {{--                    </li>--}}
                {{--                @endif--}}
                {{--
                {{--                @if($authenticatedUser=='admin'&&auth('admin')->user()->role_id==USER_ROLE_INSTRUCTOR)--}}
                {{--                    <li>--}}
                {{--                        <a href="{{ route('admin.instructor.dashboard') }}" class="{{ $activeDashboard ?? '' }} d-flex align-items-center cg-10">--}}
                {{--                            <div class="d-flex">--}}
                {{--                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
                {{--                                    <path d="M6.88979 10.3929C6.14657 10.3929 5.62851 10.3924 5.22349 10.3635C4.82565 10.3351 4.59466 10.2819 4.4186 10.2051C3.89833 9.97813 3.48308 9.56288 3.25609 9.04261C3.17928 8.86655 3.12616 8.63556 3.09774 8.23773C3.0688 7.83271 3.06836 7.31465 3.06836 6.57143C3.06836 5.82821 3.0688 5.31015 3.09774 4.90513C3.12616 4.50729 3.17928 4.2763 3.25609 4.10024C3.48308 3.57997 3.89833 3.16473 4.4186 2.93773C4.59466 2.86092 4.82565 2.80781 5.22349 2.77938C5.6285 2.75045 6.14657 2.75 6.88979 2.75C7.63301 2.75 8.15107 2.75045 8.55609 2.77938C8.95392 2.80781 9.18491 2.86092 9.36097 2.93773C9.88124 3.16473 10.2965 3.57997 10.5235 4.10024C10.6003 4.2763 10.6534 4.50729 10.6818 4.90513C10.7108 5.31015 10.7112 5.82821 10.7112 6.57143C10.7112 7.31465 10.7108 7.83271 10.6818 8.23773C10.6534 8.63556 10.6003 8.86655 10.5235 9.04261C10.2965 9.56288 9.88124 9.97813 9.36097 10.2051C9.18491 10.2819 8.95392 10.3351 8.55609 10.3635C8.15107 10.3924 7.63301 10.3929 6.88979 10.3929Z" stroke="white" stroke-opacity="0.7" stroke-width="1.5"/>--}}
                {{--                                    <path d="M6.88979 21.25C6.14657 21.25 5.62851 21.2496 5.22349 21.2207C4.82565 21.1922 4.59466 21.1391 4.4186 21.0623C3.89833 20.8353 3.48308 20.4201 3.25609 19.8998C3.17928 19.7237 3.12616 19.4927 3.09774 19.0949C3.0688 18.6899 3.06836 18.1718 3.06836 17.4286C3.06836 16.6854 3.0688 16.1673 3.09774 15.7623C3.12616 15.3645 3.17928 15.1335 3.25609 14.9574C3.48308 14.4372 3.89833 14.0219 4.4186 13.7949C4.59466 13.7181 4.82565 13.665 5.22349 13.6366C5.6285 13.6076 6.14657 13.6072 6.88979 13.6072C7.63301 13.6072 8.15107 13.6076 8.55609 13.6366C8.95392 13.665 9.18491 13.7181 9.36097 13.7949C9.88124 14.0219 10.2965 14.4372 10.5235 14.9574C10.6003 15.1335 10.6534 15.3645 10.6818 15.7623C10.7108 16.1673 10.7112 16.6854 10.7112 17.4286C10.7112 18.1718 10.7108 18.6899 10.6818 19.0949C10.6534 19.4927 10.6003 19.7237 10.5235 19.8998C10.2965 20.4201 9.88124 20.8353 9.36097 21.0623C9.18491 21.1391 8.95392 21.1922 8.55609 21.2207C8.15107 21.2496 7.63301 21.25 6.88979 21.25Z" stroke="white" stroke-opacity="0.7" stroke-width="1.5"/>--}}
                {{--                                    <path d="M17.7472 10.3929C17.004 10.3929 16.4859 10.3924 16.0809 10.3635C15.6831 10.3351 15.4521 10.2819 15.276 10.2051C14.7558 9.97813 14.3405 9.56288 14.1135 9.04261C14.0367 8.86655 13.9836 8.63556 13.9552 8.23773C13.9262 7.83271 13.9258 7.31465 13.9258 6.57143C13.9258 5.82821 13.9262 5.31015 13.9552 4.90513C13.9836 4.50729 14.0367 4.2763 14.1135 4.10024C14.3405 3.57997 14.7558 3.16473 15.276 2.93773C15.4521 2.86092 15.6831 2.80781 16.0809 2.77938C16.4859 2.75045 17.004 2.75 17.7472 2.75C18.4904 2.75 19.0085 2.75045 19.4135 2.77938C19.8113 2.80781 20.0423 2.86092 20.2184 2.93773C20.7387 3.16473 21.1539 3.57997 21.3809 4.10024C21.4577 4.2763 21.5108 4.50729 21.5393 4.90513C21.5682 5.31015 21.5686 5.82821 21.5686 6.57143C21.5686 7.31465 21.5682 7.83271 21.5393 8.23773C21.5108 8.63556 21.4577 8.86655 21.3809 9.04261C21.1539 9.56288 20.7387 9.97813 20.2184 10.2051C20.0423 10.2819 19.8113 10.3351 19.4135 10.3635C19.0085 10.3924 18.4904 10.3929 17.7472 10.3929Z" stroke="white" stroke-opacity="0.7" stroke-width="1.5"/>--}}
                {{--                                    <path d="M17.7472 21.25C17.004 21.25 16.4859 21.2496 16.0809 21.2207C15.6831 21.1922 15.4521 21.1391 15.276 21.0623C14.7558 20.8353 14.3405 20.4201 14.1135 19.8998C14.0367 19.7237 13.9836 19.4927 13.9552 19.0949C13.9262 18.6899 13.9258 18.1718 13.9258 17.4286C13.9258 16.6854 13.9262 16.1673 13.9552 15.7623C13.9836 15.3645 14.0367 15.1335 14.1135 14.9574C14.3405 14.4372 14.7558 14.0219 15.276 13.7949C15.4521 13.7181 15.6831 13.665 16.0809 13.6366C16.4859 13.6076 17.004 13.6072 17.7472 13.6072C18.4904 13.6072 19.0085 13.6076 19.4135 13.6366C19.8113 13.665 20.0423 13.7181 20.2184 13.7949C20.7387 14.0219 21.1539 14.4372 21.3809 14.9574C21.4577 15.1335 21.5108 15.3645 21.5393 15.7623C21.5682 16.1673 21.5686 16.6854 21.5686 17.4286C21.5686 18.1718 21.5682 18.6899 21.5393 19.0949C21.5108 19.4927 21.4577 19.7237 21.3809 19.8998C21.1539 20.4201 20.7387 20.8353 20.2184 21.0623C20.0423 21.1391 19.8113 21.1922 19.4135 21.2207C19.0085 21.2496 18.4904 21.25 17.7472 21.25Z" stroke="white" stroke-opacity="0.7" stroke-width="1.5"/>--}}
                {{--                                </svg>--}}
                {{--                            </div>--}}
                {{--                            <span class="">{{ __('Dashboard') }}</span>--}}
                {{--                        </a>--}}
                {{--                    </li>--}}
                {{--                @endif--}}
                                @if($role!='alumni')
                                    <li>
                                        <a href="{{ route($role.'.profile.index') }}" class="{{ $activeProfile ?? '' }} d-flex align-items-center cg-10">
                                            <div class="d-flex">
                                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M19.7274 21.3923C19.2716 20.1165 18.2672 18.9892 16.8701 18.1851C15.4729 17.381 13.7611 16.9452 12 16.9452C10.2389 16.9452 8.52706 17.381 7.12991 18.1851C5.73276 18.9892 4.72839 20.1165 4.27259 21.3923" stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"/>
                                                    <circle cx="12" cy="8.94522" r="4" stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"/>
                                                </svg>
                                            </div>
                                            <span class="">{{ __('Profile') }}</span>
                                        </a>
                                    </li>
                                @endif
                <li>
                    <a class="d-flex align-items-center  cg-8" href="{{ route('auth.logout') }}" id="logout-link">
                        <div class="d-flex">
                            <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M9.49935 17.8333C7.28921 17.8333 5.1696 16.9553 3.60679 15.3925C2.04399 13.8297 1.16602 11.7101 1.16602 9.49996C1.16602 7.28982 2.04399 5.17021 3.60679 3.6074C5.1696 2.0446 7.28921 1.16663 9.49935 1.16663"
                                    stroke="#707070" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M7.41602 9.5H17.8327M17.8327 9.5L14.7077 6.375M17.8327 9.5L14.7077 12.625"
                                      stroke="#707070" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"
                                      stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <span>{{ __('Logout') }}</span>
                    </a>
                    <!-- Hidden Logout Form -->
                    <form id="logout-form" action="{{ route('auth.logout') }}" method="GET" style="display: none;">
                        @csrf
                    </form>
                </li>



            </ul>
        </div>
    </div>
@endif
