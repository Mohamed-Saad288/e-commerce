@extends("dashboard.master")
@section('title', $job->exists ? __('jobs.edit_job') : __('jobs.add_job'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">{{ $job->exists ? __('jobs.edit_job') : __('jobs.add_job') }}</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ $job->exists ? route('admin.jobs.update', $job->id) :
                                route('admin.jobs.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if($job->exists)
                                @method('PUT')
                            @endif
                            @include('dashboard.jobs.form', [
                                'mainJobs' => $mainJobs
                            ])
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
