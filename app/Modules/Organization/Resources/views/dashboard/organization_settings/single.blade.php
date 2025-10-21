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
                        <form action="{{ route('organization.organization_settings.update') }}"
                              method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            @include('organization::dashboard.organization_settings.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ===== Logo Preview =====
            const logoInput = document.getElementById('logo');
            const logoPreview = document.getElementById('logo-preview');
            const oldLogoContainer = document.querySelector('.mb-3 img[alt="Organization Logo"]')?.parentElement;

            logoInput?.addEventListener('change', function () {
                if (oldLogoContainer) oldLogoContainer.style.display = 'none';
                logoPreview.innerHTML = '';
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'img-thumbnail mt-2';
                        img.width = 150;
                        logoPreview.appendChild(img);
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // ===== Breadcrumb Image Preview =====
            const breadcrumbInput = document.getElementById('breadcrumb_image');
            const breadcrumbPreview = document.createElement('div');
            breadcrumbPreview.id = 'breadcrumb-preview';
            breadcrumbInput.closest('.form-group').appendChild(breadcrumbPreview);

            const oldBreadcrumbContainer = document.querySelector('.mb-3 img[alt="Organization breadcrumb_image"]')?.parentElement;

            breadcrumbInput?.addEventListener('change', function () {
                if (oldBreadcrumbContainer) oldBreadcrumbContainer.style.display = 'none';
                breadcrumbPreview.innerHTML = '';
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'img-thumbnail mt-2';
                        img.width = 150;
                        breadcrumbPreview.appendChild(img);
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>
@endsection
