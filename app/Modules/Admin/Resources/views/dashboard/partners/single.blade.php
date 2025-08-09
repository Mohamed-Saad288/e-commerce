@extends("dashboard.master")
@section('title', $partner->exists ? __('partner.edit_partner') : __('partner.add_partner'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">{{ $partner->exists ? __('partner.edit_partner') : __('partner.add_partner') }}</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ $partner->exists ? route('admin.partners.update', $partner->id) : route('admin.partners.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if($partner->exists)
                                @method('PUT')
                            @endif
                            @include('dashboard.partners.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
