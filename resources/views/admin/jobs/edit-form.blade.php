<div class="modal-header">
    <h5 class="modal-title">{{ __('Update') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<form class="ajax reset" action="{{ route('admin.jobs.update', $jobPostData->slug) }}" method="post"
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
                                value="{{$jobPostData->title??''}}" id="title" placeholder="{{ __('Sr. UX Designer') }}" required />
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label for="employeeStatus" class="form-label">{{__('Employee Status')}} <span
                                    class="text-danger">*</span></label>
                            <select class="primary-form-control sf-select-without-search" name="employee_status"
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
                            <label for="jobLocation" class="form-label">{{__('Location')}} <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="location" class="primary-form-control" id="location"
                                placeholder="{{__('Location')}}}" required value="{{$jobPostData->location??''}}" />
                        </div>
                    </div>
                </div>
                @php
                    use Carbon\Carbon;
                @endphp
                <div class="col-md-6">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label for="application_deadline" class="form-label">{{__('Application Deadline')}} <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="application_deadline" class="primary-form-control"
                                id="application_deadline" value="{{Carbon::parse($jobPostData->application_deadline??'')->format('Y-m-d')}}" required />
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label for="jobURL" class="form-label">{{__(' Placement URL')}} <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="placement_link" class="primary-form-control" id="post_link"
                                placeholder="{{ __('Placement Url') }}"
                                value="{{$jobPostData->placement_link??''}}" />
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label for="status" class="form-label">{{__('Job Status')}} <span
                                    class="text-danger">*</span></label>
                            <select class="primary-form-control sf-select-without-search" name="status" id="status"
                                required>
                                @foreach (getJobStatus() as $key=>$value)
                                <option {{$jobPostData->status == $key ?'selected':''}} value="{{ $key }}">{{ $value }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label for="job_context" class="form-label">{{__('Job Context')}} <span
                                    class="text-danger">*</span></label>
                            <textarea class="summernoteOne" name="job_context" id="job_context"
                                placeholder="{{ __('Write Job Context') }}" required>{!! $jobPostData->job_context !!}</textarea>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label for="job_responsibility" class="form-label">{{__('Job Responsibility')}} <span
                                    class="text-danger">*</span></label>
                            <textarea class="summernoteOne" name="job_responsibility" id="job_responsibility"
                                placeholder="{{ __('Write Job Responsibility') }}"
                                required>{!! $jobPostData->job_responsibility !!}</textarea>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label for="educational_requirements" class="form-label">{{__('Educational Requirements')}}
                                <span class="text-danger">*</span></label>
                            <textarea class="summernoteOne" name="educational_requirements"
                                id="educational_requirements" placeholder="{{ __('Write Educational Requirements') }}"
                                required>{!! $jobPostData->educational_requirements !!}</textarea>
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
