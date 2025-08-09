@extends('dashboard.master')
@section('title', __('keys.newsLetters'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table datatables" id="dataTable-1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('keys.name') }}</th>
                                    <th>{{ __('keys.email') }}</th>
                                    <th>{{ __('keys.phone') }}</th>

                                </tr>
                                </thead>
                                <tbody>
                                @if (count($newsLetters) > 0)
                                    @foreach ($newsLetters as $newsLetter)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $newsLetter->name }}</td>
                                            <td>{{ $newsLetter->email }}</td>
                                            <td>{{ $newsLetter->phone }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="100%">
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
@endSection
