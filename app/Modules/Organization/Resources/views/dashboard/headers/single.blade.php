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

