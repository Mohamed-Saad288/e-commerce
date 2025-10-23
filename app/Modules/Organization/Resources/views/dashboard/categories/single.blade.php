@extends('organization::dashboard.master')
@section('title', isset($category) ? __('organizations.edit_category') : __('organizations.add_category'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong
                            class="card-title">{{ isset($category) ? __('organizations.edit_category') : __('organizations.add_category') }}</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($category) ? route('organization.categories.update', $category->id) :
                                route('organization.categories.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(isset($category))
                                @method('PUT')
                            @endif
                            @include('organization::dashboard.categories.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('image');
            const preview = document.getElementById('image-preview');
            const oldImageContainer = document.querySelector('.mb-3'); // الكونتينر اللي فيه الصورة القديمة

            input.addEventListener('change', function () {
                // امسح أي صورة قديمة معروضة
                if (oldImageContainer) {
                    oldImageContainer.style.display = 'none';
                }

                // امسح أي معاينة قديمة
                preview.innerHTML = '';

                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'img-thumbnail mt-2';
                        img.width = 150;
                        preview.appendChild(img);
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>
@endsection
