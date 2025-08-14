@extends("dashboard.master")
@section('title', $work->exists ? __('work.edit_work') : __('work.add_work'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">{{ $work->exists ? __('work.edit_work') : __('work.add_work') }}</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ $work->exists ? route('admin.works.update', $work->id) : route('admin.works.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if($work->exists)
                                @method('PUT')
                            @endif
                            @include('dashboard.works.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
