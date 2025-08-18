@extends("organization::dashboard.master")
@section('title', isset($why) ? __('organizations.edit_why') : __('organizations.add_why'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-why">
                        <strong class="card-title">{{ isset($why) ? __('why.edit_why') : __('why.add_why') }}</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($why) ? route('organization.whys.update', $why->id) : route('organization.whys.store') }}"
                              method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(isset($why))
                                @method('PUT')
                            @endif
                            @include('organization::dashboard.why.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
