@extends("organization::dashboard.master")
@section('title', isset($term) ? __('organizations.edit_term') : __('organizations.add_term'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-term">
                        <strong class="card-title">{{ isset($term) ? __('term.edit_term') : __('term.add_term') }}</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($term) ? route('organization.terms.update', $term->id) : route('organization.terms.store') }}"
                              method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(isset($term))
                                @method('PUT')
                            @endif
                            @include('organization::dashboard.term.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
