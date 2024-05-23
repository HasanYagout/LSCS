@extends('admin.layouts.app')

@push('title')
    {{$title}}
@endpush

@section('content')


    <!-- Page content area start -->
    <div class="p-30">
        <div>
            <input type="hidden" id="companies-route" value="{{ route('admin.company.all') }}">
            <div class="d-flex flex-wrap justify-content-between align-items-center pb-16">
                <h4 class="fs-24 fw-500 lh-34 text-black">{{$title}}</h4>
            </div>
            <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
                <!-- Table -->
                <div class="table-responsive zTable-responsive">
                    <table class="table zTable" id="companiesTable">
                        <thead>
                        <tr>
                            <th scope="col"><div>{{ __('Name') }}</div></th>
                            <th scope="col"><div>{{ __('Email') }}</div></th>
                            <th scope="col"><div>{{ __('Phone') }}</div></th>
                            <th scope="col"><div>{{ __('Status') }}</div></th>
                            <th class="w-110 text-center" scope="col"><div>{{ __('Action') }}</div></th>
                        </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- Page content area End -->

    <!-- Edit Modal section start -->
    <div class="modal fade" id="edit-modal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

            </div>
        </div>
    </div>
    <!-- Edit Modal section end -->
@endsection

@push('script')
    <script>
        $(document).on('change', '.status-toggle', function() {
            var isChecked = $(this).is(':checked');
            var companyId = $(this).data('id');

            if (isChecked) {
                // Show confirmation message using SweetAlert
                Swal.fire({
                    title: 'Confirmation',
                    text: "Are you sure you want to update the status to 'Yes'?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Update the status to 1 using AJAX request
                        $.ajax({
                            url: '{{ route("admin.company.update", ["company" => ":companyId"]) }}'.replace(':companyId', companyId),
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                companyId: companyId,
                                status: 1
                            },
                            success: function(response) {
                                // Handle the success response
                                Swal.fire('Success', 'Status updated successfully.', 'success');
                            },
                            error: function(xhr, status, error) {
                                // Handle the error response
                                console.error('Error updating status:', error);
                                // Revert the switch checkbox state
                                $('.status-toggle[data-id="' + companyId + '"]').prop('checked', false);
                            }
                        });
                    } else {
                        // Revert the switch checkbox state
                        $(this).prop('checked', false);
                    }
                });
            } else {
                // Update the status to 0
                $.ajax({
                    url: '{{ route("admin.company.update", ["company" => ":companyId"]) }}'.replace(':companyId', companyId),
                    method: 'POST',  // Adjust the HTTP method as needed
                    data: {
                        companyId: companyId,
                        status: 0,
                        _token: '{{ csrf_token() }}',

                    },
                    success: function(response) {
                        // Handle the success response
                        Swal.fire('Success', 'Status updated successfully.', 'success');
                    },
                    error: function(xhr, status, error) {
                        // Handle the error response
                        console.error('Error updating status:', error);
                        // Revert the switch checkbox state
                        $('.status-toggle[data-id="' + companyId + '"]').prop('checked', true);
                    }
                });
            }
        });
    </script>
    <script src="{{ asset('public/admin/js/companies.js') }}"></script>
@endpush
