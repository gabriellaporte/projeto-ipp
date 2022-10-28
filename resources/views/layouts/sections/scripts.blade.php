<!-- BEGIN: Vendor JS-->

<script src="{{ asset(mix('assets/vendor/js/bootstrap.js')) }}"></script>
<script src="{{ asset(mix('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')) }}"></script>
<script src="{{ asset(mix('assets/vendor/js/menu.js')) }}"></script>
@yield('vendor-script')
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="{{ asset(mix('assets/js/main.js')) }}"></script>

<!-- END: Theme JS-->
<!-- Pricing Modal JS-->
@stack('pricing-script')
<!-- END: Pricing Modal JS-->
<!-- BEGIN: Page JS-->
@yield('page-script')
<!-- END: Page JS-->

<!-- BEGIN: Toastr -->
<script>
  $(document).ready( () => {
    @if(count($errors))
      @foreach($errors->all() as $error)
        toastr.error('{{ $error }}');
        @php session()->forget('errors') @endphp
      @endforeach
    @endif

    @if(session('success'))
      toastr.success('{{ session('success') }}');
      @php session()->forget('success') @endphp
    @endif

    @if(session('warning'))
      toastr.warning('{{ session('warning') }}');
      @php session()->forget('warning') @endphp
    @endif

    @if(session('info'))
      toastr.info('{{ session('info') }}');
      @php session()->forget('info') @endphp
    @endif
  });
</script>
<!-- END: Toastr -->

<!-- BEGIN: jQuery Mask -->
<script>
  $(document).ready( ($) => {
    $('.phone-mask').mask('(00) 0 0000-0000');
    $('.housephone-mask').mask('(00) 0000-0000');
    $('.date-mask').mask('00/00/0000');
    $('.cep-mask').mask('00000-000');
  });
</script>
<!-- END: jQuery Mask -->

<!-- BEGIN: Loader -->
<script>
  $(window).on('load', () => {
    setTimeout(() => {
      $('.loader').fadeOut(1000);
      $('.layout-wrapper').fadeIn(1000);
    }, 700);
  });
</script>
<!-- END: Loader -->

<!-- BEGIN: Dropdown Responsive Table -->
<script>
  $('.table-responsive').on('show.bs.dropdown', function () {
    $('.table-responsive').css( "overflow", "inherit" );
  });

  $('.table-responsive').on('hide.bs.dropdown', function () {
    $('.table-responsive').css( "overflow", "auto" );
  })
</script>
<!-- END: Dropdown Responsive Table -->
