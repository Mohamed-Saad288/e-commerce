@extends("organization::dashboard.master")
@section('title', isset($question) ? __('organizations.edit_question') : __('organizations.add_question'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-question">
                        <strong class="card-title">{{ isset($question) ? __('organizations.edit_question') : __('organizations.add_question') }}</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($question) ? route('organization.questions.update', $question->id) : route('organization.questions.store') }}"
                              method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(isset($question))
                                @method('PUT')
                            @endif
                            @include('organization::dashboard.question.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
