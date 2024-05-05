@extends('layouts.app')

@push('title')
{{ $title }}
@endpush

@section('content')
<!-- Page content area start -->
<div class="p-30">
    <div>
        <input type="hidden" id="news-list-route" value="{{ route('admin.news.index') }}">
        <div class="d-flex flex-wrap justify-content-between align-items-center pb-16">
            <h4 class="fs-24 fw-500 lh-34 text-black">{{ $title }}</h4>
            <button type="submit" id="add-news"
                class="py-10 px-26 bg-cdef84 border-0 bd-ra-12 fs-15 fw-500 lh-25 text-black hover-bg-one"
                data-bs-toggle="modal" data-bs-target="#add-modal"><i class="fa fa-plus"></i>
                {{ __('Add New') }}</button>
        </div>
        <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
            <!-- Table -->
            <div class="table-responsive zTable-responsive">
                <table class="table zTable" id="newsDataTable">
                    <thead>
                        <tr>
                            <th scope="col">
                                <div>{{ __('Image') }}</div>
                            </th>
                            <th scope="col">
                                <div>{{ __('Title') }}</div>
                            </th>
                            <th scope="col">
                                <div>{{ __('Category') }}</div>
                            </th>
                            <th scope="col">
                                <div>{{ __('Status') }}</div>
                            </th>
                            <th scope="col">
                                <div>{{ __('Name') }}</div>
                            </th>
                            <th class="w-110 text-center" scope="col">
                                <div>{{ __('Action') }}</div>
                            </th>
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
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content zModalTwo-content">
            <form class="ajax reset" action="{{ route('admin.news.store') }}" method="post"
                data-handler="commonResponseForModal">
                @csrf
                <div class="modal-body zModalTwo-body model-lg">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center pb-30">
                        <h4 class="fs-20 fw-500 lh-38 text-1b1c17">{{ __('Add New') }}</h4>
                        <div class="mClose">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><img
                                    src="{{ asset('assets/images/icon/delete.svg') }}" alt="" /></button>
                        </div>
                    </div>
                    <div class="row rg-25">
                        <div class="col-md-6">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="currentPassword" class="form-label">{{ __('Title') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="primary-form-control" id="news-title" name="title"
                                        placeholder="{{ __('Title') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="BatchName" class="form-label">{{ __('Category') }} <span
                                            class="text-danger"> *</span> </label>
                                    <select class="primary-form-control sf-select-without-search" id="category_id"
                                        name="category_id">
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                            <div class="col-md-6">
                                <div class="primary-form-group">
                                    <div class="primary-form-group-wrap">
                                        <label for="sf-select-news-tag" class="form-label">{{ __('Tag') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="tag_ids[]" multiple id="sf-select-news-tag"
                                            class="primary-form-control tag_ids">
                                            @foreach ($tags as $tag)
                                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                        <div class="col-md-6">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="status" class="form-label">{{ __('Status') }} <span
                                            class="text-danger">*</span></label>
                                    <select class="primary-form-control sf-select-without-search" id="status"
                                        name="status">
                                        <option value="1">{{ __('Publish') }}</option>
                                        <option value="0">{{ __('Deactive') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="details" class="form-label">{{ __('Description') }}</label>
                                    <textarea name="details" class="primary-form-control min-h-180 summernoteOne"
                                        id="news-description" placeholder="{{ __('Write description...') }}"
                                        spellcheck="false"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap zImage-upload-details w-100">
                                    <div class="zImage-inside">
                                        <div class="d-flex pb-12"><img src="{{ getDefaultImage() }}"></div>
                                        <p class="fs-15 fw-500 lh-16 text-1b1c17">{{ __('Drag & drop files here') }}
                                        </p>
                                    </div>
                                    <label for="zImageUpload" class="form-label">{{ __('Upload Image') }} <span
                                            class="text-mime-type">(jpg,jpeg,png)</span> <span
                                            class="text-danger">*</span></label>
                                    <div class="upload-img-box">
                                        <img src="">
                                        <input type="file" id="news-image" name="image" accept="image/*"
                                            onchange="previewFile(this)">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit"
                        class="py-10 px-26 bg-cdef84 border-0 bd-ra-12 fs-15 fw-500 lh-25 text-black hover-bg-one">{{
                        __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add Modal section end -->

<!-- Edit Modal section start -->
<div class="modal fade zModalTwo" id="edit-modal" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content zModalTwo-content">

        </div>
    </div>
</div>
<!-- Edit Modal section end -->
@endsection

@push('script')
<script src="{{ asset('admin/js/news.js') }}"></script>
@endpush
