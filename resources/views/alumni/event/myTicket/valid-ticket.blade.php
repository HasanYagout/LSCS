<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="icon" href="{{ getSettingImage('app_fav_icon') }}" type="image/png" sizes="16x16">
        <title>{{ getOption('app_name') }} - {{__('Ticket Verification')}}</title>
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/scss/style.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" />
    </head>
    <body>

        <div class="d-flex h-100 justify-content-center row">
            <div class="col-md-6 my-auto">
                <div id="printableArea" class="bg-white overflow-hidden rounded-5">
                    <div class="">
                        <div class="bg-1b1c17 border-bottom border-light p-14 pt-2 text-center">
                            <img class="max-h-35" src="{{ getSettingImage('app_logo') }}" alt="{{ getOption('app_name') }}" />
                            <h1 class="fs-3 fw-600 mt-3 text-white">{{__('Ticket Verification') }}</h1>
                        </div>
                        <div class="p-20 pb-27 text-center">
                            @if($success == true)
                                <div class="d-flex justify-content-center pb-30"><img class="w-25" src="{{ asset('assets/images/successful-message.png')}}" alt="" /></div>
                                <h4 class="fs-16 fw-600 lh-24 text-success mb-3">{{ __('Successfully Verified') }}</h4>
                                <h4 class="fw-600 fs-16">{{ __('Ticket No: ')}}{{$ticket->ticket_number}}</h4>
                                <p class="fs-15 fw-400 lh-17 pb-14 max-w-260 m-auto mt-2"><span class="fw-600">{{__('Participant: ')}}</span>{{ $ticket->user->name }}</p>
                                <p class="fs-15 fw-400 lh-17 pb-14 max-w-260 m-auto mt-3">{{ $ticket->event->title }}</p>
                            @else
                                <div class="d-flex justify-content-center pb-30"><img src="{{ asset('assets/images/failed-message.png')}}" alt="" /></div>
                                <h4 class="fs-20 fw-600 lh-24 text-1b1c17 pb-8">{{ __('Verification failed') }}</h4>
                            @endif
                        </div>
                    </div>                  
                </div>
            </div>
        </div>

        <script src="{{ asset('assets/js/jquery-3.7.0.min.js')}}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
    </body>
</html>
