@extends('layouts.app')

@push('title')
    {{ $title }}
@endpush

@section('content')
    <!-- Page content area start -->
    <div class="p-30">
        <div class="">
            <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
                <!-- Search & Filter -->
                <div class="pb-30">
                    <!-- Search & Filter Button -->
                    <div class="d-flex align-items-center cg-5">
                        <!-- Search Field -->
                        <!-- Filter Button -->

                    </div>
                </div>
                <!-- Table -->
                <input type="hidden" id="alumni-list-advance-filter-route"
                    value="{{ route('admin.alumni.list-search-with-filter') }}">
                <input type="hidden" id="alumni-status-update-route"
                    value="{{ route('admin.alumni.change-alumni-status') }}">
                <div class="table-responsive zTable-responsive">
                    <table class="table zTable" id="alumni-all-list-filter">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <div>{{ __('Full Name') }}</div>
                                </th>
                                <th scope="col" class="min-w-100">
                                    <div>{{ __('Batch') }}</div>
                                </th>
                                <th scope="col">
                                    <div>{{ __('Passing Year') }}</div>
                                </th>
                                <th scope="col">
                                    <div>{{ __('Location') }}</div>
                                </th>
                                <th class="min-w-150 w-110" scope="col">
                                    <div>{{ __('Change status') }}</div>
                                </th>
                                <th scope="col" class="text-center max-w-150 ">
                                    <div>{{ __('Action') }}</div>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Page content area End -->

    <!-- Phone Number Modal -->
    <div class="modal fade zModalTwo" id="alumniPhoneNo" tabindex="-1" aria-labelledby="alumniPhoneNoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content zModalTwo-content">
                <div class="modal-body zModalTwo-body">
                    <div class="text-center py-30">
                        <p class="fs-14 fw-500 lh-18 text-707070 pb-10">{{ __('Contact with') }} <span
                                class="contact-name"></span></p>
                        <h4 class="fs-32 fw-500 lh-42 text-black show-phone"></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Facebook Modal -->
    <div class="modal fade zModalTwo" id="alumniEmail" tabindex="-1" aria-labelledby="alumniFacebookLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content zModalTwo-content">
                <div class="modal-body zModalTwo-body">
                    <div class="text-center py-30">
                        <p class="fs-14 fw-500 lh-18 text-707070 pb-10">{{ __('Contact with') }} <span
                                class="contact-name"></span></p>
                        <h4 class="fs-32 fw-500 lh-42 text-black show-email"></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="search-section">
        <div class="collapse" id="collapseExample">
            <div class="alumniFilter">
                <h4 class="fs-18 fw-500 lh-38 text-1b1c17 pb-10">{{__('Filter your search')}}</h4>
                <div class="filterOptions">
                    <div class="item">
                        <div class="primary-form-group">
                            <div class="primary-form-group-wrap">
                                <label for="Department" class="form-label">{{__('Department')}}</label>
                                <select class="sf-select-without-search primary-form-control" name='department'
                                    id='department'>
                                    <option selected="" value=0>{{__('All Department')}}</option>
                                    @foreach ($department as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="primary-form-group">
                            <div class="primary-form-group-wrap">
                                <label for="passing_year" class="form-label">{{__('Passing Year')}}</label>
                                <select class="sf-select-without-search primary-form-control" name='passing_year'
                                    id='passing-year'>
                                    <option selected="" value=0>{{__('All Year')}}</option>
                                    @foreach ($passingYear as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="primary-form-group">
                            <div class="primary-form-group-wrap">
                                <label for="is_member" class="form-label">{{__('Member')}}</label>
                                <select class="sf-select-without-search primary-form-control" name='is_member'
                                    id='is-member'>
                                    <option value="-1" selected>{{__('All')}}</option>
                                    @foreach (getAlumniMemberStatus() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <button
                        class="bg-cdef84 border-0 bd-ra-12 py-13 px-26 fs-15 fw-500 lh-25 text-black hover-bg-one advance-filter">{{__('Search Now')}}</button>
                    <!-- <div class="item">
                                              </div> -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('admin/js/alumni-all.js') }}"></script>
@endpush
