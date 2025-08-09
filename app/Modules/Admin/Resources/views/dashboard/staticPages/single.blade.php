@extends("dashboard.master")
@section('title', $staticPage->exists ? __('staticPage.edit_staticPage') : __('staticPage.add_staticPage'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">{{ $staticPage->exists ? __('staticPage.edit_staticPage') : __('staticPage.add_staticPage') }}</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ $staticPage->exists ? route('admin.static_pages.update', $staticPage->id) : route('admin.static_pages.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if($staticPage->exists)
                                @method('PUT')
                            @endif
                            @include('dashboard.staticPages.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
