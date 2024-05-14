@extends('admin.layouts.app')
@push('title')
    {{$pageTitle}}
@endpush

@section('content')

    <div class="p-30">
        <div class="">

            <div class="pt-30">
                {{-- <h4 class="fs-24 fw-500 lh-34 text-black pb-16">My Job Post</h4> --}}
                <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
                    <!-- Table -->
                    <h4 class="title mb-3">{{ __('Companies') }}</h4>
                    <div class="table-responsive zTable-responsive">
                        <table class="table zTable" id="companiesTable">
                            <thead>
                            <tr>
                                <th scope="col">
                                    <div>{{ __('Name') }}</div>
                                </th>
                                <th scope="col">
                                    <div>{{ __('email') }}</div>
                                </th>
                                <th scope="col">
                                    <div>{{ __('address') }}</div>
                                </th>
                                <th scope="col">
                                    <div>{{ __('website') }}</div>
                                </th>
                                <th scope="col">
                                    <div>{{ __('phone') }}</div>
                                </th>
                                <th scope="col">
                                    <div>{{ __('logo') }}</div>
                                </th>
                                <th scope="col">
                                    <div>{{ __('status') }}</div>
                                </th>
                                <th scope="col">
                                    <div>{{ __('action') }}</div>
                                </th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade zModalTwo" id="edit-modal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content zModalTwo-content">

            </div>
        </div>
    </div>
    <input type="hidden" id="companies-route" value="{{ route('company.all') }}">
@endsection

@push('script')
    <script>
        function openPdfViewer(file) {
            window.open('/LSCS/public/storage/company/proposal/' + encodeURIComponent(file), '_blank');
        }
    </script>
    <script src="{{ asset('public/admin/js/companies.js') }}"></script>
@endpush
