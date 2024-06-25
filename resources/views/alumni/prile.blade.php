@extends('layouts.app')
@push('title')
    {{ __('Profile') }}
@endpush
@section('content')
    <style>

        .grid-item {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 20px;
            text-align: center;
        }
    </style>
    <div class="container">
        <h1 class="my-4">Complex Grid Layout with Bootstrap</h1>



        <!-- Row 2: Nested Columns -->
        <div class="row mb-4">
            <div class="col-md-6 grid-item">
                <div class="py-20 px-25 bd-ra-10 bg-f9f9f9">
                    <!-- Bio text -->
                    <div class="pb-25 mb-25 bd-b-one bd-c-ededed">
                        <h4 class="fs-18 fw-500 lh-22 text-f1a527 pb-10">{{ __('Profile Bio') }}</h4>
                        <p class="fs-14 fw-400 lh-24 text-707070 pb-12">{!! auth('alumni')->user()?->about_me !!}</p>
                    </div>
                    <!-- Personal Info -->
                    <ul class="zList-one">
                        <li>
                            <p>{{ __('First Name') }} :</p>
                            <p>{{ auth('alumni')->user()->first_name}}</p>
                        </li>
                        <li>
                            <p>{{ __('Last Name') }} :</p>
                            <p>{{ auth('alumni')->user()->last_name}}</p>
                        </li>

                        <li>
                            <p>{{ __('Email') }} :</p>
                            <p>{{auth('alumni')->user()->email}}</p>
                        </li>

                        <li>
                            <p>{{ __('Phone') }} :</p>
                            <p>{{auth('alumni')->user()->phone}}</p>
                        </li>


                        <li>
                            <p>{{ __('City') }} :</p>
                            <p> {{ auth('alumni')->user()?->city }}</p>
                        </li>
                        <li>
                            <p>{{ __('Date Of Birth') }} :</p>
                            <p>{{ auth('alumni')->user()?->date_of_birth }}</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 grid-item">Column 2</div>
        </div>



        <!-- Row 7: Responsive Columns -->
        <div class="row mb-4">
            <div class="col-sm-6 col-md-4 grid-item">Responsive Column 1</div>
            <div class="col-sm-6 col-md-4 grid-item">Responsive Column 2</div>
            <div class="col-sm-12 col-md-4 grid-item">Responsive Column 3</div>
        </div>

    </div>

@endsection

@push('script')
    <script>
        $(document).ready(function () {
            $('.skills-select').select2({
                tags: true,
                tokenSeparators: [',', ' '],
                placeholder: "Add your skills",
                allowClear: true
            });
            $('#addCompanyBtn').click(function () {
                if (experienceCount < maxExperiences) {
                    $('#addExperienceModal').modal('show');
                }
            });
            const maxExperiences = 3;
            let experienceCount = 1;
            let sectionCounter = 1;

            $('#addCompanyBtn').click(function () {
                if (experienceCount < maxExperiences) {
                    var container = $('#companySectionContainer');
                    var newSectionId = 'summernote' + sectionCounter; // Unique ID for each Summernote instance

                    var newHtml = `
            <div class="row" id="section${sectionCounter}">
                <!-- Company Name -->
                <div class="col-md-6">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label class="form-label">Company Name</label>
                            <input type="text" name="company[]" class="primary-form-control" placeholder="Your Current Company">
                        </div>
                    </div>
                </div>
                <!-- Designation -->
                <div class="col-md-6">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label class="form-label">Position</label>
                            <input type="text" name="position[]" class="primary-form-control" placeholder="Your Position">
                        </div>
                    </div>
                </div>
                <!-- Address -->
                <div class="col-md-6">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label class="form-label">Address</label>
                            <input type="text" name="company_address[]" class="primary-form-control" placeholder="Your Company Address">
                        </div>
                    </div>
                </div>
                <!-- Start Date and End Date -->
                <div class="col-md-6 d-flex">
                    <div class="col-lg-6">
                        <div class="primary-form-group">
                            <div class="primary-form-group-wrap">
                                <label>Start Date:</label>
                                <input type="date" class="form-control" name="startDate[]">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="primary-form-group">
                            <div class="primary-form-group-wrap">
                                <label for="endDate">End Date:</label>
                                <input type="date" class="form-control endDate" name="endDate[]">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Description -->
                <div class="col-lg-12">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label for="${newSectionId}" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea name="details[]" class="primary-form-control summernote" id="${newSectionId}" placeholder="Details"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            `;

                    container.append(newHtml);  // Append the new section to the container using jQuery's append
                    initializeSummernote(newSectionId);  // Initialize Summernote for the new textarea
                    sectionCounter++;  // Increment the counter after adding the section
                    experienceCount++;  // Increment experience count
                }
            });

            function initializeSummernote(elementId) {
                $('#' + elementId).summernote({
                    placeholder: "Write description...",
                    tabsize: 2,
                    minHeight: 183,
                    toolbar: [
                        ["font", ["bold", "italic", "underline"]],
                        ["para", ["ul", "ol", "paragraph"]],
                    ],
                });
            }
        });
    </script>
    <script src="{{ asset('public/alumni/js/profile.js') }}"></script>
    <script src="{{ asset('public/alumni/js/cvs.js') }}"></script>
@endpush
