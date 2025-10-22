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
