<script src="{{ asset('assets-admin') }}/js/jquery.min.js"></script>
<script src="{{ asset('assets-admin') }}/js/popper.min.js"></script>
<script src="{{ asset('assets-admin') }}/js/moment.min.js"></script>
<script src="{{ asset('assets-admin') }}/js/bootstrap.min.js"></script>
<script src="{{ asset('assets-admin') }}/js/simplebar.min.js"></script>
<script src='{{ asset('assets-admin') }}/js/daterangepicker.js'></script>
<script src='{{ asset('assets-admin') }}/js/jquery.stickOnScroll.js'></script>
<script src="{{ asset('assets-admin') }}/js/tinycolor-min.js"></script>
<script src="{{ asset('assets-admin') }}/js/config.js"></script>
<script src="{{ asset('assets-admin') }}/js/d3.min.js"></script>
<script src="{{ asset('assets-admin') }}/js/topojson.min.js"></script>
<script src="{{ asset('assets-admin') }}/js/datamaps.all.min.js"></script>
<script src="{{ asset('assets-admin') }}/js/datamaps-zoomto.js"></script>
<script src="{{ asset('assets-admin') }}/js/datamaps.custom.js"></script>
<script src="{{ asset('assets-admin') }}/js/Chart.min.js"></script>
<script src='{{ asset('assets-admin') }}/js/jquery.dataTables.min.js'></script>
<script src='{{ asset('assets-admin') }}/js/dataTables.bootstrap4.min.js'></script>
<script>
    /* defind global options */
    Chart.defaults.global.defaultFontFamily = base.defaultFontFamily;
    Chart.defaults.global.defaultFontColor = colors.mutedColor;
</script>
<script src="{{ asset('assets-admin') }}/js/gauge.min.js"></script>
<script src="{{ asset('assets-admin') }}/js/jquery.sparkline.min.js"></script>
<script src="{{ asset('assets-admin') }}/js/apexcharts.min.js"></script>
<script src="{{ asset('assets-admin') }}/js/apexcharts.custom.js"></script>
<script src='{{ asset('assets-admin') }}/js/jquery.mask.min.js'></script>
<script src='{{ asset('assets-admin') }}/js/select2.min.js'></script>
<script src='{{ asset('assets-admin') }}/js/jquery.steps.min.js'></script>
<script src='{{ asset('assets-admin') }}/js/jquery.validate.min.js'></script>
<script src='{{ asset('assets-admin') }}/js/jquery.timepicker.js'></script>
<script src='{{ asset('assets-admin') }}/js/dropzone.min.js'></script>
<script src='{{ asset('assets-admin') }}/js/uppy.min.js'></script>
<script src='{{ asset('assets-admin') }}/js/quill.min.js'></script>
{{-- <script src='{{ asset('js/tinymce.min.js') }}'></script> --}}
<script src='{{ asset('tinymce/tinymce.min.js') }}'></script>
<script src='{{ asset('tinymce/license.md') }}'></script>
<script src='{{ asset('tinymce/plugins/accordion/plugin.min.js') }}'></script>
<script src='{{ asset('tinymce/plugins/anchor/plugin.min.js') }}'></script>

<!-- Include TinyMCE from CDN with your API key -->
<script src="https://cdn.tiny.cloud/1/k8dwstiekcrjck6aozkmljqjihrqx0zdkduu2wa3iooc354r/tinymce/5/tinymce.min.js"
    referrerpolicy="origin"></script>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

{{-- sweet alert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script src='{{ asset('assets-admin') }}/js/jquery.dataTables.min.js'></script>
<script src='{{ asset('assets-admin') }}/js/dataTables.bootstrap4.min.js'></script>
<script src="{{ asset('assets-admin') }}/js/apps.js"></script>


<script>
    $('.select2').select2({
        theme: 'bootstrap4',
    });
    $('.select2-multi').select2({
        multiple: true,
        theme: 'bootstrap4',
    });
    $('.drgpicker').daterangepicker({
        singleDatePicker: true,
        timePicker: false,
        showDropdowns: true,
        locale: {
            format: 'MM/DD/YYYY'
        }
    });
    $('.time-input').timepicker({
        'scrollDefault': 'now',
        'zindex': '9999' /* fix modal open */
    });
    /** date range picker */
    if ($('.datetimes').length) {
        $('.datetimes').daterangepicker({
            timePicker: true,
            startDate: moment().startOf('hour'),
            endDate: moment().startOf('hour').add(32, 'hour'),
            locale: {
                format: 'M/DD hh:mm A'
            }
        });
    }
    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                'month')]
        }
    }, cb);
    cb(start, end);
    $('.input-placeholder').mask("00/00/0000", {
        placeholder: "__/__/____"
    });
    $('.input-zip').mask('00000-000', {
        placeholder: "____-___"
    });
    $('.input-money').mask("#.##0,00", {
        reverse: true
    });
    $('.input-phoneus').mask('(000) 000-0000');
    $('.input-mixed').mask('AAA 000-S0S');
    $('.input-ip').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
        translation: {
            'Z': {
                pattern: /[0-9]/,
                optional: true
            }
        },
        placeholder: "___.___.___.___"
    });
    // editor
    var editor = document.getElementById('editor');
    if (editor) {
        var toolbarOptions = [
            [{
                'font': []
            }],
            [{
                'header': [1, 2, 3, 4, 5, 6, false]
            }],
            ['bold', 'italic', 'underline', 'strike'],
            ['blockquote', 'code-block'],
            [{
                    'header': 1
                },
                {
                    'header': 2
                }
            ],
            [{
                    'list': 'ordered'
                },
                {
                    'list': 'bullet'
                }
            ],
            [{
                    'script': 'sub'
                },
                {
                    'script': 'super'
                }
            ],
            [{
                    'indent': '-1'
                },
                {
                    'indent': '+1'
                }
            ], // outdent/indent
            [{
                'direction': 'rtl'
            }], // text direction
            [{
                    'color': []
                },
                {
                    'background': []
                }
            ], // dropdown with defaults from theme
            [{
                'align': []
            }],
            ['clean'] // remove formatting button
        ];
        var quill = new Quill(editor, {
            modules: {
                toolbar: toolbarOptions
            },
            theme: 'snow'
        });
    }
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
<script>
    var uptarg = document.getElementById('drag-drop-area');
    if (uptarg) {
        var uppy = Uppy.Core().use(Uppy.Dashboard, {
            inline: true,
            target: uptarg,
            proudlyDisplayPoweredByUppy: false,
            theme: 'dark',
            width: 770,
            height: 210,
            plugins: ['Webcam']
        }).use(Uppy.Tus, {
            endpoint: 'https://master.tus.io/files/'
        });
        uppy.on('complete', (result) => {
            console.log('Upload complete! We’ve uploaded these files:', result.successful)
        });
    }
</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>

<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());
    gtag('config', 'UA-56159088-1');
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector(".custom-file-input").addEventListener("change", function(e) {
            let fileName = e.target.files[0] ? e.target.files[0].name : "{{ __('keys.choose_file') }}";
            e.target.nextElementSibling.innerText = fileName;
        });
    });
</script>


{{-- ///// toastr --}}
<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
        "closeMethod": "fadeOut"
    };

    function showSuccessMessage(message) {
        toastr.success(message, 'Success', {
            "iconClass": "toast-success",
            "toastClass": "custom-toast",
        });
    }

    function showErrorMessage(message) {
        toastr.error(message, 'Error', {
            "iconClass": "toast-error",
            "toastClass": "custom-toast-error",
        });
    }
</script>

{{--<script>--}}
{{--    @if (Session::has('message'))--}}
{{--        var type = "{{ Session::get('alert-type', 'info') }}"--}}
{{--        switch (type) {--}}
{{--            case 'info':--}}

{{--                toastr.options.timeOut = 10000;--}}
{{--                toastr.info("{{ Session::get('message') }}");--}}
{{--                var audio = new Audio('audio.mp3');--}}
{{--                audio.play();--}}
{{--                break;--}}
{{--            case 'success':--}}

{{--                toastr.options.timeOut = 10000;--}}
{{--                toastr.success("{{ Session::get('message') }}");--}}
{{--                var audio = new Audio('audio.mp3');--}}
{{--                audio.play();--}}

{{--                break;--}}
{{--            case 'warning':--}}

{{--                toastr.options.timeOut = 10000;--}}
{{--                toastr.warning("{{ Session::get('message') }}");--}}
{{--                var audio = new Audio('audio.mp3');--}}
{{--                audio.play();--}}

{{--                break;--}}
{{--            case 'error':--}}

{{--                toastr.options.timeOut = 10000;--}}
{{--                toastr.error("{{ Session::get('message') }}");--}}
{{--                var audio = new Audio('audio.mp3');--}}
{{--                audio.play();--}}

{{--                break;--}}
{{--        }--}}
{{--    @endif--}}
{{--</script>--}}


{{--<script>--}}
{{--    document.addEventListener("DOMContentLoaded", function() {--}}
{{--        // Initialize TinyMCE for description fields in all locales--}}
{{--        tinymce.init({--}}
{{--            selector: 'textarea.tinymce-editor',--}}
{{--            height: 300,--}}
{{--            plugins: [--}}
{{--                'advlist autolink lists link image charmap print preview hr anchor pagebreak',--}}
{{--                'searchreplace wordcount visualblocks visualchars code fullscreen',--}}
{{--                'insertdatetime media nonbreaking save table directionality',--}}
{{--                'emoticons template paste textpattern imagetools'--}}
{{--            ],--}}
{{--            toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media',--}}
{{--            toolbar2: 'print preview media | forecolor backcolor emoticons',--}}
{{--            image_advtab: true,--}}
{{--            content_css: [--}}
{{--                '//www.tiny.cloud/css/codepen.min.css'--}}
{{--            ]--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}

{{--<script>--}}
{{--    document.addEventListener("DOMContentLoaded", function() {--}}
{{--        const imageInputs = document.querySelectorAll("input[type='file']");--}}

{{--        imageInputs.forEach(input => {--}}
{{--            const previewContainer = document.createElement("div");--}}
{{--            previewContainer.className = "image-preview mt-2";--}}
{{--            previewContainer.id = input.id + "-preview";--}}
{{--            input.parentNode.appendChild(previewContainer);--}}

{{--            let selectedFiles = [];--}}

{{--            input.addEventListener("change", function(event) {--}}
{{--                const newFiles = Array.from(input.files);--}}
{{--                const dataTransfer = new DataTransfer();--}}
{{--                previewContainer.innerHTML = ""; // Clear previous previews--}}

{{--                newFiles.forEach(file => {--}}
{{--                    if (!selectedFiles.some(existingFile => existingFile.name === file--}}
{{--                            .name && existingFile.size === file.size)) {--}}
{{--                        selectedFiles.push(file);--}}

{{--                        const reader = new FileReader();--}}
{{--                        reader.onload = function(e) {--}}
{{--                            const imgContainer = document.createElement("div");--}}
{{--                            imgContainer.className =--}}
{{--                                "image-container position-relative d-inline-block m-2";--}}

{{--                            const img = document.createElement("img");--}}
{{--                            img.src = e.target.result;--}}
{{--                            img.className = "img-thumbnail";--}}
{{--                            img.style.width = "50";--}}
{{--                            img.style.height = "50";--}}

{{--                            const removeBtn = document.createElement("div");--}}
{{--                            removeBtn.className =--}}
{{--                                "remove-image btn btn-danger btn-sm position-absolute";--}}
{{--                            removeBtn.innerHTML = "✖";--}}
{{--                            removeBtn.style.top = "5px";--}}
{{--                            removeBtn.style.right = "5px";--}}
{{--                            removeBtn.style.cursor = "pointer";--}}

{{--                            removeBtn.onclick = function() {--}}
{{--                                imgContainer.remove();--}}
{{--                                removeFileFromSelection(file, input);--}}
{{--                            };--}}

{{--                            imgContainer.appendChild(img);--}}
{{--                            imgContainer.appendChild(removeBtn);--}}
{{--                            previewContainer.appendChild(imgContainer);--}}
{{--                        };--}}
{{--                        reader.readAsDataURL(file);--}}
{{--                    }--}}
{{--                });--}}

{{--                selectedFiles.forEach(file => dataTransfer.items.add(file));--}}
{{--                input.files = dataTransfer.files;--}}
{{--            });--}}

{{--            function removeFileFromSelection(fileToRemove, inputElement) {--}}
{{--                selectedFiles = selectedFiles.filter(file => file.name !== fileToRemove.name || file--}}
{{--                    .size !== fileToRemove.size);--}}

{{--                const dataTransfer = new DataTransfer();--}}
{{--                selectedFiles.forEach(file => dataTransfer.items.add(file));--}}
{{--                inputElement.files = dataTransfer.files;--}}
{{--            }--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}

<script>
    $('#dataTable-1').DataTable({
        autoWidth: true,
        "lengthMenu": [
            [10, 16, 32, 64, -1],
            [10, 16, 32, 64, "All"]
        ]
    });
</script>
