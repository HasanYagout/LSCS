<!-- Start Join Community -->
<section>
    <div class="continer">
        <div class="join-community bg-secondary-color" data-background="{{ asset('public/frontend/images/community-bg.png') }}">
            <div class="left max-w-498">
                <h4 class="fs-36 fw-600 lh-36 text-black-color pb-15">{{ __(getOption('join_our_community_title')) }}
                </h4>
                <p class="fs-18 fw-400 lh-28 text-color1">{!! __(getOption('join_our_community_text')) !!}</p>
            </div>
            </div>
        </div>
    </section>
    <!-- End Join Community -->
    <!-- Start Footer -->
    <footer class="footer-section bg-dark">
        <div class="container">
            <div class="footer-top">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-10">
{{--                        <div class="max-w-193 pb-15"><img src="{{ getSettingImage('app_logo') }}"--}}
{{--                                alt="{{ getOption('app_name') }}" /></div>--}}
                        <p class="fs-18 fw-500 lh-28 text-white pb-32 pr-lg-24">{!! nl2br(getOption('footer_left_text')) !!}</p>
                        <ul class="d-flex align-items-center flex-wrap g-7">
                            <li>
                                <a target="__blank" href="{{ getOption('facebook_url') }}"
                                    class="d-flex justify-content-center align-items-center w-50 h-50 rounded-circle bg-white hover-bg-color-primary"><img
                                        src="{{ asset('public/frontend/images/icon/facebook.svg') }}" alt="" /></a>
                            </li>
                            <li>
                                <a target="__blank" href="{{ getOption('twitter_url') }}"
                                    class="d-flex justify-content-center align-items-center w-50 h-50 rounded-circle bg-white hover-bg-color-primary"><img
                                        src="{{ asset('public/frontend/images/icon/twitter.svg') }}" alt="" /></a>
                            </li>
                            <li>
                                <a target="__blank" href="{{ getOption('linkedin_url') }}"
                                    class="d-flex justify-content-center align-items-center w-50 h-50 rounded-circle bg-white hover-bg-color-primary"><img
                                        src="{{ asset('public/frontend/images/icon/linkedin.svg') }}" alt="" /></a>
                            </li>
                            <li>
                                <a target="__blank" href="{{ getOption('instagram_url') }}"
                                    class="d-flex justify-content-center align-items-center w-50 h-50 rounded-circle bg-white hover-bg-color-primary"><img
                                        src="{{ asset('public/frontend/images/icon/instagram.svg') }}" alt="" /></a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-4 offset-md-1 offset-lg-0 col-md-5 col-sm-10">
                        <div class="pl-xl-75">
                            <h4 class="fs-24 fw-600 lh-28 text-white pb-25">{{ __('Useful Link') }}</h4>
                            <ul class="footer-nav">
                                <li><a href="{{ route('our.notice') }}"
                                        class="fs-18 fw-500 lh-28 text-white-80 hover-color-white">{{__('Notice')}}</a></li>
                                <li><a href="{{ route('privacy-policy') }}"
                                        class="fs-18 fw-500 lh-28 text-white-80 hover-color-white">{{ __('Privacy
                                                                                                                                                                                                                                        Policy') }}</a>
                                </li>
                                <li><a href="{{ route('all.event') }}"
                                        class="fs-18 fw-500 lh-28 text-white-80 hover-color-white">{{__('Events')}}</a></li>
                                <li><a href="{{ route('cookie-policy') }}"
                                        class="fs-18 fw-500 lh-28 text-white-80 hover-color-white">{{ __('Cookie
                                                                                                                                                                                                                                        Policy') }}</a>
                                </li>
                                <li><a href="{{ route('all.stories') }}"
                                        class="fs-18 fw-500 lh-28 text-white-80 hover-color-white">{{__('Stories')}}</a>
                                <li>
                                    <a href="{{ route('terms-and-conditions') }}" class="fs-18 fw-500 lh-28 text-white-80 hover-color-white">
                                        {{ __('Terms & Conditions') }}
                                    </a>
                                </li>
                                <li><a href="{{ route('our.news') }}"
                                        class="fs-18 fw-500 lh-28 text-white-80 hover-color-white">{{__('News')}}</a>
                                </li>

                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="footer-bottom">
                <p class="fs-13 fw-400 lh-20 text-white text-center">{!! nl2br(getOption('app_copyright')) !!}</p>
            </div>
        </div>
    </footer>
    <!-- End Footer -->
