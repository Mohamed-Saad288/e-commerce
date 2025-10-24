<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h5 class="card-title font-size-15 text-primary mb-3">
            <i class="fas fa-images mr-2"></i>{{ __('messages.product_images') }}
        </h5>

        @if($product->images && count($product->images) > 0)
            <div class="row g-2">
                @foreach($product->images as $image)
                    <div class="col-4">
                        <div class="position-relative overflow-hidden rounded">
                            <img src="{{ asset($image->path) }}" class="img-fluid rounded" style="height: 90px; object-fit: cover;">
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-4 text-muted">
                <i class="fas fa-image fa-3x mb-2 text-light"></i>
                <p class="mb-0">{{ __('messages.no_images') }}</p>
            </div>
        @endif
    </div>
</div>
