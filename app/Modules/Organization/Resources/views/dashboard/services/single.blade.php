@extends("dashboard.master")
@section('title', $service->exists ? __('service.edit_service') : __('service.add_service'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">{{ $service->exists ? __('service.edit_service') : __('service.add_service') }}</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ $service->exists ? route('admin.services.update', $service->id) :
                                route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if($service->exists)
                                @method('PUT')
                            @endif
                            @include('dashboard.services.form', [
                                'parentServices' => $parentServices
                            ])
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
