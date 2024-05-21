@extends('alumni.layouts.app')
@push('title')
    {{ __('create cv') }}
@endpush
@section('content')
    <div class="container">
        <h2 class="mt-5">CV Form</h2>
        <form id="cvForm" method="POST" action="{{route('alumni.cvs.submit')}}">
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

            <div class="row mt-4 mb-4">
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
            <div class="m-4">
                <h1>{{__('University Education')}}</h1>

            </div>
            <div class="row">

                    <div class="col-4 mt-3">
                        <label for="title" class="form-label">{{__('University Name')}}</label>
                        <input type="text" name="university_name" required class="form-control">

                        <label for="address" class="form-label">{{__('Start Date')}}</label>
                        <input type="date" name="university_start_date" required class="form-control">

                        <label for="address" class="form-label">{{__('End Date')}}</label>
                        <input type="date" name="university_end_date" required class="form-control">
                    </div>

                    <div class="col-8">
                        <input type="hidden" id="experienceCount" name="experienceCount" value="2">

                        <label for="experience" class="form-label">{{__('Details:')}} <span
                                class="text-danger">*</span></label>

                        <div class="primary-form-group bg-white rounded-4">
                            <div class="primary-form-group-wrap">
                                <textarea class="summernoteOne" name="university_details"></textarea>
                            </div>
                        </div>
                    </div>

            </div>


            <div class="m-4">
                <h1>{{__('High school Education')}}</h1>

            </div>
            <div class="row">

                <div class="col-4 mt-3">
                    <label for="title" class="form-label">{{__('High School Name')}}</label>
                    <input type="text" name="highschool_name" required class="form-control">

                    <label for="address" class="form-label">{{__('Start Date')}}</label>
                    <input type="date" name="highschool_start_date" required class="form-control">

                    <label for="address" class="form-label">{{__('End Date')}}</label>
                    <input type="date" name="highschool_end_date" required class="form-control">
                </div>


                <div class="col-8">

                    <label for="experience" class="form-label">{{__('Details:')}} <span
                            class="text-danger">*</span></label>

                    <div class="primary-form-group bg-white rounded-4">
                        <div class="primary-form-group-wrap">
                            <textarea class="summernoteOne" name="highschool_details" id="Experience"></textarea>
                        </div>
                    </div>
                </div>

            </div>

            <div class="m-4">
                <h1>{{__('Other Education')}}</h1>

            </div>

            <div class="row">

                <div class="col-4 mt-3">
                    <label for="title" class="form-label">{{__('Institute Name')}}</label>
                    <input type="text" name="other_education_name" required class="form-control">

                    <label for="address" class="form-label">{{__('Start Date')}}</label>
                    <input type="date" name="other_education_start_date" required class="form-control">

                    <label for="address" class="form-label">{{__('End Date')}}</label>
                    <input type="date" name="other_education_end_date" required class="form-control">
                </div>


                <div class="col-8">

                    <label for="experience" class="form-label">{{__('Details:')}} <span
                            class="text-danger">*</span></label>

                    <div class="primary-form-group bg-white rounded-4">
                        <div class="primary-form-group-wrap">
                            <textarea class="summernoteOne" name="other_education_details" id="Experience"></textarea>
                        </div>
                    </div>
                </div>

            </div>
            <div class="m-4">
                <h1>{{__('Work Experience')}}</h1>

            </div>

            <div class="row" id="experienceSection">
                <div class="col-4 mt-3">
                    <label for="title" class="form-label">{{__('Institute Name')}}</label>
                    <input type="text" name="work_experience_name1" required class="form-control">

                    <label for="address" class="form-label">{{__('Start Date')}}</label>
                    <input type="date" name="work_experience_start_date1" required class="form-control">

                    <label for="address" class="form-label">{{__('End Date')}}</label>
                    <input type="date" name="work_experience_end_date1" required class="form-control">
                    <label for="address" class="form-label">{{__('Position')}}</label>
                    <input type="date" name="position" required class="form-control">
                </div>

                <div class="col-8">
                    <label for="experience" class="form-label">{{__('Details:')}} <span class="text-danger">*</span></label>
                    <div class="primary-form-group bg-white rounded-4">
                        <div class="primary-form-group-wrap">
                            <textarea class="summernoteOne" name="work_experience_details1" id="Experience"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" id="addExperienceSection">Add Experience Section</button>


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
                    <button type="submit" id="submitButton" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            var experienceCount = 2; // Start from 2 instead of 0
            var maxExperiences = 3;

            function createExperienceSection() {
                if (experienceCount < maxExperiences) {
                    // Create the HTML structure for the new section
                    var newSectionHtml = `
        <div class="row">
          <div class="col-4 mt-3">
            <label for="title" class="form-label">{{__('Institute Name')}}</label>
            <input type="text" name="work_experience_name${experienceCount}" required class="form-control">

            <label for="address" class="form-label">{{__('Start Date')}}</label>
            <input type="date" name="work_experience_start_date${experienceCount}" required class="form-control">

            <label for="address" class="form-label">{{__('End Date')}}</label>
            <input type="date" name="work_experience_end_date${experienceCount}" required class="form-control">
            <label for="address" class="form-label">{{__('Position')}}</label>
            <input type="text" name="position${experienceCount}" required class="form-control">
          </div>

          <div class="col-8">
            <label for="experience" class="form-label">{{__('Details:')}} <span class="text-danger">*</span></label>
            <div class="primary-form-group bg-white rounded-4">
              <div class="primary-form-group-wrap">
                <textarea class="summernoteOne" name="work_experience_details${experienceCount}" id="Experience"></textarea>
              </div>
            </div>
          </div>

          <button type="button" class="btn btn-danger remove-section">Remove</button>
        </div>`;

                    // Create a jQuery object from the HTML string
                    var newSection = $(newSectionHtml);

                    // Append the new section after the "addExperienceSection" button
                    $("#addExperienceSection").after(newSection);

                    // Initialize summernote on the newly created section
                    newSection.find('.summernoteOne').summernote({
                        placeholder: "Write description...",
                        tabsize: 2,
                        minHeight: 183,
                        toolbar: [
                            ["font", ["bold", "italic", "underline"]],
                            ["para", ["ul", "ol", "paragraph"]],
                        ],
                    });

                    // Add click event listener to remove button
                    newSection.find('.remove-section').on("click", function() {
                        $(this).closest('.row').remove();
                        experienceCount--;
                    });

                    experienceCount++;
                }
            }

            $("#addExperienceSection").on("click", createExperienceSection);
        });
        $(document).ready(function() {
            $("#submitButton").on("click", function() {
                var formData = {
                    experienceCount: $(".experience-section").length,
                    experience1: $("#experience1").val(),
                    start_date1: $("#start_date1").val(),
                    end_date1: $("#end_date1").val(),
                    experience2: $("#experience2").val(),
                    start_date2: $("#start_date2").val(),
                    end_date2: $("#end_date2").val()
                };
                $.ajax({
                    url: "{{route('alumni.cvs.submit')}}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        // Handle the success response from the server
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        // Handle the error response from the server
                        console.log(error);
                    }
                });
            });
        });
    </script>
@endpush
