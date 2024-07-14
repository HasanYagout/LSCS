<!-- In your layout file (e.g., layout.blade.php) -->
<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('layouts.header')

<body>

<div class="overflow-x-hidden">

    <div id="preloader">
        <div id="preloader_status">
            <img src="{{ asset('public/frontend/images/liu-logo.png') }}" alt="{{ getOption('app_name') }}" />
        </div>
    </div>
    <!-- Main Content -->
    <div class="zMain-wrap">
        <!-- Sidebar -->
        @include('layouts.sidebar')
        <!-- Main Content -->
        <div class="zMainContent">
            <!-- Header -->
            @include('layouts.nav')
            <!-- Content -->
            @yield('content')

        </div>
    </div>
</div>
@if (!empty(getOption('cookie_status')) && getOption('cookie_status') == STATUS_ACTIVE)
    <div class="cookie-consent-wrap shadow-lg">
        @include('cookie-consent::index')
    </div>
@endif

@include('layouts.script')
{!! Toastr::message() !!}

<!-- Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>

{{--<!-- js file  -->--}}
{{--<script src="{{ asset('public/assets/js/jquery-3.7.0.min.js')}}"></script>--}}
{{--<script src="{{ asset('public/assets/js/bootstrap.min.js')}}"></script>--}}
{{--<script src="{{ asset('public/assets/js/plugins.js')}}"></script>--}}
{{--<script src="{{ asset('public/assets/js/dataTables.responsive.min.js')}}"></script>--}}
{{--<script src="{{ asset('public/assets/css/summernote/summernote-lite.min.js') }}"></script>--}}
{{--<script src="{{ asset('public/assets/js/lc_select.min.js') }}"></script>--}}
{{--<script src="{{ asset('public/assets/js/main.js')}}?ver={{ env('VERSION', 0) }}"></script>--}}
{{--<script src="{{ asset('public/common/js/common.js')}}?ver={{ env('VERSION' ,0) }}"></script>--}}
{{--<script src="{{ asset('public/assets/lightbox/js/lightbox.js')}}"></script>--}}

@stack('script')

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
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
                                    window.location.href = {{route('auth.login')}}; // Change to your login URL
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
    $(document).ready(function() {
        $('.dropdown-toggle').dropdown();
    });
    @if(Session::has('success'))
    toastr.success("{{ session('success') }}");
    @endif
    @if(Session::has('error'))
    toastr.error("{{ session('error') }}");
    @endif
    @if(Session::has('info'))
    toastr.info("{{ session('info') }}");
    @endif
    @if(Session::has('warning'))
    toastr.warning("{{ session('warning') }}");
    @endif

    @if ($errors->any())
    @foreach ($errors->all() as $error)
    toastr.error("{{ $error }}");
    @endforeach
    @endif
</script>
</body>
</html>
