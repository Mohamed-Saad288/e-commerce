@if(session('message') && session('alert-type') == 'success')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            toastr.success("{{ session('message') }}");
        });
    </script>
@endif

@if(session('message') && session('alert-type') == 'error')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            toastr.error("{{ session('message') }}");
        });
    </script>
@endif
