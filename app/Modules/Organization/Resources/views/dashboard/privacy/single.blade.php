@extends("organization::dashboard.master")
@section('title', __('organizations.edit_privacy'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-privacy">
                        <strong class="card-title">{{ __('organizations.edit_privacy') }}</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('organization.privacy.update') }}"
                              method="POST" enctype="multipart/form-data">
                            @csrf

                            @include('organization::dashboard.privacy.form')
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
    });
</script>
