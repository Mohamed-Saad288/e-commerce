@extends("organization::dashboard.master")
@section('title', __('organizations.edit_terms'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-terms">
                        <strong class="card-title">{{ __('organizations.edit_terms') }}</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('organization.terms.update') }}"
                              method="POST" enctype="multipart/form-data">
                            @csrf

                            @include('organization::dashboard.terms.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

