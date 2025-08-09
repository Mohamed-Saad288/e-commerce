@extends('admin::layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">{{ __('Dashboard') }}</h2>
        <div class="card">
            <div class="card-body">
                {{ __("You're logged in!") }}
            </div>
        </div>
    </div>
@endsection
