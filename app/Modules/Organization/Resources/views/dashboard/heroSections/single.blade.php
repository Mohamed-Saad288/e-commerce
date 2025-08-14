@extends("dashboard.master")
@section('title', $heroSection->exists ? __('heroSection.edit_heroSection') : __('heroSection.add_heroSection'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">{{ $heroSection->exists ? __('heroSection.edit_heroSection') : __('heroSection.add_heroSection') }}</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ $heroSection->exists ? route('admin.hero_sections.update', $heroSection->id) : route('admin.hero_sections.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if($heroSection->exists)
                                @method('PUT')
                            @endif
                            @include('dashboard.heroSections.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
