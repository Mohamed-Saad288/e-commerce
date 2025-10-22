<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<!-- Bootstrap Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Plugins -->
<script src="{{ asset('assets-admin/js/simplebar.min.js') }}"></script>
<script src="{{ asset('assets-admin/js/moment.min.js') }}"></script>
<script src="{{ asset('assets-admin/js/daterangepicker.js') }}"></script>
<script src="{{ asset('assets-admin/js/apps.js') }}"></script>

<!-- Toastr & SweetAlert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Summernote -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.js"></script>

<!-- تفعيل collapse -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('[data-toggle="collapse"]').forEach(trigger => {
            trigger.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.classList.toggle('show');
                    this.setAttribute('aria-expanded', target.classList.contains('show'));
                }
            });
        });
    });
</script>

<!-- تفعيل Summernote -->
<script>
    $(function () {
        if ($('.summernote').length) {
            $('.summernote').summernote({
                height: 200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview']]
                ]
            });
        }
    });
</script>

<script>
    $(document).ready(function () {
        $('.select2').each(function () {
            $(this).select2({
                theme: 'bootstrap4',
                width: '100%',
                dir: '{{ LaravelLocalization::getCurrentLocale() == 'ar' ? 'rtl' : 'ltr' }}',
                allowClear: true
            });
        });
    });
</script>

<style>





@yield('after_script')
