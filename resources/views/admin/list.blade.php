@extends('layouts.app')
@push('title')
    {{$pageTitle}}
@endpush
@section('content')
    <div class="p-30" >
        <div>
            <input type="hidden" id="instructor-list-route" value="{{ route('admin.index') }}">
            <input type="hidden" id="instructor-status-route" value="{{ route('admin.status',':id') }}">
            <div class="d-flex flex-wrap justify-content-between align-items-center pb-16">
                <h4 class="fs-24 fw-500 lh-34 text-black">{{ $pageTitle }}</h4>
                <button type="submit" id="add-news"
                        class="py-10 px-26 bg-cdef84 border-0 bd-ra-12 fs-15 fw-500 lh-25 text-black hover-bg-one"
                        data-bs-toggle="modal" data-bs-target="#add-modal"><i class="fa fa-plus"></i>
                    {{ __('Add New') }}</button>
            </div>
            <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
                <!-- Table -->
                <div class="table-responsive zTable-responsive">
                    <table class="table zTable" id="instructorsDataTable">
                        <thead>
                        <tr>
                            <th scope="col">
                                <div>{{ __('Image') }}</div>
                            </th>
                            <th scope="col">
                                <div>{{ __('F_Name') }}</div>
                            </th>
                            <th scope="col">
                                <div>{{ __('L_Name') }}</div>
                            </th>
                            <th scope="col">
                                <div>{{ __('Email') }}</div>
                            </th>
                            <th scope="col">
                                <div>{{ __('Type') }}</div>
                            </th>
                            <th scope="col">
                                <div>{{ __('Status') }}</div>
                            </th>
                            <th scope="col">
                                <div>{{ __('reset Password') }}</div>
                            </th>
                            <th scope="col">
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
            <div class="modal-content p-30 zModalTwo-content">
                <form method="POST" action="{{ route('admin.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group p-14">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group p-14">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}" required>
                            </div>

                        </div>
                        <div class="col-md-6">


                            <div class="form-group p-14">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                            </div>

                        </div>
                        <div class="col-md-6">

                            <div class="form-group p-14">
                                <label for="phone">Phone Number</label>
                                <input type="text" name="mobile" id="phone" class="form-control" value="{{ old('phone') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group p-14">
                                <label for="type">Type</label>
                                <select class="primary-form-control sf-select-without-search" name="type" id="">
                                    <option value="1">Admin</option>
                                    <option value="4">Instructor</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <button type="submit"
                                class="bd-ra-12 bg-cdef84 border-0 fs-15 fw-500 hover-bg-one lh-25 m-auto my-4 px-26 py-10 text-black w-auto"
                        >
                            {{ __('Add Instructor') }}</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="modal fade zModalTwo" id="edit-modal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content zModalTwo-content">

            </div>
        </div>
    </div>

@endsection
@push('script')
    <script>
        // Function to handle resetting password
        function resetPassword(url, id) {
            Swal.fire({
                title: 'Reset Password',
                text: 'Are you sure you want to reset this admin\'s password?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Reset It!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.message) {
                                Swal.fire({
                                    title: 'Success',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    if (response.logout) {
                                        // Redirect to login page if logout is true
                                        window.location.href = "{{ route('auth.login') }}"; // Correct URL for login
                                    } else {
                                        // Optionally handle success for other admins
                                        window.location.reload(); // Reload the current page
                                    }
                                });
                            } else {
                                Swal.fire('Error', 'Failed to reset password.', 'error');
                            }
                        },
                        error: function (error) {
                            Swal.fire('Error', 'Failed to reset password: ' + error.responseJSON.error, 'error');
                        }
                    });
                }
            });
        }


    </script>
    <script src="{{ asset('public/admin/js/instructors.js') }}?ver={{ env('VERSION' ,0) }}"></script>
@endpush
