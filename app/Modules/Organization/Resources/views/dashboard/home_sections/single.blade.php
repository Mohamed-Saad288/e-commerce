@extends('organization::dashboard.master')
@section('title', isset($home_section) ? __('organizations.edit_home_section') : __('organizations.add_home_section'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong
                            class="card-title">{{ isset($home_section) ? __('organizations.edit_home_section') : __('organizations.add_home_section') }}</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($home_section) ? route('organization.home_sections.update', $home_section->id) :
                                route('organization.home_sections.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(isset($home_section))
                                @method('PUT')
                            @endif
                            @include('organization::dashboard.home_sections.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleCustomFields() {
            let type = document.getElementById('type').value;
            let customFields = document.getElementById('custom-fields');
            let templateType = document.getElementById('template_type');
            if (type == {{ \App\Modules\Organization\Enums\HomeSection\HomeSectionTypeEnum::Custom->value }}) {
                customFields.style.display = 'block';
                templateType.style.display = 'block';
            } else {
                customFields.style.display = 'none';
                templateType.style.display = 'none';
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            toggleCustomFields();
            document.getElementById('type').addEventListener('change', toggleCustomFields);

        });
    </script>

@endsection
