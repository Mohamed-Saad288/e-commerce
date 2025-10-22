@extends('organization::dashboard.master')
@section('title', __('organizations.subcategories'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">
                            {{ __('organizations.subcategories_for') }}: {{ $parent->translate(app()->getLocale())->name }}
                        </h4>
                        <a href="{{ route('organization.categories.create', ['parent_id' => $parent->id]) }}"
                           class="btn btn-primary">
                            {{ __('organizations.add_subcategory') }}
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table datatables">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('messages.name') }}</th>
                                    <th>{{ __('messages.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if ($subCategories->count() > 0)
                                    @foreach ($subCategories as $sub)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $sub->translate(app()->getLocale())->name }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('organization.categories.edit', $sub->id) }}"
                                                       class="btn btn-sm btn-success" title="{{ __('messages.edit') }}">
                                                        <i class='fe fe-edit'></i>
                                                    </a>

                                                    @if($sub->subCategories->count() > 0)
                                                        <a href="{{ route('organization.categories.subcategories', $sub->id) }}"
                                                           class="btn btn-sm btn-info" title="{{ __('messages.view') }}">
                                                            <i class="fe fe-eye"></i>
                                                        </a>
                                                    @endif
                                                    @if($sub->subCategories->count() == 0)

                                                    <button class="btn btn-sm btn-danger delete-category"
                                                            data-id="{{ $sub->id }}" title="{{ __('messages.delete') }}">
                                                        <i class="fe fe-trash-2"></i>
                                                    </button>
                                                    @endif
                                                    <a href="{{ route('organization.categories.create', ['parent_id' => $sub->id]) }}"
                                                       class="btn btn-sm btn-primary" title="{{ __('organizations.add_subcategory') }}">
                                                        <i class="fe fe-plus"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="100%">
                                            <div class="no-data">
                                                <img src="{{ asset('no-data.png') }}" alt="No Data Found">
                                                <p>{{ __('messages.no_data') }}</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>

                        <a href="{{ route('organization.categories.index') }}" class="btn btn-secondary mt-3">
                            ← {{ __('messages.back') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
