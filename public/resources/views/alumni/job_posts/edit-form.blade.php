<div class="modal-header">
    <h5 class="modal-title">{{ __('Update') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<form class="ajax reset" action="{{ route('jobPost.update', $jobPostData->slug) }}" method="post"
    data-handler="commonResponseForModal">
    @csrf
    <div class="modal-body model-lg">
        <div class="max-w-840">
            <div class="row rg-25">
                <div class="col-md-6">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label for="jobCreateTitle" class="form-label">{{__('Job Title')}} <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="title" class="primary-form-control"
                                value="{{$jobPostData->title??''}}" id="title" placeholder="{{ __('Title') }}" required />
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label for="employeeStatus" class="form-label">{{__('Employee Status')}} <span
                                    class="text-danger">*</span></label>
                            <select class="form-control sf-select-without-search" name="employee_status"
                                id="employeeStatus" required>
                                @foreach (getEmployeeStatus() as $key=>$value)
                                <option {{$jobPostData->employee_status == $key ?'selected':''}} value="{{ $key }}">{{
                                    $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label for="jobCompensationBenefits" class="form-label">{{__('Compensation & Benefits')}}
                                <span class="text-danger">*</span></label>
                            <input type="text" name="compensation_n_benefits" class="primary-form-control"
                                id="compensation_n_benefits" value="{{$jobPostData->compensation_n_benefits??''}}"
                                placeholder="{{ __('As per company policy') }}" required />
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label for="jobUploadCompanyLogo" class="form-label">{{__('Upload Company Logo')}} <span
                                    class="text-mime-type">(jpg,jpeg,png)</span> @isset($jobPostData->company_logo) <a
                                    href="{{ getFileUrl($jobPostData->company_logo) }}" target="_blank">View</a>
                                @endisset </label>
                            <input type="file" name="company_logo" class="primary-form-control" id="company_logo" />
                            <input type="hidden" name="slug" class="primary-form-control" id="slug"
                                value="{{$jobPostData->slug}}" />
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label for="jobSalary" class="form-label">{{__('Salary')}} <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="salary" class="primary-form-control" id="salary"
                                value="{{$jobPostData->salary??''}}" placeholder="$45k" required />
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label for="jobLocation" class="form-label">{{__('Location')}} <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="location" class="primary-form-control" id="location"
                                placeholder="Gulsan 02, Dhaka" required value="{{$jobPostData->location??''}}" />
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label for="application_deadline" class="form-label">{{__('Application Deadline')}} <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="application_deadline" class="primary-form-control date-time-picker"
                                id="application_deadline" value="{{$jobPostData->application_deadline??''}}" required />
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label for="jobURL" class="form-label">{{__('URL')}} <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="post_link" class="primary-form-control" id="post_link"
                                placeholder="{{ __('Apply Url') }}" required
                                value="{{$jobPostData->post_link??''}}" />
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label for="job_context" class="form-label">{{__('Job Context')}} <span
                                    class="text-danger">*</span></label>
                            <textarea class="summernoteOne" name="job_context" id="job_context"
                                placeholder="{{ ('Job Context') }}">{!! $jobPostData->job_context !!}</textarea>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label for="job_responsibility" class="form-label">{{__('Job Responsibility')}} <span
                                    class="text-danger">*</span></label>
                            <textarea class="summernoteOne" name="job_responsibility" id="job_responsibility"
                                placeholder="{{ __('Write Job Responsibility') }}">{!! $jobPostData->job_responsibility !!}</textarea>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label for="educational_requirements" class="form-label">{{__('Educational Requirements')}}
                                <span class="text-danger">*</span></label>
                            <textarea class="summernoteOne" name="educational_requirements"
                                id="educational_requirements"
                                placeholder="{{ __('Write Educational Requirements') }}">{!! $jobPostData->educational_requirements !!}</textarea>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label for="additional_requirements" class="form-label">{{__('Additional Requirements')}}
                                <span class="text-danger">*</span></label>
                            <textarea class="summernoteOne" name="additional_requirements" id="additional_requirements"
                                placeholder="{{ __('Write Additional Requirements') }}"> {!! $jobPostData->additional_requirements !!}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="submit" id="post"
            class="py-13 px-50 border-0 bd-ra-12 bg-cdef84 fs-15 fw-500 lh-25 text-black">{{__('Update Post')}}</button>
    </div>

</form>
