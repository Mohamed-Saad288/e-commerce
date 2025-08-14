@extends("dashboard.master")
@section('title', isset($blog) ? __('blogs.edit_blog') : __('blogs.add_blog'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong
                            class="card-title">{{ isset($blog) ? __('blogs.edit_blog') : __('blogs.add_blog') }}</strong>
                    </div>
                    <div class="card-body">
                        @include('dashboard.Blog.form', [
                            "route" => isset($blog) ?  route('admin.blogs.update', ['blog' => $blog->id]) : route('admin.blogs.store') ,
                            "blog" => $blog ?? null,
                            "method" => isset($blog) ? "PUT" : "POST"
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
