@extends('layouts.app')

@push('title')
    {{$title}}
@endpush


@section('content')
    <!-- Page content area start -->
    <div class="p-30" style="margin-left:250px;">
        <div>
            <input type="hidden" id="students-list-route" value="{{ route('admin.students.index') }}">
            <input type="hidden" id="students-update-route" value="{{ route('admin.students.update') }}">

            <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
                <!-- Table -->
                <div class="table-responsive zTable-responsive">
                    <table class="table zTable" id="studentsTable">
                        <thead>
                        <tr>
                            <th scope="col"><div class="bg-f5b40a">{{ __('Number') }}</div></th>
                            <th scope="col"><div class="bg-f5b40a">{{ __('Student ID') }}</div></th>
                            <th scope="col"><div class="bg-f5b40a">{{ __('F_Name') }}</div></th>
                            <th scope="col"><div class="bg-f5b40a">{{ __('M_Name') }}</div></th>
                            <th scope="col"><div class="bg-f5b40a">{{ __('L_Name') }}</div></th>
                            <th scope="col"><div class="bg-f5b40a">{{ __('GPA') }}</div></th>
                            <th scope="col"><div class="bg-f5b40a">{{ __('Major') }}</div></th>
                            <th scope="col"><div class="bg-f5b40a">{{ __('C_Left') }}</div></th>
                            <th class="w-110 text-center" scope="col"><div class="bg-f5b40a">{{ __('Action') }}</div></th>
                        </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- Page content area end -->

    <!-- Add Modal section start -->
    <div class="modal fade zModalTwo" id="add-modal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content zModalTwo-content">
                <form class="ajax reset" action="{{ route('admin.eventCategory.store') }}" method="post"
                      data-handler="commonResponseForModal">
                    @csrf
                    <div class="modal-body zModalTwo-body model-lg">
                        <!-- Header -->
                        <div class="d-flex justify-content-between align-items-center pb-30">
                            <h4 class="fs-20 fw-500 lh-38 text-1b1c17">{{__('Add New')}}</h4>
                            <div class="mClose">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><img src="{{asset('public/assets/images/icon/delete.svg')}}" alt="" /></button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="primary-form-group mt-2">
                                    <div class="primary-form-group-wrap">
                                        <label for="currentPassword" class="form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="primary-form-control" name="name">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="py-10 px-26 bg-cdef84 border-0 bd-ra-12 fs-15 fw-500 lh-25 text-black hover-bg-one">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add Modal section end -->

    <!-- Edit Modal section start -->
    <div class="modal fade zModalTwo" id="edit-modal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content zModalTwo-content">

            </div>
        </div>
    </div>
    <!-- Edit Modal section end -->
{{--    <div id="search-section">--}}
{{--        <div class="collapse" id="collapseExample">--}}
{{--            <div class="alumniFilter">--}}
{{--                <h4 class="fs-18 fw-500 lh-38 text-1b1c17 pb-10">{{__('Filter your search')}}</h4>--}}
{{--                <div class="filterOptions">--}}
{{--                    <div class="item">--}}
{{--                        <div class="primary-form-group">--}}
{{--                            <div class="primary-form-group-wrap">--}}
{{--                                <label for="Department" class="form-label">{{__('Department')}}</label>--}}
{{--                                <select class="sf-select-without-search primary-form-control" name='department'--}}
{{--                                        id='department'>--}}
{{--                                    <option selected="" value=0>{{__('All Department')}}</option>--}}

{{--                                    @foreach ($majors as $major)--}}
{{--                                        <option value="{{$major}}">{{$major}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="item">--}}
{{--                        <div class="primary-form-group">--}}
{{--                            <div class="primary-form-group-wrap">--}}
{{--                                <label for="passing_year" class="form-label">{{__('Passing Year')}}</label>--}}
{{--                                <select class="sf-select-without-search primary-form-control" name='passing_year'--}}
{{--                                        id='passing-year'>--}}
{{--                                    <option selected="" value=0>{{__('All Year')}}</option>--}}
{{--                                    @foreach ($passingYear as $row)--}}
{{--                                        <option value="{{ $row->id }}">{{ $row->name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="item">--}}
{{--                        <div class="primary-form-group">--}}
{{--                            <div class="primary-form-group-wrap">--}}
{{--                                <label for="is_member" class="form-label">{{__('Member')}}</label>--}}
{{--                                <select class="sf-select-without-search primary-form-control" name='is_member'--}}
{{--                                        id='is-member'>--}}
{{--                                    <option value="-1" selected>{{__('All')}}</option>--}}
{{--                                    @foreach (getAlumniMemberStatus() as $key => $value)--}}
{{--                                        <option value="{{ $key }}">{{ $value }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <button--}}
{{--                        class="bg-cdef84 border-0 bd-ra-12 py-13 px-26 fs-15 fw-500 lh-25 text-black hover-bg-one advance-filter">{{__('Search Now')}}</button>--}}
{{--                    <!-- <div class="item">--}}
{{--                                              </div> -->--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

@endsection

@push('script')

    <script src="{{asset('public/admin/js/students.js')}}"></script>
@endpush
