@extends('layouts.app')

@push('title')
{{$title}}
@endpush


@section('content')
<!-- Page content area start -->

<div class="p-30">
    <div>
        <input type="hidden" id="news-category-list-route" value="{{ route('admin.news.categories.index') }}">
        <div class="d-flex flex-wrap justify-content-between align-items-center pb-16">
            <h4 class="fs-24 fw-500 lh-34 text-black">{{$title}}</h4>
            <button type="submit" id="add-news" class="py-10 px-26 bg-cdef84 border-0 bd-ra-12 fs-15 fw-500 lh-25 text-black hover-bg-one" data-bs-toggle="modal"
            data-bs-target="#add-modal"><i class="fa fa-plus"></i> {{ __('Add New') }}</button>
        </div>
      <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
        <!-- Table -->
        <div class="table-responsive zTable-responsive">
            <table class="table zTable" id="newsCategoryDataTable">
              <thead>
                <tr>
                  <th scope="col"><div>{{ __('Name') }}</div></th>
                  <th scope="col"><div>{{ __('Status') }}</div></th>
                   <th class="w-110 text-center" scope="col"><div>{{ __('Action') }}</div></th>
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

            <form class="ajax reset" action="{{ route('admin.news.categories.store') }}" method="post"
                data-handler="commonResponseForModal">
                @csrf
                <div class="modal-body zModalTwo-body">
                    <div class="d-flex justify-content-between align-items-center pb-30">
                        <h4 class="fs-20 fw-500 lh-38 text-1b1c17">{{__('Add New')}}</h4>
                        <div class="mClose">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><img src="{{asset('assets/images/icon/delete.svg')}}" alt="" /></button>
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
                        <div class="col-12">
                            <div class="primary-form-group my-2 pt-3">
                                <div class="primary-form-group-wrap">
                                  <label for="BatchName" class="form-label">{{ __('Status') }} <span class="text-danger">*</span></label>
                                  <select class="primary-form-control sf-select-without-search" id="BatchName" name="status">
                                    <option value="1">{{ __('Active') }}</option>
                                    <option value="0">{{ __('Deactive') }}</option>
                                  </select>
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
@endsection

@push('script')
    <script src="{{ asset('admin/js/newsCategory.js') }}"></script>
@endpush
