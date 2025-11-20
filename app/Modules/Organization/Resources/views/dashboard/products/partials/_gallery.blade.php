{{-- resources/views/organization/products/partials/_gallery.blade.php --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h5 class="card-title font-size-15 text-primary mb-3">
            <i class="fas fa-images mr-2"></i>{{ __('messages.product_images') }}
        </h5>

        @php
            $allMainImages = collect();
            $allAdditionalImages = collect();

            foreach($product->variations as $variation) {
                $allMainImages = $allMainImages->merge($variation->getMedia('main_images'));
                $allAdditionalImages = $allAdditionalImages->merge($variation->getMedia('additional_images'));
            }

            $totalImages = $allMainImages->count() + $allAdditionalImages->count();
        @endphp

        @if($totalImages > 0)
            <div class="row g-2">
                {{-- عرض أول 6 صور فقط --}}
                @foreach($allMainImages->take(3) as $image)
                    <div class="col-4">
                        <div class="position-relative overflow-hidden rounded">
                            <img src="{{ $image->getUrl() }}"
                                 class="img-fluid rounded"
                                 style="height: 90px; width: 100%; object-fit: cover; cursor: pointer;"
                                 onclick="window.open('{{ $image->getUrl() }}', '_blank')">
                        </div>
                    </div>
                @endforeach

                @foreach($allAdditionalImages->take(3) as $image)
                    <div class="col-4">
                        <div class="position-relative overflow-hidden rounded">
                            <img src="{{ $image->getUrl() }}"
                                 class="img-fluid rounded"
                                 style="height: 90px; width: 100%; object-fit: cover; cursor: pointer;"
                                 onclick="window.open('{{ $image->getUrl() }}', '_blank')">
                        </div>
                    </div>
                @endforeach
            </div>

            @if($totalImages > 6)
                <div class="text-center mt-3">
                    <small class="text-muted">
                        <i class="fas fa-info-circle mr-1"></i>
                        {{ __('messages.total_images_in_variations', ['count' => $totalImages]) }}
                    </small>
                </div>
            @endif
        @else
            <div class="text-center py-4 text-muted">
                <i class="fas fa-image fa-3x mb-2 text-light"></i>
                <p class="mb-0">{{ __('messages.no_images') }}</p>
                <small>{{ __('messages.add_images_to_variations') }}</small>
            </div>
        @endif
    </div>
</div>
