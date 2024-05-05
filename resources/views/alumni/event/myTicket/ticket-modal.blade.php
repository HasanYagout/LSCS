    <!-- Header -->
    <div class="mb-20 px-20 pt-10 d-flex justify-content-center justify-content-sm-between align-items-center flex-wrap cg-15 rg-10">
      <button type="button" data-bs-dismiss="modal" class="border-0 bg-white d-flex align-items-center cg-13">
        <span class="text-1b1c17"><i class="fa-solid fa-arrow-left"></i></span>
        <p class="fs-18 fw-500 lh-22 text-1b1c17">{{__('Back To Dashboard')}}</p>
      </button>
      <a target="blank" id="download-btn" download="" href=""  class="d-none d-flex align-items-center cg-8 px-10 py-5 bg-cdef84 bd-ra-4">
        <p class="fs-14 fw-500 lh-20 text-1b1c17">{{__('Download')}}</p>
        <span><img src="{{asset('assets/images/icon/download.svg')}}" alt="" /></span>
      </a>
    </div>
    <div id="printArea" class="ticket-view d-flex flex-column flex-sm-row justify-content-between align-items-center">
      <div class="left">
        <img src="{{getFileUrl($ticket->event->ticket_image)}}" alt="" />
      </div>
      <div class="middle">
        <h4 class="lh-sm title">{{$ticket->event->title}}</h4>
        <div class="order">
          <h4>{{ __('Ticket')}}#{{$ticket->ticket_number}}</h4>
          <p>{{__('Reserved by')}} {{$ticket->user->name}}, {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $ticket->created_at)->format('j M Y')}}</p>
        </div>
        <div class="music">
          <h4>{{__('Location')}}</h4>
          <p>{{$ticket->event->location}}</p>
        </div>
      </div>

      <div class="right d-flex flex-column align-items-center justify-content-center">
        <div class="qr mb-2">
          {!! DNS2D::getBarcodeHTML(route('ticket.verify', encrypt($ticket->ticket_number)), 'QRCODE', 3,3) !!}
        </div>
        <span class=" fs-15 mb-3">{{__('Scan to verify')}}</span>
        <div class="bar-code mt-4">
          {!! DNS1D::getBarcodeHTML($ticket->ticket_number, 'EAN13') !!}
        </div>
      </div>


    </div>
