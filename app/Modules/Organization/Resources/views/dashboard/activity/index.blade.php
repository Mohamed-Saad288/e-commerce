@extends('dashboard.master')

    @section('title', __('keys.activity_log'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ __('keys.activity_log') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table datatables" id="dataTable-1">
                                    <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('keys.causer') }}</th>
                                    <th>{{ __('keys.description') }}</th>
                                    <th>{{ __('keys.date') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (count($activities) > 0)
                                    @foreach ($activities as $activity)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $activity->causer ? $activity->causer->name : 'Admin' }}</td>
                                            <td>   @if(App::isLocale('ar'))
                                                    {{ $activity->description_ar }}
                                                @else
                                                    {{ $activity->description_en }}
                                                @endif
                                            </td>
                                            <td>{{ $activity->created_at }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6">
                                            <div class="no-data">
                                                <img src="{{ asset('no-data.png') }}" alt="No Data Found">
                                                <p>{{ __('keys.no_data') }}</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


