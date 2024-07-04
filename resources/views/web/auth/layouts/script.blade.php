<!-- js file  -->
<script src="{{ asset('public/assets/js/jquery-3.7.0.min.js')}}"></script>
<script src="{{ asset('public/assets/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('public/assets/js/plugins.js')}}"></script>
<script src="{{ asset('public/assets/js/dataTables.js')}}"></script>
<script src="{{ asset('public/assets/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('public/assets/css/summernote/summernote-lite.min.js') }}"></script>
<script src="{{ asset('public/assets/js/lc_select.min.js') }}"></script>
<script src="{{ asset('public/assets/js/main.js')}}?ver={{ env('VERSION', 0) }}"></script>
<script src="{{ asset('public/common/js/common.js')}}?ver={{ env('VERSION' ,0) }}"></script>

@stack('script')

<script>

        document.addEventListener('DOMContentLoaded', function () {
        const togglePasswordButtons = document.querySelectorAll('.toggle-password');

        togglePasswordButtons.forEach(button => {
        button.addEventListener('click', function () {
        const passwordInput = this.previousElementSibling;

        if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        this.innerHTML = '<i class="fa fa-eye-slash"></i>';
    } else {
        passwordInput.type = 'password';
        this.innerHTML = '<i class="fa fa-eye"></i>';
    }
    });
    });
    });

	{{--var currencySymbol = "{{ getCurrencySymbol() }}";--}}
	{{--var currencyPlacement = "{{ getCurrencyPlacement() }}";--}}

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

	@if (@$errors->any())
	@foreach ($errors->all() as $error)
	toastr.error("{{ $error }}");
	@endforeach
	@endif
</script>
