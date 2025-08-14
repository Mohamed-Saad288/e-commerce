@extends("dashboard.master")
@section('title', $offer->exists ? __('offers.edit_offers') : __('offers.add_offer'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">{{ $offer->exists ? __('offers.edit_offer') : __('offers.add_offer') }}</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ $offer->exists ? route('admin.offers.update', $offer->id) : route('admin.offers.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if($offer->exists)
                                @method('PUT')
                            @endif
                            @include('dashboard.offer.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
