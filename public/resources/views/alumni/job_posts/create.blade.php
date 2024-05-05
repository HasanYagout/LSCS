@extends('layouts.app')
@push('title')
{{$title}}
@endpush

@section('content')
<div class="p-30">
    <div class="">
        <h4 class="fs-24 fw-500 lh-34 text-black pb-16">{{$title}}</h4>
        <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
            <input type="hidden" id="my-job-post-route" value="{{ route('jobPost.create') }}">
            <form class="ajax reset" data-handler="commonResponseRedirect"
                data-redirect-url="{{route('jobPost.my-job-post')}}" action="{{ route('jobPost.add-new-job-post') }}"
                method="post" enctype="multipart/form-data">
                @csrf
                <div class="max-w-840">
                    <div class="row rg-25">
                        <div class="col-md-6">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="jobCreateTitle" class="form-label">{{__('Job Title')}} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="title" class="primary-form-control" id="title"
                                        placeholder="{{ __('Title') }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="employeeStatus" class="form-label">{{__('Employee Status')}} <span
                                            class="text-danger">*</span></label>
                                    <select class="primary-form-control sf-select-without-search" name="employee_status"
                                        id="employeeStatus">
                                        @foreach (getEmployeeStatus() as $key=>$value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="jobCompensationBenefits" class="form-label">{{__('Compensation &
                                        Benefits')}} <span class="text-danger">*</span></label>
                                    <input type="text" name="compensation_n_benefits" class="primary-form-control"
                                        id="compensation_n_benefits" placeholder="{{ __('As per company policy') }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="jobUploadCompanyLogo" class="form-label">{{__('Upload Company Logo')}}
                                        <span class="text-mime-type">(jpg,jpeg,png)</span> <span
                                            class="text-danger">*</span></label>
                                    <input type="file" name="company_logo" class="primary-form-control"
                                        id="company_logo" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="jobSalary" class="form-label">{{__('Salary')}} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="salary" class="primary-form-control" id="salary"
                                        placeholder="$45k" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="jobLocation" class="form-label">{{__('Location')}} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="location" class="primary-form-control" id="location"
                                        placeholder="{{ __('Location') }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="application_deadline" class="form-label">{{__('Application Deadline')}}
                                        <span class="text-danger">*</span></label>
                                    <input type="text" class="primary-form-control date-time-picker"
                                        id="application_deadline" name="application_deadline" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="jobURL" class="form-label">{{__('URL')}} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="post_link" class="primary-form-control" id="post_link"
                                        placeholder="{{ __('Apply Url') }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="job_context" class="form-label">{{__('Job Context')}} <span
                                            class="text-danger">*</span></label>
                                    <textarea class="summernoteOne" name="job_context" id="job_context"
                                        placeholder="{{ __('Write Job Context') }}"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="job_responsibility" class="form-label">{{__('Job Responsibility')}}
                                        <span class="text-danger">*</span></label>
                                    <textarea class="summernoteOne" name="job_responsibility" id="job_responsibility"
                                        placeholder="{{ __('Write Job Responsibility') }}"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="educational_requirements" class="form-label">{{__('Educational
                                        Requirements')}} <span class="text-danger">*</span></label>
                                    <textarea class="summernoteOne" name="educational_requirements"
                                        id="educational_requirements"
                                        placeholder="{{ __('Write Educational Requirements') }}"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="additional_requirements" class="form-label">{{__('Additional
                                        Requirements')}}</label>
                                    <textarea class="summernoteOne" name="additional_requirements"
                                        id="additional_requirements"
                                        placeholder="{{ __('Write Additional Requirements') }}"> </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex cg-10">
                                <button type="submit" name="status" value="pending"
                                    class="py-13 px-50 border-0 bd-ra-12 bg-cdef84 fs-15 fw-500 lh-25 text-black">{{__('Post')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection
@push('script')
<script src="{{ asset('alumni/js/job_post.js') }}"></script>
@endpush
