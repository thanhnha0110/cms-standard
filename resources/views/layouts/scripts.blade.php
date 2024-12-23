<!--begin::Global Theme Bundle -->
<script src="{{ asset('assets/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/demo/default/base/scripts.bundle.js') }}" type="text/javascript"></script>
<!--end::Global Theme Bundle -->

<!--begin::Tags Styles -->
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script>
    document.querySelectorAll('input[id^="tags"]').forEach(function (input) {
        new Tagify(input);
    });
</script>  
<!--end::Tags Styles -->



<!--begin::Notices -->
@if (session('success'))
    <script>
        $(document).ready(function() {
            toastr.success('{{ session('success') }}', 'Success')
        });
    </script>
@endif

@if (session('error'))
    <script>
        $(document).ready(function() {
            toastr.error('{{ session('error') }}', 'Error')
        });
    </script>
@endif

@if (session('warning'))
    <script>
        $(document).ready(function() {
            toastr.warning('{{ session('warning') }}', 'Warning')
        });
    </script>
@endif

@if ($errors->any())
    <script>
        $(document).ready(function() {
            toastr.error('{{ $errors->first() }}', 'Error')
        });
    </script>
@endif
<!--end::Notices -->

<script>
    function filter(elm) {
    let value = elm.value;
    let key = elm.id;
    const url = new URL(window.location.href);
    url.searchParams.set(key, value);
    window.location.href = url;
}
</script>

@yield('scripts')