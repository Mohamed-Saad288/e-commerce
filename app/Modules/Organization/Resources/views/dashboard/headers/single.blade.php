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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const input = document.getElementById('images');
            const previewContainer = document.getElementById('images-preview');

            input.addEventListener('change', function() {
                previewContainer.innerHTML = '';

                Array.from(this.files).forEach(file => {
                    if (!file.type.startsWith('image/')) return;

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('img-thumbnail');
                        img.style.width = '150px';
                        img.style.marginRight = '10px';
                        previewContainer.appendChild(img);
                    }
                    reader.readAsDataURL(file);
                });
            });
        });
    </script>

@endsection

