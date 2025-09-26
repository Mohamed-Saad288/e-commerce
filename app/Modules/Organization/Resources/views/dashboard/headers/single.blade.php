@extends("organization::dashboard.master")
@section('title', __('organizations.edit_header'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">{{ __('organizations.edit_header') }}</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('organization.headers.update') }}"
                              method="POST" enctype="multipart/form-data">
                            @csrf
                            {{-- لو انت مستخدم PUT --}}
                            {{-- @method('PUT') --}}

                            {{-- صورة قديمة --}}
                            @if(isset($header) && $header->image)
                                <div class="mb-3" id="old-image-container">
                                    <img src="{{ asset('storage/' . $header->image) }}"
                                         alt="Old Image"
                                         class="img-thumbnail"
                                         width="150">
                                </div>
                            @endif

                            {{-- مكان المعاينة الجديدة --}}
                            <div id="image-preview"></div>

                            @include('organization::dashboard.headers.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- ================= STYLES ================= --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css">

{{-- ================= SCRIPTS ================= --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.js"></script>

<script>
    $(function () {
        // Summernote init
        $('.summernote').summernote({
            height: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });

        // Preview images
        const input = document.getElementById('images');
        const preview = document.getElementById('images-preview');
        const oldImagesContainer = document.getElementById('old-images-container');

        if (input) {
            input.addEventListener('change', function () {
                if (oldImagesContainer) {
                    oldImagesContainer.style.display = 'none';
                }
                preview.innerHTML = '';
                if (this.files && this.files.length > 0) {
                    Array.from(this.files).forEach(file => {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'img-thumbnail mt-2';
                            img.width = 150;
                            preview.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    });
                }
            });
        }
    });
</script>
