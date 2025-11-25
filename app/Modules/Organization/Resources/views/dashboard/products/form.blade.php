<!-- Product Form - Create & Edit (All-in-One) with Collapsible Variations -->
<form action="{{ $route }}" method="POST" enctype="multipart/form-data" id="productForm">
    @csrf
    @method($method)
    @include('organization::dashboard.products.partials.styles')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card-body">
        <!-- Nav Tabs -->
        <ul class="nav nav-tabs" id="productTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic"
                    type="button" role="tab" aria-controls="basic" aria-selected="true">
                    {{ __('organizations.basic_info') }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="translations-tab" data-bs-toggle="tab" data-bs-target="#translations"
                    type="button" role="tab" aria-controls="translations" aria-selected="false">
                    {{ __('organizations.translations') }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="images-tab" data-bs-toggle="tab" data-bs-target="#images" type="button"
                    role="tab" aria-controls="images" aria-selected="false">
                    {{ __('organizations.images') }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pricing-tab" data-bs-toggle="tab" data-bs-target="#pricing" type="button"
                    role="tab" aria-controls="pricing" aria-selected="false">
                    {{ __('organizations.pricing&tax') }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="inventory-tab" data-bs-toggle="tab" data-bs-target="#inventory"
                    type="button" role="tab" aria-controls="inventory" aria-selected="false">
                    {{ __('organizations.inventory') }}
                </button>
            </li>
        </ul>
        <!-- Tab Content -->
        <div class="tab-content">
            <!-- Basic Info -->
            <div class="tab-pane active" id="basic">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">{{ __('organizations.brand') }}</label>
                            <select name="brand_id" class="form-select @error('brand_id') is-invalid @enderror">
                                <option value="">{{ __('organizations.select_brand') }}</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}"
                                        {{ old('brand_id', $product->brand_id ?? '') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('brand_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3" id="sku-field-wrapper">
                            <label class="form-label">SKU</label>
                            <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror"
                                value="{{ old('sku', $product->sku ?? '') }}">
                            @error('sku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">{{ __('organizations.category') }}</label>

                            {{-- Container for dynamic category selects --}}
                            <div id="category-selects-container" class="d-flex flex-wrap gap-2">
                                {{-- First level will be populated via JS --}}
                            </div>

                            {{-- Hidden input for final selected category --}}
                            <input type="hidden" name="category_id" id="category_id"
                                class="@error('category_id') is-invalid @enderror"
                                value="{{ old('category_id', $product->category_id ?? '') }}">

                            @error('category_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror

                            {{-- Selected Path Display --}}
                            <div class="mt-2 p-2 bg-light rounded">
                                <small class="text-muted">
                                    <i class="fas fa-sitemap"></i> {{ __('messages.selected_category') }}:
                                </small>
                                <div id="category-path" class="text-primary font-weight-bold mt-1">
                                    <span class="text-muted">{{ __('messages.please_select_category') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="barcode-sortorder-row">
                    <div class="col-md-6" id="barcode-field-wrapper">
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.barcode') }}</label>
                            <input type="text" name="barcode"
                                class="form-control @error('barcode') is-invalid @enderror"
                                value="{{ old('barcode', $product->barcode ?? '') }}">
                            @error('barcode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6" id="sortorder-field-wrapper">
                        <div class="mb-3">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order"
                                class="form-control @error('sort_order') is-invalid @enderror"
                                value="{{ old('sort_order', $product->sort_order ?? 0) }}">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="requires_shipping" value="1"
                                id="requires_shipping"
                                {{ old('requires_shipping', $product->requires_shipping ?? 1) ? 'checked' : '' }}>
                            <label class="form-check-label"
                                for="requires_shipping">{{ __('organizations.requires_shipping') }}</label>
                        </div>
                    </div>
                </div>
                <!-- Variations Section -->
                <div class="mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0 d-flex align-items-center gap-3">
                            <i class="fas fa-layer-group text-primary"></i>
                            {{ __('organizations.variations') }}
                            <div class="variations-counter" id="variationsCount">0</div>
                        </h5>

                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-primary btn-sm shadow-sm"
                                id="collapseAllVariations" title="{{ __('messages.collapse_all') }}">
                                <i class="fas fa-compress-arrows-alt"></i>
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm shadow-sm"
                                id="expandAllVariations" title="{{ __('messages.expand_all') }}">
                                <i class="fas fa-expand-arrows-alt"></i>
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm shadow-sm"
                                id="clearAllVariations" title="{{ __('messages.clear_all') }}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <button type="button"
                                class="btn btn-success btn-sm shadow-sm d-flex align-items-center gap-2"
                                id="addVariation">
                                <i class="fas fa-plus"></i>
                                <span class="d-none d-md-inline">{{ __('organizations.add_variation') }}</span>
                            </button>
                        </div>
                    </div>
                    <div id="variationsContainer">
                        <!-- Existing Variations from Edit or Old Input (validation errors) -->
                        @php
                            // Get old input if exists (from validation errors)
                            $oldVariations = old('variations', []);

                            // Get existing variations from product model
                            $existingVariations =
                                isset($product) && $product->variations ? $product->variations : collect([]);

                            // Merge: use old() for form fields, but keep model objects for media
                            $variationsToDisplay = !empty($oldVariations)
                                ? $oldVariations
                                : $existingVariations->toArray();
                        @endphp

                        @if (!empty($variationsToDisplay) || $existingVariations->count() > 0)
                            @foreach ($variationsToDisplay as $index => $variationData)
                                @php
                                    // Get the actual model object for media (if exists)
                                    $variationModel = $existingVariations->get($index);

                                    // Use old data for form fields, but model for media
                                    $variation = is_array($variationData) ? (object) $variationData : $variationData;
                                @endphp
                                <div class="variation-item">
                                    <div class="card-header variation-header">
                                        <span>
                                            <i class="fas fa-chevron-down variation-collapse-icon"></i>
                                            {{ __('organizations.variations') }} <span
                                                class="variation-number">{{ $index + 1 }}</span>
                                        </span>
                                        <button type="button"
                                            class="btn btn-danger btn-sm remove-variation">{{ __('organizations.remove') }}</button>
                                    </div>
                                    <div class="card-body variation-body">
                                        @if (isset($variation->id))
                                            <input type="hidden" name="variations[{{ $index }}][id]"
                                                value="{{ $variation->id }}">
                                        @endif
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">SKU</label>
                                                    <input type="text" name="variations[{{ $index }}][sku]"
                                                        class="form-control"
                                                        value="{{ old("variations.$index.sku", $variation->sku ?? '') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('messages.barcode') }}</label>
                                                    <input type="text"
                                                        name="variations[{{ $index }}][barcode]"
                                                        class="form-control"
                                                        value="{{ old("variations.$index.barcode", $variation->barcode ?? '') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('messages.sort_order') }}</label>
                                                    <input type="number"
                                                        name="variations[{{ $index }}][sort_order]"
                                                        class="form-control"
                                                        value="{{ old("variations.$index.sort_order", $variation->sort_order ?? 0) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('messages.cost_price') }}</label>
                                                    <input type="number" step="0.01"
                                                        name="variations[{{ $index }}][cost_price]"
                                                        class="form-control variation-cost-price"
                                                        value="{{ old("variations.$index.cost_price", $variation->cost_price ?? 0) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label
                                                        class="form-label">{{ __('messages.selling_price') }}</label>
                                                    <input type="number" step="0.01"
                                                        name="variations[{{ $index }}][selling_price]"
                                                        class="form-control variation-selling-price"
                                                        value="{{ old("variations.$index.selling_price", $variation->selling_price ?? 0) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label
                                                        class="form-label">{{ __('messages.stock_quantity') }}</label>
                                                    <input type="number"
                                                        name="variations[{{ $index }}][stock_quantity]"
                                                        class="form-control variation-stock"
                                                        value="{{ old("variations.$index.stock_quantity", $variation->stock_quantity ?? 0) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('messages.discount') }}</label>
                                                    <input type="number" step="0.01"
                                                        name="variations[{{ $index }}][discount]"
                                                        class="form-control variation-discount"
                                                        value="{{ old("variations.$index.discount", $variation->discount ?? 0) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('messages.tax') }}</label>
                                                    <input type="number" step="0.01"
                                                        name="variations[{{ $index }}][tax_amount]"
                                                        class="form-control variation-tax-amount"
                                                        value="{{ old("variations.$index.tax_amount", $variation->tax_amount ?? 0) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('messages.tax_type') }}</label>
                                                    <select name="variations[{{ $index }}][tax_type]"
                                                        class="form-select variation-tax-type">
                                                        <option value="1"
                                                            {{ old("variations.$index.tax_type", $variation->tax_type ?? 1) == 1 ? 'selected' : '' }}>
                                                            {{ __('messages.fixed_amount') }}</option>
                                                        <option value="2"
                                                            {{ old("variations.$index.tax_type", $variation->tax_type ?? 1) == 2 ? 'selected' : '' }}>
                                                            {{ __('messages.percentage') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('messages.total_price') }}</label>
                                                    <input type="number" step="0.01"
                                                        name="variations[{{ $index }}][total_price]"
                                                        class="form-control variation-total-price"
                                                        value="{{ old("variations.$index.total_price", $variation->total_price ?? 0) }}"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="variations[{{ $index }}][is_taxable]"
                                                        value="1"
                                                        {{ old("variations.$index.is_taxable", $variation->is_taxable ?? false) ? 'checked' : '' }}>
                                                    <label
                                                        class="form-check-label">{{ __('messages.is_taxable') }}</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">{{ __('organizations.options') }}</label>
                                            <div class="row">
                                                @foreach ($options as $option)
                                                    <div class="col-md-6 mb-2" data-option-id="{{ $option->id }}">
                                                        <label class="form-label">{{ $option->name }}</label>
                                                        <select name="variations[{{ $index }}][option_items][]"
                                                            class="form-select variation-option-select"
                                                            data-option-id="{{ $option->id }}">
                                                            <option value="">Select {{ $option->name }}</option>
                                                            @foreach ($option->items as $item)
                                                                @php
                                                                    // Check if this option item is selected
                                                                    $oldOptionItems = old(
                                                                        "variations.$index.option_items",
                                                                        [],
                                                                    );
                                                                    $isSelected = in_array($item->id, $oldOptionItems);

                                                                    // Fallback to checking the variationModel (not variation) if old() is empty
                                                                    if (!$isSelected && empty($oldOptionItems)) {
                                                                        // Use $variationModel for database relationship
                                                                        if (
                                                                            $variationModel &&
                                                                            method_exists(
                                                                                $variationModel,
                                                                                'optionItems',
                                                                            )
                                                                        ) {
                                                                            $isSelected = $variationModel->optionItems->contains(
                                                                                'id',
                                                                                $item->id,
                                                                            );
                                                                        }
                                                                        // Or if it's a relation property
    elseif (
        $variationModel &&
        isset($variationModel->option_items)
    ) {
        $modelOptionItems =
            $variationModel->option_items;
        $isSelected = is_object($modelOptionItems)
            ? $modelOptionItems->contains(
                'id',
                                                                                    $item->id,
                                                                                )
                                                                                : in_array(
                                                                                    $item->id,
                                                                                    $modelOptionItems,
                                                                                );
                                                                        }
                                                                    }
                                                                @endphp
                                                                <option value="{{ $item->id }}"
                                                                    {{ $isSelected ? 'selected' : '' }}>
                                                                    {{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Main Images Section -->
                                        <div class="mb-3">
                                            <label
                                                class="form-label">{{ __('messages.variation_main_images') }}</label>
                                            <p class="text-muted small">
                                                {{ __('messages.variation_main_images_desc') }}</p>

                                            <div class="image-upload-container variation-main-image-upload"
                                                data-variation-index="{{ $index }}">
                                                <input type="file"
                                                    name="variations[{{ $index }}][main_images][]" multiple
                                                    accept="image/*" class="variation-main-image-input">

                                                <div class="upload-text">
                                                    <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                                                    <p>{{ __('messages.click_upload_main') }}</p>
                                                    <small
                                                        class="text-muted">{{ __('messages.images_upload_help') }}</small>
                                                </div>
                                            </div>

                                            <div class="image-preview-grid variation-main-image-preview"
                                                data-variation-index="{{ $index }}">
                                                {{-- استخدم $variationModel بدل $variation للصور --}}
                                                @if ($variationModel && method_exists($variationModel, 'getMedia'))
                                                    @foreach ($variationModel->getMedia('main_images') as $media)
                                                        <div class="image-preview-item"
                                                            data-media-id="{{ $media->id }}"
                                                            data-is-existing="true">
                                                            <img src="{{ $media->getUrl() }}"
                                                                alt="{{ __('messages.main_image_alt') }}">
                                                            <button type="button" class="remove-image"
                                                                data-existing="true"
                                                                data-media-id="{{ $media->id }}">×</button>
                                                            <input type="hidden"
                                                                name="variations[{{ $index }}][main_images_existing][]"
                                                                value="{{ $media->id }}" class="keep-image-input">
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Additional Images Section -->
                                        <div class="mb-3">
                                            <label
                                                class="form-label">{{ __('messages.variation_additional_images') }}</label>
                                            <p class="text-muted small">
                                                {{ __('messages.variation_additional_images_desc') }}</p>

                                            <div class="image-upload-container variation-image-upload"
                                                data-variation-index="{{ $index }}">
                                                <input type="file"
                                                    name="variations[{{ $index }}][additional_images][]"
                                                    multiple accept="image/*" class="variation-image-input">

                                                <div class="upload-text">
                                                    <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                                                    <p>{{ __('messages.click_upload_additional') }}</p>
                                                    <small
                                                        class="text-muted">{{ __('messages.images_upload_help') }}</small>
                                                </div>
                                            </div>

                                            <div class="image-preview-grid variation-image-preview"
                                                data-variation-index="{{ $index }}">
                                                @if ($variationModel && method_exists($variationModel, 'getMedia'))
                                                    @foreach ($variationModel->getMedia('additional_images') as $media)
                                                        <div class="image-preview-item"
                                                            data-media-id="{{ $media->id }}"
                                                            data-is-existing="true">
                                                            <img src="{{ $media->getUrl() }}"
                                                                alt="{{ __('messages.additional_image_alt') }}">
                                                            <button type="button" class="remove-image"
                                                                data-existing="true"
                                                                data-media-id="{{ $media->id }}">×</button>
                                                            <input type="hidden"
                                                                name="variations[{{ $index }}][additional_images_existing][]"
                                                                value="{{ $media->id }}"
                                                                class="keep-image-input">
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <!-- Translations -->
            <div class="tab-pane" id="translations">
                @foreach (config('translatable.locales') as $locale)
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong>{{ strtoupper($locale) }}</strong> -
                            {{ __('messages.lang_' . $locale) ?? ucfirst($locale) }}
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="translations[{{ $locale }}][locale]"
                                value="{{ $locale }}">
                            <div class="mb-3">
                                <label class="form-label">{{ __('messages.name') }}</label>
                                <input type="text" name="{{ $locale }}[name]"
                                    class="form-control @error("$locale.name") is-invalid @enderror"
                                    value="{{ old("$locale.name", $product?->translate($locale)?->name ?? '') }}">
                                @error("$locale.name")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ __('messages.short_description') }}</label>
                                <input type="text" name="{{ $locale }}[short_description]"
                                    class="form-control @error("$locale.short_description") is-invalid @enderror"
                                    value="{{ old("$locale.short_description", $product?->translate($locale)?->short_description ?? '') }}">
                                @error("$locale.short_description")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ __('messages.descriptions') }}</label>
                                <textarea name="{{ $locale }}[description]"
                                    class="form-control @error("$locale.description") is-invalid @enderror" rows="3">{{ old("$locale.description", $product?->translate($locale)?->description ?? '') }}</textarea>
                                @error("$locale.description")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Images Tab -->
            <div class="tab-pane" id="images">
                <div id="mainImagesSection">
                    <div id="imagesDisabledNotice" class="images-disabled-notice" style="display: none;">
                        <strong>{{ __('messages.images_disabled_notice') }}</strong>
                    </div>

                    <!-- Main Images -->
                    <div class="mb-4" id="mainImagesContainer">
                        <h5>{{ __('messages.main_images') }}</h5>
                        <p class="text-muted">{{ __('messages.main_images_desc') }}</p>
                        <div class="image-upload-container" id="mainImageUploadArea">
                            <input type="file" name="main_images[]" id="mainImagesInput" multiple
                                accept="image/*">
                            <div class="upload-text">
                                <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                                <p>{{ __('messages.click_to_upload_main') }}</p>
                                <small class="text-muted">{{ __('messages.allowed_files') }}</small>
                            </div>
                        </div>
                        <div class="image-preview-grid" id="mainImagesPreview">
                            @if (isset($product) && $product->getMedia('main_images')->count() > 0)
                                @foreach ($product->getMedia('main_images') as $media)
                                    <div class="image-preview-item" data-media-id="{{ $media->id }}"
                                        data-is-existing="true">
                                        <img src="{{ $media->getUrl() }}" alt="Main Image">
                                        <button type="button" class="remove-image" data-existing="true"
                                            data-media-id="{{ $media->id }}">×</button>
                                        <input type="hidden" name="main_images_existing[]"
                                            value="{{ $media->id }}" class="keep-image-input">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Additional Images -->
                    <div class="mb-4" id="additionalImagesContainer">
                        <h5>{{ __('messages.additional_images') }}</h5>
                        <p class="text-muted">{{ __('messages.additional_images_desc') }}</p>
                        <div class="image-upload-container" id="additionalImageUploadArea">
                            <input type="file" name="additional_images[]" id="additionalImagesInput" multiple
                                accept="image/*">
                            <div class="upload-text">
                                <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                                <p>{{ __('messages.click_to_upload_additional') }}</p>
                                <small class="text-muted">{{ __('messages.allowed_files') }}</small>
                            </div>
                        </div>
                        <div class="image-preview-grid" id="additionalImagesPreview">
                            @if (isset($product) && $product->getMedia('images')->count() > 0)
                                @foreach ($product->getMedia('images') as $media)
                                    <div class="image-preview-item" data-media-id="{{ $media->id }}"
                                        data-is-existing="true">
                                        <img src="{{ $media->getUrl() }}" alt="Additional Image">
                                        <button type="button" class="remove-image" data-existing="true"
                                            data-media-id="{{ $media->id }}">×</button>
                                        <input type="hidden" name="additional_images_existing[]"
                                            value="{{ $media->id }}" class="keep-image-input">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- Pricing & Tax -->
            <div class="tab-pane" id="pricing">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.cost_price') }}</label>
                            <input type="number" step="0.01" name="cost_price"
                                class="form-control @error('cost_price') is-invalid @enderror"
                                value="{{ old('cost_price', $product->cost_price ?? 0) }}" id="cost_price">
                            @error('cost_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.selling_price') }}</label>
                            <input type="number" step="0.01" name="selling_price"
                                class="form-control @error('selling_price') is-invalid @enderror"
                                value="{{ old('selling_price', $product->selling_price ?? 0) }}" id="selling_price">
                            @error('selling_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.discount') }}</label>
                            <input type="number" step="0.01" name="discount"
                                class="form-control @error('discount') is-invalid @enderror"
                                value="{{ old('discount', $product->discount ?? 0) }}" id="discount">
                            @error('discount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.total_price') }}</label>
                            <input type="number" step="0.01" name="total_price" class="form-control"
                                value="{{ old('total_price', $product->total_price ?? 0) }}" id="total_price"
                                readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_taxable" value="1"
                                id="is_taxable" {{ old('is_taxable', $product->is_taxable ?? '') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_taxable">{{ __('messages.is_taxable') }}</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.tax_type') }}</label>
                            <select name="tax_type" class="form-select @error('tax_type') is-invalid @enderror"
                                id="tax_type">
                                <option value="1"
                                    {{ old('tax_type', $product->tax_type ?? 1) == 1 ? 'selected' : '' }}>
                                    {{ __('messages.tax_type_amount') }}</option>
                                <option value="2"
                                    {{ old('tax_type', $product->tax_type ?? '') == 2 ? 'selected' : '' }}>
                                    {{ __('messages.tax_type_percentage') }}</option>
                            </select>
                            @error('tax_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.tax_amount') }}</label>
                            <input type="number" step="0.01" name="tax_amount"
                                class="form-control @error('tax_amount') is-invalid @enderror"
                                value="{{ old('tax_amount', $product->tax_amount ?? 0) }}" id="tax_amount">
                            @error('tax_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <!-- Inventory -->
            <div class="tab-pane" id="inventory">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.stock_quantity') }}</label>
                            <input type="number" name="stock_quantity"
                                class="form-control @error('stock_quantity') is-invalid @enderror"
                                value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}"
                                id="stock_quantity">
                            @error('stock_quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.low_stock_threshold') }}</label>
                            <input type="number" name="low_stock_threshold"
                                class="form-control @error('low_stock_threshold') is-invalid @enderror"
                                value="{{ old('low_stock_threshold', $product->low_stock_threshold ?? 5) }}"
                                id="low_stock_threshold">
                            @error('low_stock_threshold')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <div class="card-footer">
        <a href="{{ route('organization.products.index') }}"
            class="btn btn-secondary">{{ __('messages.cancel') }}</a>
        <button type="submit" class="btn btn-primary">
            {{ isset($product) ? __('messages.edit_product') : __('messages.create_product') }}
        </button>
    </div>
</form>
<!-- Hidden Variation Template -->
<div id="variationTemplate">
    <div class="variation-item">
        <div class="card-header variation-header">
            <span>
                <i class="fas fa-chevron-down variation-collapse-icon"></i>
                {{ __('messages.variation') }} <span class="variation-number"></span>
            </span>
            <button type="button"
                class="btn btn-danger btn-sm remove-variation">{{ __('messages.remove') }}</button>
        </div>
        <div class="card-body variation-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.sku') }}</label>
                        <input type="text" name="variations[INDEX][sku]" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.barcode') }}</label>
                        <input type="text" name="variations[INDEX][barcode]" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.sort_order') }}</label>
                        <input type="number" name="variations[INDEX][sort_order]" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.cost_price') }}</label>
                        <input type="number" step="0.01" name="variations[INDEX][cost_price]"
                            class="form-control variation-cost-price" value="0">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.selling_price') }}</label>
                        <input type="number" step="0.01" name="variations[INDEX][selling_price]"
                            class="form-control variation-selling-price" value="0">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.stock_quantity') }}</label>
                        <input type="number" name="variations[INDEX][stock_quantity]"
                            class="form-control variation-stock" value="0">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.discount') }}</label>
                        <input type="number" step="0.01" name="variations[INDEX][discount]"
                            class="form-control variation-discount" value="0">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.tax_amount') }}</label>
                        <input type="number" step="0.01" name="variations[INDEX][tax_amount]"
                            class="form-control variation-tax-amount" value="0">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.tax_type') }}</label>
                        <select name="variations[INDEX][tax_type]" class="form-select variation-tax-type">
                            <option value="1">{{ __('messages.tax_type_amount') }}</option>
                            <option value="2">{{ __('messages.tax_type_percentage') }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.total_price') }}</label>
                        <input type="number" step="0.01" name="variations[INDEX][total_price]"
                            class="form-control variation-total-price" value="0" readonly>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="variations[INDEX][is_taxable]"
                            value="1">
                        <label class="form-check-label">{{ __('messages.is_taxable') }}</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="variations[INDEX][is_featured]"
                            value="1">
                        <label class="form-check-label">{{ __('messages.is_featured') }}</label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('organizations.options') }}</label>
                <div class="row">
                    @foreach ($options as $option)
                        <div class="col-md-6 mb-2" data-option-id="{{ $option->id }}">
                            <label class="form-label">{{ $option->name }}</label>
                            <select name="variations[INDEX][option_items][]"
                                class="form-select variation-option-select" data-option-id="{{ $option->id }}">
                                <option value="">{{ __('messages.select') }} {{ $option->name }}</option>
                                @foreach ($option->items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('messages.variation_main_images') }}</label>
                <p class="text-muted small">{{ __('messages.variation_main_images_hint') }}</p>
                <div class="image-upload-container variation-main-image-upload" data-variation-index="INDEX">
                    <input type="file" name="variations[INDEX][main_images][]" multiple accept="image/*"
                        class="variation-main-image-input">
                    <div class="upload-text">
                        <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                        <p>{{ __('messages.upload_main_images') }}</p>
                        <small class="text-muted">{{ __('messages.allowed_images') }}</small>
                    </div>
                </div>
                <div class="image-preview-grid variation-main-image-preview" data-variation-index="INDEX"></div>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('messages.variation_additional_images') }}</label>
                <p class="text-muted small">{{ __('messages.variation_gallery_images_hint') }}</p>
                <div class="image-upload-container variation-image-upload" data-variation-index="INDEX">
                    <input type="file" name="variations[INDEX][additional_images][]" multiple accept="image/*"
                        class="variation-image-input">
                    <div class="upload-text">
                        <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                        <p>{{ __('messages.upload_additional_images') }}</p>
                        <small class="text-muted">{{ __('messages.allowed_images') }}</small>
                    </div>
                </div>
                <div class="image-preview-grid variation-image-preview" data-variation-index="INDEX"></div>
            </div>

        </div>
    </div>
</div>
@include('organization::dashboard.products.partials.scripts')
