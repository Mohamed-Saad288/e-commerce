{{-- resources/views/organization/products/partials/_header.blade.php --}}
<div class="page-title-box d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="mb-1 font-size-18">{{ $product->name }}</h4>
        <p class="text-muted mb-0">{{ $product->short_description ?? __('messages.no_description') }}</p>
    </div>
    <ol class="breadcrumb m-0">
        <li class="breadcrumb-item">
            <a href="{{ route('organization.products.index') }}">{{ __('organizations.products') }}</a>
        </li>
        <li class="breadcrumb-item active">{{ $product->name }}</li>
    </ol>
</div>
