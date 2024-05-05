@extends('layouts.app')

@push('title')
{{$title}}
@endpush


@section('content')
<!-- Page content area start -->
<div class="p-30">
    <div>
        <input type="hidden" id="my-ticket-list-route" value="{{ route('event.my-ticket') }}">
        <div class="d-flex flex-wrap justify-content-between align-items-center pb-16">
            <h4 class="fs-24 fw-500 lh-34 text-black">{{$title}}</h4>
        </div>
      <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
        <!-- Table -->
        <div class="table-responsive zTable-responsive">
            <table class="table zTable" id="myTicketDataTable">
              <thead>
                <tr>
                    <th scope="col"><div>{{ __('Event Title') }}</div></th>
                    <th scope="col" class="min-w-100"><div>{{ __('Ticket Id') }}</div></th>
                    <th scope="col"><div>{{ __('Type') }}</div></th>
                    <th scope="col"><div>{{ __('Date & Time') }}</div></th>
                    <th scope="col"><div>{{ __('Location') }}</div></th>
                     <th class="w-110 text-center" scope="col"><div>{{ __('Action') }}</div></th>
                </tr>
              </thead>
            </table>
        </div>

      </div>
    </div>
</div>
<!-- Page content area end -->

    <!-- Ticket View Modal -->
    <div class="modal fade" id="ticketViewModal" tabindex="-1" aria-labelledby="ticketViewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content border-0">

            </div>
        </div>
    </div>


@endsection

@push('script')
<script src="{{ asset('admin/js/ticket.js') }}"></script>
<script src="{{asset('common/js/html2canvas.js')}}"></script>
@endpush
