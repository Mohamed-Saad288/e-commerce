@extends('organization::dashboard.master')
@section('title', __('organizations.abouts'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-about d-flex justify-content-between align-items-center">
                        <h2 class="h5 page-title">{{ __("organizations.abouts") }} </h2>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table datatables" id="dataTable-1">
                                <thead>
                                <tr>

                                    <th></th>
                                    <th>#</th>
                                    <th>{{ __('messages.title') }}</th>
                                    <th>{{ __('messages.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (count($abouts) > 0)
                                    @foreach($abouts as $about)
                                        <tr>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input">
                                                    <label class="custom-control-label"></label>
                                                </div>
                                            </td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{$about->name}}</td>
                                            <td style="width:10%">
                                                @can('update_about')
                                                <a href="{{ route('organization.abouts.edit', $about->id) }}" class="btn btn-sm btn-success">
                                                    <i class='fe fe-edit fa-2x'></i>
                                                </a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan ="100%">
                                            <div class="alert alert-danger">
                                                {{ __('messages.no_found_records') }}
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
@endSection


