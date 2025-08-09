@extends("dashboard.master")
@section('title', $slider->exists ? __('slider.edit_slider') : __('slider.add_slider'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">{{ $slider->exists ? __('slider.edit_slider') : __('slider.add_slider') }}</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ $slider->exists ? route('admin.sliders.update', $slider->id) : route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if($slider->exists)
                                @method('PUT')
                            @endif
                            @include('dashboard.sliders.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
