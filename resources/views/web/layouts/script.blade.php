<!-- js file  -->
<script src="{{ asset('public/frontend/js/jquery-3.7.0.min.js') }}"></script>
<script src="{{ asset('public/frontend/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/frontend/js/plugins.js') }}"></script>
<script src="{{ asset('public/frontend/js/main.js') }}"></script>
<script src="{{ asset('public/common/js/common.js') }}"></script>

@stack('script')

<script>
    {{--var currencySymbol = "{{ getCurrencySymbol() }}";--}}
    {{--var currencyPlacement = "{{ getCurrencyPlacement() }}";--}}

    @if (Session::has('success'))
        toastr.success("{{ session('success') }}");
    @endif
    @if (Session::has('error'))
        toastr.error("{{ session('error') }}");
    @endif
    @if (Session::has('info'))
        toastr.info("{{ session('info') }}");
    @endif
    @if (Session::has('warning'))
        toastr.warning("{{ session('warning') }}");
    @endif

    @if (@$errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif
</script>
