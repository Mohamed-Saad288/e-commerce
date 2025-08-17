@extends("organization::dashboard.master")
@section('title', $header->exists ? __('header.edit_header') : __('header.add_header'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">{{ isset($header) ? __('header.edit_header') : __('header.add_header') }}</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($header) ? route('organization.headers.update', $header->id) : route('organization.headers.store') }}"
                              method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(isset($header))
                                @method('PUT')
                            @endif
                            @include('organization::dashboard.header.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
