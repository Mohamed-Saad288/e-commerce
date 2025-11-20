
{{-- resources/views/organization/products/partials/_description.blade.php --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h5 class="card-title font-size-15 text-primary mb-3">
            <i class="fas fa-align-left mr-2"></i>{{ __('messages.description') }}
        </h5>
        <div class="prose text-muted">
            {!! $product->description ?? '<p class="text-muted mb-0">' . __('messages.no_description') . '</p>' !!}
        </div>
    </div>
</div>
