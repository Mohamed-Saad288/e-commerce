<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Plugins -->
<script src="{{ asset('assets-admin/js/simplebar.min.js') }}"></script>
<script src="{{ asset('assets-admin/js/moment.min.js') }}"></script>
<script src="{{ asset('assets-admin/js/daterangepicker.js') }}"></script>

<!-- إصلاح جميع المتغيرات الناقصة قبل apps.js -->
<script>
    // إصلاح جميع المتغيرات والدوال الناقصة
    (function($) {
        // إصلاح base
        if (typeof base === 'undefined') {
            window.base = {
                url: '{{ url("/") }}',
                asset: '{{ asset("") }}'
            };
        }

        // إصلاح colors
        if (typeof colors === 'undefined') {
            window.colors = {
                primary: '#6366f1',
                secondary: '#6c757d',
                success: '#10b981',
                danger: '#ef4444',
                warning: '#f59e0b',
                info: '#3b82f6',
                light: '#f8f9fa',
                dark: '#1f2937'
            };
        }

        // إصلاح stickOnScroll
        if (typeof $.fn.stickOnScroll === 'undefined') {
            $.fn.stickOnScroll = function(options) {
                console.log('stickOnScroll: Fallback activated');
                var defaults = {
                    scrollTop: 50,
                    scrollBottom: 50,
                    zIndex: 1020,
                    parent: 'body',
                    offsetTop: 0,
                    offsetBottom: 0
                };
                var settings = $.extend({}, defaults, options);

                return this.each(function() {
                    var $element = $(this);
                    var originalTop = $element.offset().top;
                    var originalLeft = $element.offset().left;

                    $(window).on('scroll.stickOnScroll', function() {
                        var scrollTop = $(window).scrollTop();
                        var windowHeight = $(window).height();
                        var documentHeight = $(document).height();

                        if (scrollTop >= settings.scrollTop &&
                            scrollTop <= documentHeight - windowHeight - settings.scrollBottom) {
                            $element.css({
                                'position': 'fixed',
                                'top': settings.offsetTop + 'px',
                                'left': originalLeft + 'px',
                                'z-index': settings.zIndex,
                                'width': $element.outerWidth() + 'px'
                            });
                        } else {
                            $element.css({
                                'position': '',
                                'top': '',
                                'left': '',
                                'z-index': '',
                                'width': ''
                            });
                        }
                    });
                });
            };
        }

        // إصلاح دوال أخرى قد تكون ناقصة
        if (typeof $.fn.animateProgress === 'undefined') {
            $.fn.animateProgress = function(progress, callback) {
                return this.each(function() {
                    $(this).animate({ width: progress + '%' }, 500, callback);
                });
            };
        }

    })(jQuery);
</script>

<!-- الآن يمكن تحميل apps.js -->
<script src="{{ asset('assets-admin/js/apps.js') }}"></script>

<!-- باقي المكتبات -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.js"></script>

<!-- Scripts الأساسية -->
<script>
    // تفعيل collapse
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(trigger => {
            trigger.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('data-bs-target') || this.getAttribute('href'));
                if (target) {
                    target.classList.toggle('show');
                    this.setAttribute('aria-expanded', target.classList.contains('show'));
                }
            });
        });
    });

    // تفعيل Summernote
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

    // تفعيل Select2
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

    // Fullscreen functionality
    $(function () {
        const fullscreenButton = $('.fullscreen-toggle');
        const fullscreenIcon = fullscreenButton.find('i');

        fullscreenButton.on('click', function () {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().then(() => {
                    fullscreenIcon.removeClass('fe-maximize').addClass('fe-minimize');
                });
            } else {
                document.exitFullscreen().then(() => {
                    fullscreenIcon.removeClass('fe-minimize').addClass('fe-maximize');
                });
            }
        });
    });

    // Toastr options
    toastr.options = {
        "progressBar": true,
        "timeOut": 3000,
        "extendedTimeOut": 2000
    };
</script>

@yield('after_script')
