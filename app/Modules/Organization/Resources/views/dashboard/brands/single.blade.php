@extends('organization::dashboard.master')
@section('title', isset($brand) ? __('organizations.edit_brand') : __('organizations.add_brand'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong
                            class="card-title">{{ isset($brand) ? __('organizations.edit_brand') : __('organizations.add_brand') }}</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($brand) ? route('organization.brands.update', $brand->id) :
                                route('organization.brands.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(isset($brand))
                                @method('PUT')
                            @endif
                            @include('organization::dashboard.brands.form')
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
