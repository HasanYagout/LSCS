@extends('super_admin.layouts.app')
@push('title')
    {{$pageTitle}}
@endpush

@section('content')
    @if(isAddonInstalled('ALUSAAS'))
    <div class="p-30">
        <div class="">
            <h4 class="fs-24 fw-500 lh-34 text-black pb-16">{{ __($pageTitle) }}</h4>
            <!-- Items -->
            <div class="row rg-30">
                <div class="col-md col-sm-12">
                    <div class="h-100 zNews-item-one">
                        <div class="content">
                            <h4 class="title">{{ __('Total User') }}</h4>
                            <div class="d-flex justify-content-between mt-20">
                                <h2 class="fs-5 fw-semibold mt-1 title">{{$totalUser}}</h2>
                                <div>
                                    <svg width="28" height="21" viewBox="0 0 25 18" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M23.9065 10.6875C23.8245 10.7491 23.7311 10.7939 23.6317 10.8193C23.5323 10.8448 23.4289 10.8504 23.3273 10.8359C23.2257 10.8214 23.128 10.787 23.0398 10.7348C22.9515 10.6825 22.8744 10.6133 22.8128 10.5313C22.3419 9.89831 21.729 9.38477 21.0234 9.03196C20.3178 8.67916 19.5392 8.49695 18.7503 8.50001C18.5967 8.5 18.4464 8.45469 18.3184 8.36975C18.1904 8.28481 18.0903 8.16402 18.0306 8.02247C17.99 7.92635 17.9691 7.82309 17.9691 7.71876C17.9691 7.61444 17.99 7.51117 18.0306 7.41505C18.0903 7.2735 18.1904 7.15271 18.3184 7.06777C18.4464 6.98283 18.5967 6.93753 18.7503 6.93751C19.1886 6.93747 19.6182 6.8145 19.9902 6.58257C20.3621 6.35064 20.6616 6.01904 20.8546 5.62544C21.0475 5.23184 21.1262 4.79202 21.0817 4.35593C21.0373 3.91984 20.8714 3.50497 20.6029 3.15843C20.3345 2.8119 19.9742 2.54759 19.5631 2.39554C19.152 2.24348 18.7064 2.20977 18.2771 2.29824C17.8478 2.3867 17.4518 2.5938 17.1343 2.896C16.8168 3.1982 16.5903 3.58339 16.4808 4.00782C16.4551 4.10721 16.4101 4.20058 16.3484 4.28258C16.2867 4.36459 16.2094 4.43364 16.121 4.48578C16.0326 4.53792 15.9347 4.57214 15.8331 4.58648C15.7315 4.60082 15.628 4.595 15.5286 4.56935C15.4292 4.5437 15.3359 4.49872 15.2539 4.43699C15.1718 4.37526 15.1028 4.29798 15.0507 4.20957C14.9985 4.12115 14.9643 4.02333 14.95 3.92169C14.9356 3.82006 14.9414 3.71659 14.9671 3.6172C15.1192 3.02864 15.4066 2.4837 15.8063 2.02575C16.2061 1.56779 16.7072 1.20946 17.2699 0.97926C17.8325 0.749062 18.4411 0.653353 19.0472 0.699748C19.6533 0.746143 20.2403 0.933362 20.7613 1.24651C21.2823 1.55965 21.7231 1.99008 22.0485 2.50354C22.3739 3.01701 22.575 3.59933 22.6358 4.20419C22.6965 4.80904 22.6153 5.41973 22.3985 5.98766C22.1817 6.55558 21.8354 7.06508 21.387 7.4756C22.4493 7.93555 23.3728 8.66545 24.0657 9.59278C24.1273 9.67507 24.172 9.76869 24.1973 9.86828C24.2226 9.96787 24.228 10.0715 24.2133 10.1732C24.1985 10.2749 24.1638 10.3726 24.1111 10.4609C24.0585 10.5492 23.989 10.6262 23.9065 10.6875ZM18.6448 16.7031C18.7014 16.7921 18.7393 16.8915 18.7564 16.9955C18.7735 17.0994 18.7694 17.2058 18.7443 17.3081C18.7193 17.4105 18.6738 17.5067 18.6105 17.591C18.5473 17.6753 18.4677 17.7459 18.3765 17.7986C18.2853 17.8514 18.1843 17.8851 18.0797 17.8978C17.9751 17.9105 17.869 17.9019 17.7678 17.8726C17.6666 17.8432 17.5724 17.7937 17.4909 17.727C17.4093 17.6603 17.3421 17.5777 17.2933 17.4844C16.8011 16.6511 16.1002 15.9604 15.2597 15.4807C14.4192 15.0009 13.4681 14.7486 12.5003 14.7486C11.5325 14.7486 10.5814 15.0009 9.74089 15.4807C8.90038 15.9604 8.19947 16.6511 7.70732 17.4844C7.65848 17.5777 7.59126 17.6603 7.50971 17.727C7.42815 17.7937 7.33394 17.8432 7.23274 17.8726C7.13155 17.9019 7.02546 17.9105 6.92087 17.8978C6.81627 17.8851 6.71532 17.8514 6.6241 17.7986C6.53288 17.7459 6.45326 17.6753 6.39005 17.591C6.32683 17.5067 6.28132 17.4105 6.25625 17.3081C6.23119 17.2058 6.22708 17.0994 6.24418 16.9955C6.26128 16.8915 6.29924 16.7921 6.35576 16.7031C7.11318 15.4017 8.26806 14.3776 9.65068 13.7813C8.87268 13.1856 8.30091 12.3611 8.01572 11.4237C7.73054 10.4862 7.74629 9.48301 8.06076 8.555C8.37522 7.62698 8.9726 6.82084 9.76892 6.24989C10.5652 5.67894 11.5204 5.37188 12.5003 5.37188C13.4801 5.37188 14.4354 5.67894 15.2317 6.24989C16.028 6.82084 16.6254 7.62698 16.9398 8.555C17.2543 9.48301 17.27 10.4862 16.9849 11.4237C16.6997 12.3611 16.1279 13.1856 15.3499 13.7813C16.7325 14.3776 17.8874 15.4017 18.6448 16.7031ZM12.5003 13.1875C13.1184 13.1875 13.7225 13.0042 14.2365 12.6609C14.7504 12.3175 15.1509 11.8294 15.3874 11.2584C15.6239 10.6874 15.6858 10.059 15.5652 9.45285C15.4447 8.84666 15.147 8.28984 14.71 7.8528C14.273 7.41576 13.7161 7.11814 13.11 6.99756C12.5038 6.87698 11.8754 6.93886 11.3044 7.17539C10.7334 7.41191 10.2453 7.81245 9.90195 8.32635C9.55857 8.84026 9.37529 9.44444 9.37529 10.0625C9.37529 10.8913 9.70453 11.6862 10.2906 12.2722C10.8766 12.8583 11.6715 13.1875 12.5003 13.1875ZM7.03154 7.71876C7.03154 7.51156 6.94923 7.31285 6.80272 7.16633C6.65621 7.01982 6.45749 6.93751 6.25029 6.93751C5.81194 6.93747 5.38239 6.8145 5.01042 6.58257C4.63845 6.35064 4.33898 6.01904 4.14603 5.62544C3.95307 5.23184 3.87437 4.79202 3.91885 4.35593C3.96333 3.91984 4.12921 3.50497 4.39766 3.15843C4.66611 2.8119 5.02637 2.54759 5.4375 2.39554C5.84863 2.24348 6.29417 2.20977 6.7235 2.29824C7.15283 2.3867 7.54875 2.5938 7.86628 2.896C8.18382 3.1982 8.41024 3.58339 8.51982 4.00782C8.57162 4.20855 8.70104 4.38048 8.8796 4.48578C9.05817 4.59109 9.27125 4.62115 9.47197 4.56935C9.6727 4.51755 9.84462 4.38813 9.94993 4.20957C10.0552 4.03101 10.0853 3.81792 10.0335 3.6172C9.88139 3.02864 9.59402 2.4837 9.19425 2.02575C8.79448 1.56779 8.29334 1.20946 7.73072 0.97926C7.16809 0.749062 6.5595 0.653353 5.95338 0.699748C5.34725 0.746143 4.76032 0.933362 4.23928 1.24651C3.71825 1.55965 3.27749 1.99008 2.95207 2.50354C2.62666 3.01701 2.42557 3.59933 2.36481 4.20419C2.30406 4.80904 2.3853 5.41973 2.60209 5.98766C2.81888 6.55558 3.16523 7.06508 3.61357 7.4756C2.55233 7.93599 1.6299 8.66585 0.937793 9.59278C0.876172 9.67486 0.83132 9.76827 0.805799 9.86768C0.780277 9.96709 0.774586 10.0706 0.78905 10.1722C0.803514 10.2738 0.837849 10.3715 0.890096 10.4599C0.942343 10.5482 1.01148 10.6254 1.09355 10.687C1.17563 10.7486 1.26904 10.7935 1.36845 10.819C1.46786 10.8445 1.57132 10.8502 1.67293 10.8358C1.77454 10.8213 1.87231 10.787 1.96065 10.7347C2.04899 10.6825 2.12617 10.6133 2.18779 10.5313C2.65868 9.89831 3.2716 9.38477 3.97721 9.03196C4.68282 8.67916 5.4614 8.49695 6.25029 8.50001C6.45749 8.50001 6.65621 8.4177 6.80272 8.27119C6.94923 8.12468 7.03154 7.92596 7.03154 7.71876Z"
                                            fill="black" fill-opacity="0.7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md col-sm-12">
                    <div class="h-100 zNews-item-one">
                        <div class="content">
                            <h4 class="title">{{ __('Active Package') }}</h4>
                            <div class="d-flex justify-content-between mt-20">
                                <h2 class="fs-5 fw-semibold mt-1 title">{{$activePackage}}</h2>
                                <div class="d-flex">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M20.4906 9.39822C20.4906 14.0906 16.6867 17.8945 11.9943 17.8945C7.30197 17.8945 3.49805 14.0906 3.49805 9.39822C3.49805 4.70585 7.30197 0.901924 11.9943 0.901924C16.6867 0.901924 20.4906 4.70585 20.4906 9.39822Z"
                                            stroke="black" stroke-opacity="0.7" stroke-width="1.5"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"/>
                                        <path
                                            d="M4.63477 13.5656L0.856444 20.1099L4.93902 19.016L6.03294 23.0985L9.3112 17.4204"
                                            stroke="black" stroke-opacity="0.7" stroke-width="1.5"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"/>
                                        <path
                                            d="M19.3652 13.5656L23.1436 20.1099L19.061 19.016L17.9671 23.0985L14.6888 17.4204"
                                            stroke="black" stroke-opacity="0.7" stroke-width="1.5"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"/>
                                        <path
                                            d="M16.9679 14.0017C16.6749 13.1815 16.0292 12.4568 15.1311 11.9399C14.2329 11.423 13.1324 11.1429 12.0003 11.1429C10.8682 11.1429 9.76768 11.423 8.86951 11.9399C7.97134 12.4568 7.32568 13.1815 7.03266 14.0017"
                                            stroke="black" stroke-opacity="0.7" stroke-width="1.5"
                                            stroke-linecap="round"/>
                                        <circle cx="11.9972" cy="6" r="2.57143" stroke="black"
                                                stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md col-sm-12">
                    <div class="h-100 zNews-item-one">
                        <div class="content">
                            <h4 class="title">{{ __('Current Subscriptions') }}</h4>
                            <div class="d-flex justify-content-between mt-20">
                                <h2 class="fs-5 fw-semibold mt-1 title">{{ $totalCurrentSubscription }}</h2>
                                <div class="d-flex">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <rect x="3" y="6" width="18" height="15" rx="2"
                                              stroke="black" stroke-width="1.5">
                                        </rect>
                                        <path d="M4 11H20" stroke="black" stroke-width="1.5" stroke-linecap="round">
                                        </path>
                                        <path d="M9 16H15" stroke="black" stroke-width="1.5" stroke-linecap="round">
                                        </path>
                                        <path d="M8 3L8 7" stroke="black" stroke-width="1.5" stroke-linecap="round">
                                        </path>
                                        <path d="M16 3L16 7" stroke="black" stroke-width="1.5" stroke-linecap="round">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md col-sm-12">
                    <div class="h-100 zNews-item-one">
                        <div class="content">
                            <div class="d-flex items-center justify-content-between w-full">
                                <div class="d-flex justify-content-between w-100">
                                    <h4 class="title">{{ __('Monthly Revenue') }}</h4>
                                    <span class="fs-12">({{ now()->format('F') }})</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-20">
                                <h2 class="fs-5 fw-semibold mt-1 title">{{showPrice($monthlyRevenue)}}</h2>
                                <div class="d-flex">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M20.4906 9.39822C20.4906 14.0906 16.6867 17.8945 11.9943 17.8945C7.30197 17.8945 3.49805 14.0906 3.49805 9.39822C3.49805 4.70585 7.30197 0.901924 11.9943 0.901924C16.6867 0.901924 20.4906 4.70585 20.4906 9.39822Z"
                                            stroke="black" stroke-opacity="0.7" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"/>
                                        <path
                                            d="M4.63477 13.5656L0.856444 20.1099L4.93902 19.016L6.03294 23.0985L9.3112 17.4204"
                                            stroke="black" stroke-opacity="0.7" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"/>
                                        <path
                                            d="M19.3652 13.5656L23.1436 20.1099L19.061 19.016L17.9671 23.0985L14.6888 17.4204"
                                            stroke="black" stroke-opacity="0.7" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"/>
                                        <path
                                            d="M16.9679 14.0017C16.6749 13.1815 16.0292 12.4568 15.1311 11.9399C14.2329 11.423 13.1324 11.1429 12.0003 11.1429C10.8682 11.1429 9.76768 11.423 8.86951 11.9399C7.97134 12.4568 7.32568 13.1815 7.03266 14.0017"
                                            stroke="black" stroke-opacity="0.7" stroke-width="1.5"
                                            stroke-linecap="round"/>
                                        <circle cx="11.9972" cy="6" r="2.57143" stroke="black"
                                                stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-30">
                <div class="row rg-30">
                    <div class="col-md-12">
                        <div class="zNews-item-one">
                            <div class="content">
                                <h4 class="title mb-3">{{ __('Monthly Subscription Summery') }}</h4>
                                <div id="monthlyOrderSummary"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="monthlyOrderSummaryData" value="{{$monthlyOrderSummary['chartData']}}">
    <input type="hidden" id="monthlyOrderSummaryCategory" value="{{$monthlyOrderSummary['chartCategory']}}">
    @else
        <div class="p-30">
            <div class="">
                <h4 class="fs-24 fw-500 lh-34 text-black pb-16">{{ __($pageTitle) }}</h4>
                <!-- Items -->
                <div class="row rg-30">
                    <div class="col-md col-sm-12">
                        <div class="h-100 zNews-item-one">
                            <div class="content">
                                <h4 class="title">{{ __('Total Alumni') }}</h4>
                                <div class="d-flex justify-content-between mt-20">
                                    <h2 class="fs-5 fw-semibold mt-1 title">{{ $totalAlumni }}</h2>
                                    <div>
                                        <svg width="28" height="21" viewBox="0 0 25 18" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M23.9065 10.6875C23.8245 10.7491 23.7311 10.7939 23.6317 10.8193C23.5323 10.8448 23.4289 10.8504 23.3273 10.8359C23.2257 10.8214 23.128 10.787 23.0398 10.7348C22.9515 10.6825 22.8744 10.6133 22.8128 10.5313C22.3419 9.89831 21.729 9.38477 21.0234 9.03196C20.3178 8.67916 19.5392 8.49695 18.7503 8.50001C18.5967 8.5 18.4464 8.45469 18.3184 8.36975C18.1904 8.28481 18.0903 8.16402 18.0306 8.02247C17.99 7.92635 17.9691 7.82309 17.9691 7.71876C17.9691 7.61444 17.99 7.51117 18.0306 7.41505C18.0903 7.2735 18.1904 7.15271 18.3184 7.06777C18.4464 6.98283 18.5967 6.93753 18.7503 6.93751C19.1886 6.93747 19.6182 6.8145 19.9902 6.58257C20.3621 6.35064 20.6616 6.01904 20.8546 5.62544C21.0475 5.23184 21.1262 4.79202 21.0817 4.35593C21.0373 3.91984 20.8714 3.50497 20.6029 3.15843C20.3345 2.8119 19.9742 2.54759 19.5631 2.39554C19.152 2.24348 18.7064 2.20977 18.2771 2.29824C17.8478 2.3867 17.4518 2.5938 17.1343 2.896C16.8168 3.1982 16.5903 3.58339 16.4808 4.00782C16.4551 4.10721 16.4101 4.20058 16.3484 4.28258C16.2867 4.36459 16.2094 4.43364 16.121 4.48578C16.0326 4.53792 15.9347 4.57214 15.8331 4.58648C15.7315 4.60082 15.628 4.595 15.5286 4.56935C15.4292 4.5437 15.3359 4.49872 15.2539 4.43699C15.1718 4.37526 15.1028 4.29798 15.0507 4.20957C14.9985 4.12115 14.9643 4.02333 14.95 3.92169C14.9356 3.82006 14.9414 3.71659 14.9671 3.6172C15.1192 3.02864 15.4066 2.4837 15.8063 2.02575C16.2061 1.56779 16.7072 1.20946 17.2699 0.97926C17.8325 0.749062 18.4411 0.653353 19.0472 0.699748C19.6533 0.746143 20.2403 0.933362 20.7613 1.24651C21.2823 1.55965 21.7231 1.99008 22.0485 2.50354C22.3739 3.01701 22.575 3.59933 22.6358 4.20419C22.6965 4.80904 22.6153 5.41973 22.3985 5.98766C22.1817 6.55558 21.8354 7.06508 21.387 7.4756C22.4493 7.93555 23.3728 8.66545 24.0657 9.59278C24.1273 9.67507 24.172 9.76869 24.1973 9.86828C24.2226 9.96787 24.228 10.0715 24.2133 10.1732C24.1985 10.2749 24.1638 10.3726 24.1111 10.4609C24.0585 10.5492 23.989 10.6262 23.9065 10.6875ZM18.6448 16.7031C18.7014 16.7921 18.7393 16.8915 18.7564 16.9955C18.7735 17.0994 18.7694 17.2058 18.7443 17.3081C18.7193 17.4105 18.6738 17.5067 18.6105 17.591C18.5473 17.6753 18.4677 17.7459 18.3765 17.7986C18.2853 17.8514 18.1843 17.8851 18.0797 17.8978C17.9751 17.9105 17.869 17.9019 17.7678 17.8726C17.6666 17.8432 17.5724 17.7937 17.4909 17.727C17.4093 17.6603 17.3421 17.5777 17.2933 17.4844C16.8011 16.6511 16.1002 15.9604 15.2597 15.4807C14.4192 15.0009 13.4681 14.7486 12.5003 14.7486C11.5325 14.7486 10.5814 15.0009 9.74089 15.4807C8.90038 15.9604 8.19947 16.6511 7.70732 17.4844C7.65848 17.5777 7.59126 17.6603 7.50971 17.727C7.42815 17.7937 7.33394 17.8432 7.23274 17.8726C7.13155 17.9019 7.02546 17.9105 6.92087 17.8978C6.81627 17.8851 6.71532 17.8514 6.6241 17.7986C6.53288 17.7459 6.45326 17.6753 6.39005 17.591C6.32683 17.5067 6.28132 17.4105 6.25625 17.3081C6.23119 17.2058 6.22708 17.0994 6.24418 16.9955C6.26128 16.8915 6.29924 16.7921 6.35576 16.7031C7.11318 15.4017 8.26806 14.3776 9.65068 13.7813C8.87268 13.1856 8.30091 12.3611 8.01572 11.4237C7.73054 10.4862 7.74629 9.48301 8.06076 8.555C8.37522 7.62698 8.9726 6.82084 9.76892 6.24989C10.5652 5.67894 11.5204 5.37188 12.5003 5.37188C13.4801 5.37188 14.4354 5.67894 15.2317 6.24989C16.028 6.82084 16.6254 7.62698 16.9398 8.555C17.2543 9.48301 17.27 10.4862 16.9849 11.4237C16.6997 12.3611 16.1279 13.1856 15.3499 13.7813C16.7325 14.3776 17.8874 15.4017 18.6448 16.7031ZM12.5003 13.1875C13.1184 13.1875 13.7225 13.0042 14.2365 12.6609C14.7504 12.3175 15.1509 11.8294 15.3874 11.2584C15.6239 10.6874 15.6858 10.059 15.5652 9.45285C15.4447 8.84666 15.147 8.28984 14.71 7.8528C14.273 7.41576 13.7161 7.11814 13.11 6.99756C12.5038 6.87698 11.8754 6.93886 11.3044 7.17539C10.7334 7.41191 10.2453 7.81245 9.90195 8.32635C9.55857 8.84026 9.37529 9.44444 9.37529 10.0625C9.37529 10.8913 9.70453 11.6862 10.2906 12.2722C10.8766 12.8583 11.6715 13.1875 12.5003 13.1875ZM7.03154 7.71876C7.03154 7.51156 6.94923 7.31285 6.80272 7.16633C6.65621 7.01982 6.45749 6.93751 6.25029 6.93751C5.81194 6.93747 5.38239 6.8145 5.01042 6.58257C4.63845 6.35064 4.33898 6.01904 4.14603 5.62544C3.95307 5.23184 3.87437 4.79202 3.91885 4.35593C3.96333 3.91984 4.12921 3.50497 4.39766 3.15843C4.66611 2.8119 5.02637 2.54759 5.4375 2.39554C5.84863 2.24348 6.29417 2.20977 6.7235 2.29824C7.15283 2.3867 7.54875 2.5938 7.86628 2.896C8.18382 3.1982 8.41024 3.58339 8.51982 4.00782C8.57162 4.20855 8.70104 4.38048 8.8796 4.48578C9.05817 4.59109 9.27125 4.62115 9.47197 4.56935C9.6727 4.51755 9.84462 4.38813 9.94993 4.20957C10.0552 4.03101 10.0853 3.81792 10.0335 3.6172C9.88139 3.02864 9.59402 2.4837 9.19425 2.02575C8.79448 1.56779 8.29334 1.20946 7.73072 0.97926C7.16809 0.749062 6.5595 0.653353 5.95338 0.699748C5.34725 0.746143 4.76032 0.933362 4.23928 1.24651C3.71825 1.55965 3.27749 1.99008 2.95207 2.50354C2.62666 3.01701 2.42557 3.59933 2.36481 4.20419C2.30406 4.80904 2.3853 5.41973 2.60209 5.98766C2.81888 6.55558 3.16523 7.06508 3.61357 7.4756C2.55233 7.93599 1.6299 8.66585 0.937793 9.59278C0.876172 9.67486 0.83132 9.76827 0.805799 9.86768C0.780277 9.96709 0.774586 10.0706 0.78905 10.1722C0.803514 10.2738 0.837849 10.3715 0.890096 10.4599C0.942343 10.5482 1.01148 10.6254 1.09355 10.687C1.17563 10.7486 1.26904 10.7935 1.36845 10.819C1.46786 10.8445 1.57132 10.8502 1.67293 10.8358C1.77454 10.8213 1.87231 10.787 1.96065 10.7347C2.04899 10.6825 2.12617 10.6133 2.18779 10.5313C2.65868 9.89831 3.2716 9.38477 3.97721 9.03196C4.68282 8.67916 5.4614 8.49695 6.25029 8.50001C6.45749 8.50001 6.65621 8.4177 6.80272 8.27119C6.94923 8.12468 7.03154 7.92596 7.03154 7.71876Z"
                                                fill="black" fill-opacity="0.7"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md col-sm-12">
                        <div class="h-100 zNews-item-one">
                            <div class="content">
                                <h4 class="title">{{ __('Current Members') }}</h4>
                                <div class="d-flex justify-content-between mt-20">
                                    <h2 class="fs-5 fw-semibold mt-1 title">{{ $currentMember }}</h2>
                                    <div class="d-flex">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M20.4906 9.39822C20.4906 14.0906 16.6867 17.8945 11.9943 17.8945C7.30197 17.8945 3.49805 14.0906 3.49805 9.39822C3.49805 4.70585 7.30197 0.901924 11.9943 0.901924C16.6867 0.901924 20.4906 4.70585 20.4906 9.39822Z"
                                                stroke="black" stroke-opacity="0.7" stroke-width="1.5"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                            <path
                                                d="M4.63477 13.5656L0.856444 20.1099L4.93902 19.016L6.03294 23.0985L9.3112 17.4204"
                                                stroke="black" stroke-opacity="0.7" stroke-width="1.5"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                            <path
                                                d="M19.3652 13.5656L23.1436 20.1099L19.061 19.016L17.9671 23.0985L14.6888 17.4204"
                                                stroke="black" stroke-opacity="0.7" stroke-width="1.5"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                            <path
                                                d="M16.9679 14.0017C16.6749 13.1815 16.0292 12.4568 15.1311 11.9399C14.2329 11.423 13.1324 11.1429 12.0003 11.1429C10.8682 11.1429 9.76768 11.423 8.86951 11.9399C7.97134 12.4568 7.32568 13.1815 7.03266 14.0017"
                                                stroke="black" stroke-opacity="0.7" stroke-width="1.5"
                                                stroke-linecap="round"/>
                                            <circle cx="11.9972" cy="6" r="2.57143" stroke="black"
                                                    stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md col-sm-12">
                        <div class="h-100 zNews-item-one">
                            <div class="content">
                                <h4 class="title">{{ __('Upcoming Event') }}</h4>
                                <div class="d-flex justify-content-between mt-20">
                                    <h2 class="fs-5 fw-semibold mt-1 title">{{ $totalUpcomingEvent }}</h2>
                                    <div class="d-flex">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <rect x="3" y="6" width="18" height="15" rx="2"
                                                  stroke="black" stroke-width="1.5">
                                            </rect>
                                            <path d="M4 11H20" stroke="black" stroke-width="1.5" stroke-linecap="round">
                                            </path>
                                            <path d="M9 16H15" stroke="black" stroke-width="1.5" stroke-linecap="round">
                                            </path>
                                            <path d="M8 3L8 7" stroke="black" stroke-width="1.5" stroke-linecap="round">
                                            </path>
                                            <path d="M16 3L16 7" stroke="black" stroke-width="1.5" stroke-linecap="round">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md col-sm-12">
                        <div class="h-100 zNews-item-one">
                            <div class="content">
                                <div class="d-flex items-center justify-content-between w-full">
                                    <h4 class="title">{{ __('Member') }}</h4>
                                    <span class="fs-12">{{ now()->format('F') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mt-20">
                                    <h2 class="fs-5 fw-semibold mt-1 title">{{ $memberThisMonth }}</h2>
                                    <div class="d-flex">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M20.4906 9.39822C20.4906 14.0906 16.6867 17.8945 11.9943 17.8945C7.30197 17.8945 3.49805 14.0906 3.49805 9.39822C3.49805 4.70585 7.30197 0.901924 11.9943 0.901924C16.6867 0.901924 20.4906 4.70585 20.4906 9.39822Z"
                                                stroke="black" stroke-opacity="0.7" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round"/>
                                            <path
                                                d="M4.63477 13.5656L0.856444 20.1099L4.93902 19.016L6.03294 23.0985L9.3112 17.4204"
                                                stroke="black" stroke-opacity="0.7" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round"/>
                                            <path
                                                d="M19.3652 13.5656L23.1436 20.1099L19.061 19.016L17.9671 23.0985L14.6888 17.4204"
                                                stroke="black" stroke-opacity="0.7" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round"/>
                                            <path
                                                d="M16.9679 14.0017C16.6749 13.1815 16.0292 12.4568 15.1311 11.9399C14.2329 11.423 13.1324 11.1429 12.0003 11.1429C10.8682 11.1429 9.76768 11.423 8.86951 11.9399C7.97134 12.4568 7.32568 13.1815 7.03266 14.0017"
                                                stroke="black" stroke-opacity="0.7" stroke-width="1.5"
                                                stroke-linecap="round"/>
                                            <circle cx="11.9972" cy="6" r="2.57143" stroke="black"
                                                    stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md col-sm-12">
                        <div class="h-100 zNews-item-one">
                            <div class="content">
                                <div class="d-flex items-center justify-content-between w-full">
                                    <h4 class="title">{{ __('Transaction') }}</h4>
                                    <span class="fs-12">{{ now()->format('F') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mt-20">
                                    <h2 class="fs-5 fw-semibold mt-1 title">{{ showPrice($transactionThisMonth) }}</h2>
                                    <div class="d-flex">
                                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <rect x="3.31836" y="6.94522" width="18" height="12"
                                                  rx="2" stroke="black" stroke-opacity="0.7" stroke-width="1.5">
                                            </rect>
                                            <path d="M5.31836 9.94522H8.31836" stroke="black" stroke-opacity="0.7"
                                                  stroke-width="1.5" stroke-linecap="round"></path>
                                            <path d="M16.3184 15.9452H19.3184" stroke="black" stroke-opacity="0.7"
                                                  stroke-width="1.5" stroke-linecap="round"></path>
                                            <circle cx="12.3184" cy="12.9452" r="2" stroke="black"
                                                    stroke-opacity="0.7" stroke-width="1.5"></circle>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-30">
                    <div class="row rg-30">
                        <div class="col-md-6">
                            <div class="zNews-item-one">
                                <div class="content">
                                    <h4 class="title mb-3">{{ __('Payment Summary') }}</h4>
                                    <div id="payment-chart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="zNews-item-one">
                                <div class="content">
                                    <h4 class="title mb-3">{{ __('Event Ticket Summary') }}</h4>
                                    <div id="event-ticket-chart" class="w-100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="day-list" value="{{ $dayList }}">
                <input type="hidden" id="price-list" value="{{ $chartPrice }}">
                <input type="hidden" id="total-ticket-list" value="{{ $totalTickets }}">
                <input type="hidden" id="event-name-list" value="{{ $eventNames }}">

                <div class="pt-30">
                    {{-- <h4 class="fs-24 fw-500 lh-34 text-black pb-16">My Job Post</h4> --}}
                    <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
                        <!-- Table -->
                        <h4 class="title mb-3">{{ __('Latest Transaction Summary') }}</h4>
                        <div class="table-responsive zTable-responsive">
                            <table class="table zTable" id="transactionDataTable">
                                <thead>
                                <tr>
                                    <th scope="col">
                                        <div>{{ __('Name') }}</div>
                                    </th>
                                    <th scope="col">
                                        <div>{{ __('Purpose') }}</div>
                                    </th>
                                    <th scope="col">
                                        <div>{{ __('Transaction ID') }}</div>
                                    </th>
                                    <th scope="col">
                                        <div>{{ __('Payment Method') }}</div>
                                    </th>
                                    <th scope="col">
                                        <div>{{ __('Date and Time') }}</div>
                                    </th>
                                    <th scope="col">
                                        <div>{{ __('Amount') }}</div>
                                    </th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="transaction-route" value="{{ route('super_admin.dashboard') }}">
    @endif
@endsection
@if(isAddonInstalled('ALUSAAS'))
@push('script')
    <script src="{{ asset('common/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('super_admin/custom-js/dashboard.js') }}"></script>
@endpush
@else
@push('script')
    <script src="{{ asset('common/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('admin/js/charts.js') }}"></script>
    <script src="{{ asset('admin/js/admin-dashboard.js') }}?ver={{ env('VERSION' ,0) }}"></script>
@endpush
@endif
