<div class="text-lg-right mb-4">
    <div class="btn-group" role="group">
        <a href="{{ route('organization.products.edit', $product->id) }}"
           class="btn btn-primary waves-effect waves-light">
            <i class="fas fa-edit mr-1"></i> {{ __('messages.edit') }}
        </a>
        <a href="{{ route('organization.products.index') }}"
           class="btn btn-outline-secondary waves-effect">
            <i class="fas fa-arrow-left mr-1"></i> {{ __('messages.back') }}
        </a>
    </div>
</div>
