@extends('alumni.layouts.app')
@push('title')
    {{ __('create cv') }}
@endpush
@section('content')
    <div class="container">
        <h2 class="mt-5">CV Form</h2>
        <form method="POST" action="{{route('alumni.cvs.submit')}}">
            @csrf
            <div class="row mt-4">
                <div class="col-md-6 m-auto">
                    <label for="fileName" class="form-label">File Name</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-6">
                    <label for="fname" class="form-label">First Name:</label>
                    <input type="text" id="fname" name="fname" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="lname" class="form-label">Last Name:</label>
                    <input type="text" id="lname" name="lname" class="form-control" required>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-4">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="phone" class="form-label">Phone:</label>
                    <input type="text" id="phone" name="phone" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="address" class="form-label">Address:</label>
                    <input type="text" id="address" name="address" class="form-control" required></input>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                  <label for="job_context" class="form-label">{{__('Education')}} <span
                                    class="text-danger">*</span></label>
                    <div class="primary-form-group bg-white rounded-4">
                        <div class="primary-form-group-wrap">
                            <textarea class="summernoteOne" name="education" id="Education"
                                      placeholder="{{ __('Write Job Context') }}"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">

                    <label for="experience" class="form-label">{{__('Work Experience:')}} <span
                            class="text-danger">*</span></label>

                    <div class="primary-form-group bg-white rounded-4">
                        <div class="primary-form-group-wrap">
                            <textarea class="summernoteOne" name="experience" id="Experience"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="col-12">

                        <label for="skills" class="form-label">{{__('Skills:')}} <span
                                class="text-danger">*</span></label>

                        <div class="primary-form-group bg-white rounded-4">
                            <div class="primary-form-group-wrap">
                                <textarea class="summernoteOne" name="skills" id="Skills"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="col-12">

                        <label for="additional" class="form-label">{{__('Additional Information:')}} <span
                                class="text-danger">*</span></label>

                        <div class="primary-form-group bg-white rounded-4">
                            <div class="primary-form-group-wrap">
                                <textarea class="summernoteOne" name="additional" id="Additional"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection
