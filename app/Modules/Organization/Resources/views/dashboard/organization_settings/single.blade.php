@extends("organization::dashboard.master")
@section('title', __('organizations.edit_organization_setting'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">{{ __('organizations.edit_organization_setting') }}</strong>
                    </div>
                    <div class="card-body">
                        <<form action="{{ route('organization.organization_settings.update') }}"
                               method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST') {{-- بما إنك مستخدم POST مش PUT --}}
                            @include('organization::dashboard.organization_settings.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('logo');
            const preview = document.getElementById('logo-preview');
            const oldImageContainer = document.querySelector('.mb-3');

            input.addEventListener('change', function () {
                if (oldImageContainer) {
                    oldImageContainer.style.display = 'none';
                }

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
