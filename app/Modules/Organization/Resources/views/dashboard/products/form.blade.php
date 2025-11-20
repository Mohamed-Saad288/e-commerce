<!-- Product Form - Create & Edit (All-in-One) -->
<form action="{{ $route }}" method="POST" enctype="multipart/form-data" id="productForm">
    @csrf
    @method($method)
    <style>
        * {
            box-sizing: border-box;
        }
        /* Tab Styling */
        .nav-tabs {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0 0 1rem 0;
            border-bottom: 2px solid #dee2e6;
        }
        .nav-tabs .nav-item {
            margin: 0;
        }
        .nav-tabs .nav-link {
            display: block;
            padding: 0.75rem 1.25rem;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-bottom: none;
            border-top-left-radius: 0.375rem;
            border-top-right-radius: 0.375rem;
            color: #495057;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }
        .nav-tabs .nav-link:hover {
            background-color: #e9ecef;
        }
        .nav-tabs .nav-link.active {
            background-color: #fff;
            border-color: #0d6efd;
            border-bottom: 2px solid #fff;
            color: #0d6efd;
            font-weight: 600;
        }
        /* Tab Content */
        .tab-content {
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            padding: 1.5rem;
            min-height: 300px;
        }
        /* Form Controls */
        .form-label {
            font-weight: 500;
            color: #212529;
            margin-bottom: 0.5rem;
            display: block;
        }
        .form-control,
        .form-select {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            transition: border-color 0.15s ease-in-out;
        }
        .form-control:focus,
        .form-select:focus {
            border-color: #86b7fe;
            outline: 0;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath d='M2 5l6 6 6-6z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
        }
        /* Invalid Feedback */
        .is-invalid {
            border-color: #dc3545;
        }
        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }
        /* Card */
        .card {
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            padding: 1.25rem;
        }
        .card-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
            padding: 1rem;
            text-align: right;
            border-bottom-left-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
        }
        /* Variations */
        .variation-item {
            border: 1px solid #e9ecef;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }
        .variation-item .card-header {
            background-color: #f8f9fa;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
        }
        .remove-variation {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        /* Responsive */
        @media (max-width: 768px) {
            .row {
                flex-direction: column;
            }
            .col-md-6, .col-md-4, .col-md-3 {
                width: 100%;
                margin-bottom: 0.75rem;
            }
        }
        /* Hide Template */
        #variationTemplate {
            display: none;
        }
        /* Image Upload Styling */
        .image-upload-container {
            border: 2px dashed #dee2e6;
            border-radius: 0.5rem;
            padding: 1.5rem;
            text-align: center;
            background-color: #f8f9fa;
            cursor: pointer;
            transition: all 0.3s;
        }
        .image-upload-container:hover {
            border-color: #0d6efd;
            background-color: #e7f3ff;
        }
        .image-upload-container input[type="file"] {
            display: none;
        }
        .image-preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }
        .image-preview-item {
            position: relative;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            overflow: hidden;
            aspect-ratio: 1;
        }
        .image-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .image-preview-item .remove-image {
            position: absolute;
            top: 0.25rem;
            right: 0.25rem;
            background-color: rgba(220, 53, 69, 0.9);
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            font-size: 0.875rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }
        .image-preview-item .remove-image:hover {
            background-color: #dc3545;
        }
        .images-disabled-notice {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 0.375rem;
            padding: 1rem;
            margin-bottom: 1rem;
            color: #856404;
        }

        /* Category Selects Styling */
        #category-selects-container .category-level {
            min-width: 200px;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        #category-path {
            min-height: 24px;
            line-height: 24px;
        }

        .category-select {
            font-size: 0.9rem;
        }
    </style>
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
                <button class="nav-link active" id="basic-tab" data-bs-toggle="tab"
                        data-bs-target="#basic" type="button" role="tab" aria-controls="basic" aria-selected="true">
                    {{ __("organizations.basic_info") }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="translations-tab" data-bs-toggle="tab"
                        data-bs-target="#translations" type="button" role="tab" aria-controls="translations" aria-selected="false">
                    {{ __("organizations.translations") }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="images-tab" data-bs-toggle="tab"
                        data-bs-target="#images" type="button" role="tab" aria-controls="images" aria-selected="false">
                    {{ __("organizations.images") }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pricing-tab" data-bs-toggle="tab"
                        data-bs-target="#pricing" type="button" role="tab" aria-controls="pricing" aria-selected="false">
                    {{ __("organizations.pricing&tax") }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="inventory-tab" data-bs-toggle="tab"
                        data-bs-target="#inventory" type="button" role="tab" aria-controls="inventory" aria-selected="false">
                    {{ __("organizations.inventory") }}
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
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}"
                                        {{ (old('brand_id', $product->brand_id ?? '') == $brand->id) ? 'selected' : '' }}>
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
                            <label class="form-label">{{ __("organizations.category") }}</label>

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
                            <label class="form-label">{{ __("messages.barcode") }}</label>
                            <input type="text" name="barcode" class="form-control @error('barcode') is-invalid @enderror"
                                   value="{{ old('barcode', $product->barcode ?? '') }}">
                            @error('barcode')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6" id="sortorder-field-wrapper">
                        <div class="mb-3">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror"
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
                                   id="requires_shipping" {{ old('requires_shipping', $product->requires_shipping ?? 1) ? 'checked' : '' }}>
                            <label class="form-check-label" for="requires_shipping">{{ __('organizations.requires_shipping') }}</label>
                        </div>
                    </div>
                </div>
                <!-- Variations Section -->
                <div class="mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5>Variations</h5>
                        <button type="button" class="btn btn-success btn-sm" id="addVariation">
                            <i class="fas fa-plus"></i> {{ __('organizations.add_variation') }}
                        </button>
                    </div>
                    <div id="variationsContainer">
                        <!-- Existing Variations from Edit -->
                        @if(isset($product) && $product->variations)
                            @foreach($product->variations as $index => $variation)
                                <div class="variation-item">
                                    <div class="card-header">
                                        <span>{{ __('organizations.variations') }} <span class="variation-number">{{ $index + 1 }}</span></span>
                                        <button type="button" class="btn btn-danger btn-sm remove-variation">{{ __('organizations.remove') }}</button>
                                    </div>
                                    <div class="card-body">
                                        <input type="hidden" name="variations[{{ $index }}][id]" value="{{ $variation->id }}">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">SKU</label>
                                                    <input type="text" name="variations[{{ $index }}][sku]" class="form-control"
                                                           value="{{ $variation->sku }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('messages.barcode') }}</label>
                                                    <input type="text" name="variations[{{ $index }}][barcode]" class="form-control"
                                                           value="{{ $variation->barcode }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('messages.sort_order') }}</label>
                                                    <input type="number" name="variations[{{ $index }}][sort_order]" class="form-control"
                                                           value="{{ $variation->sort_order }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('messages.cost_price') }}</label>
                                                    <input type="number" step="0.01" name="variations[{{ $index }}][cost_price]"
                                                           class="form-control variation-cost-price"
                                                           value="{{ $variation->cost_price }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('messages.selling_price') }}</label>
                                                    <input type="number" step="0.01" name="variations[{{ $index }}][selling_price]"
                                                           class="form-control variation-selling-price"
                                                           value="{{ $variation->selling_price }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('messages.stock_quantity') }}</label>
                                                    <input type="number" name="variations[{{ $index }}][stock_quantity]"
                                                           class="form-control variation-stock"
                                                           value="{{ $variation->stock_quantity }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('messages.discount') }}</label>
                                                    <input type="number" step="0.01" name="variations[{{ $index }}][discount]"
                                                           class="form-control variation-discount"
                                                           value="{{ $variation->discount }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('messages.tax') }}</label>
                                                    <input type="number" step="0.01" name="variations[{{ $index }}][tax_amount]"
                                                           class="form-control variation-tax-amount"
                                                           value="{{ $variation->tax_amount }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('messages.tax_type') }}</label>
                                                    <select name="variations[{{ $index }}][tax_type]" class="form-select variation-tax-type">
                                                        <option value="1" {{ $variation->tax_type == 1 ? 'selected' : '' }}>{{ __('messages.fixed_amount') }}</option>
                                                        <option value="2" {{ $variation->tax_type == 2 ? 'selected' : '' }}>{{ __('messages.percentage') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('messages.total_price') }}</label>
                                                    <input type="number" step="0.01" name="variations[{{ $index }}][total_price]"
                                                           class="form-control variation-total-price"
                                                           value="{{ $variation->total_price }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox" name="variations[{{ $index }}][is_taxable]"
                                                           value="1" {{ $variation->is_taxable ? 'checked' : '' }}>
                                                    <label class="form-check-label">{{ __('messages.is_taxable') }}</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">{{__('organizations.options')}}</label>
                                            <div class="row">
                                                @foreach($options as $option)
                                                    <div class="col-md-6 mb-2" data-option-id="{{ $option->id }}">
                                                        <label class="form-label">{{ $option->name }}</label>
                                                        <select name="variations[{{ $index }}][option_items][]"
                                                                class="form-select variation-option-select"
                                                                data-option-id="{{ $option->id }}">
                                                            <option value="">Select {{ $option->name }}</option>
                                                            @foreach($option->items as $item)
                                                                <option value="{{ $item->id }}"
                                                                    {{ $variation->option_items->contains('id', $item->id) ? 'selected' : '' }}>
                                                                    {{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('messages.variation_main_images') }}</label>
                                            <p class="text-muted small">{{ __('messages.variation_main_images_desc') }}</p>

                                            <div class="image-upload-container variation-main-image-upload" data-variation-index="{{ $index }}">
                                                <input type="file" name="variations[{{ $index }}][main_images][]" multiple accept="image/*" class="variation-main-image-input">

                                                <div class="upload-text">
                                                    <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                                                    <p>{{ __('messages.click_upload_main') }}</p>
                                                    <small class="text-muted">{{ __('messages.images_upload_help') }}</small>
                                                </div>
                                            </div>

                                            <div class="image-preview-grid variation-main-image-preview" data-variation-index="{{ $index }}">
                                                @if($variation->getMedia('main_images')->count() > 0)
                                                    @foreach($variation->getMedia('main_images') as $media)
                                                        <div class="image-preview-item" data-media-id="{{ $media->id }}" data-is-existing="true">
                                                            <img src="{{ $media->getUrl() }}" alt="{{ __('messages.main_image_alt') }}">
                                                            <button type="button" class="remove-image" data-existing="true" data-media-id="{{ $media->id }}">×</button>
                                                            <input type="hidden" name="variations[{{ $index }}][main_images_existing][]" value="{{ $media->id }}" class="keep-image-input">
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>


                                        <div class="mb-3">
                                            <label class="form-label">{{ __('messages.variation_additional_images') }}</label>
                                            <p class="text-muted small">{{ __('messages.variation_additional_images_desc') }}</p>

                                            <div class="image-upload-container variation-image-upload" data-variation-index="{{ $index }}">
                                                <input type="file" name="variations[{{ $index }}][additional_images][]" multiple accept="image/*" class="variation-image-input">

                                                <div class="upload-text">
                                                    <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                                                    <p>{{ __('messages.click_upload_additional') }}</p>
                                                    <small class="text-muted">{{ __('messages.images_upload_help') }}</small>
                                                </div>
                                            </div>

                                            <div class="image-preview-grid variation-image-preview" data-variation-index="{{ $index }}">
                                                @if($variation->getMedia('additional_images')->count() > 0)
                                                    @foreach($variation->getMedia('additional_images') as $media)
                                                        <div class="image-preview-item" data-media-id="{{ $media->id }}" data-is-existing="true">
                                                            <img src="{{ $media->getUrl() }}" alt="{{ __('messages.additional_image_alt') }}">
                                                            <button type="button" class="remove-image" data-existing="true" data-media-id="{{ $media->id }}">×</button>
                                                            <input type="hidden" name="variations[{{ $index }}][additional_images_existing][]" value="{{ $media->id }}" class="keep-image-input">
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
                @foreach(config('translatable.locales') as $locale)
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong>{{ strtoupper($locale) }}</strong> - {{ __('messages.lang_'.$locale) ?? ucfirst($locale) }}
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="translations[{{ $locale }}][locale]" value="{{ $locale }}">
                            <div class="mb-3">
                                <label class="form-label">{{ __('messages.name') }}</label>
                                <input type="text" name="{{ $locale }}[name]" class="form-control @error("$locale.name") is-invalid @enderror"
                                       value="{{ old("$locale.name", $product?->translate($locale)?->name ?? '') }}">
                                @error("$locale.name")
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ __('messages.short_description') }}</label>
                                <input type="text" name="{{ $locale }}[short_description]" class="form-control @error("$locale.short_description") is-invalid @enderror"
                                       value="{{ old("$locale.short_description", $product?->translate($locale)?->short_description ?? '') }}">
                                @error("$locale.short_description")
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{__('messages.descriptions')}}</label>
                                <textarea name="{{ $locale }}[description]" class="form-control @error("$locale.description") is-invalid @enderror"
                                          rows="3">{{ old("$locale.description", $product?->translate($locale)?->description ?? '') }}</textarea>
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
                            <input type="file" name="main_images[]" id="mainImagesInput" multiple accept="image/*">
                            <div class="upload-text">
                                <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                                <p>{{ __('messages.click_to_upload_main') }}</p>
                                <small class="text-muted">{{ __('messages.allowed_files') }}</small>
                            </div>
                        </div>
                        <div class="image-preview-grid" id="mainImagesPreview">
                            @if(isset($product) && $product->getMedia('main_images')->count() > 0)
                                @foreach($product->getMedia('main_images') as $media)
                                    <div class="image-preview-item" data-media-id="{{ $media->id }}" data-is-existing="true">
                                        <img src="{{ $media->getUrl() }}" alt="Main Image">
                                        <button type="button" class="remove-image" data-existing="true" data-media-id="{{ $media->id }}">×</button>
                                        <input type="hidden" name="main_images_existing[]" value="{{ $media->id }}" class="keep-image-input">
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
                            <input type="file" name="additional_images[]" id="additionalImagesInput" multiple accept="image/*">
                            <div class="upload-text">
                                <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                                <p>{{ __('messages.click_to_upload_additional') }}</p>
                                <small class="text-muted">{{ __('messages.allowed_files') }}</small>
                            </div>
                        </div>
                        <div class="image-preview-grid" id="additionalImagesPreview">
                            @if(isset($product) && $product->getMedia('images')->count() > 0)
                                @foreach($product->getMedia('images') as $media)
                                    <div class="image-preview-item" data-media-id="{{ $media->id }}" data-is-existing="true">
                                        <img src="{{ $media->getUrl() }}" alt="Additional Image">
                                        <button type="button" class="remove-image" data-existing="true" data-media-id="{{ $media->id }}">×</button>
                                        <input type="hidden" name="additional_images_existing[]" value="{{ $media->id }}" class="keep-image-input">
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
                            <input type="number" step="0.01" name="cost_price" class="form-control @error('cost_price') is-invalid @enderror"
                                   value="{{ old('cost_price', $product->cost_price ?? 0) }}" id="cost_price">
                            @error('cost_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.selling_price') }}</label>
                            <input type="number" step="0.01" name="selling_price" class="form-control @error('selling_price') is-invalid @enderror"
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
                            <input type="number" step="0.01" name="discount" class="form-control @error('discount') is-invalid @enderror"
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
                                   value="{{ old('total_price', $product->total_price ?? 0) }}" id="total_price" readonly>
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
                            <select name="tax_type" class="form-select @error('tax_type') is-invalid @enderror" id="tax_type">
                                <option value="1" {{ old('tax_type', $product->tax_type ?? 1) == 1 ? 'selected' : '' }}>{{ __('messages.tax_type_amount') }}</option>
                                <option value="2" {{ old('tax_type', $product->tax_type ?? '') == 2 ? 'selected' : '' }}>{{ __('messages.tax_type_percentage') }}</option>
                            </select>
                            @error('tax_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.tax_amount') }}</label>
                            <input type="number" step="0.01" name="tax_amount" class="form-control @error('tax_amount') is-invalid @enderror"
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
                            <input type="number" name="stock_quantity" class="form-control @error('stock_quantity') is-invalid @enderror"
                                   value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}" id="stock_quantity">
                            @error('stock_quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.low_stock_threshold') }}</label>
                            <input type="number" name="low_stock_threshold" class="form-control @error('low_stock_threshold') is-invalid @enderror"
                                   value="{{ old('low_stock_threshold', $product->low_stock_threshold ?? 5) }}" id="low_stock_threshold">
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
        <a href="{{ route('organization.products.index') }}" class="btn btn-secondary">{{__('messages.cancel')}}</a>
        <button type="submit" class="btn btn-primary">
            {{ isset($product) ? __('messages.edit_product') : __('messages.create_product') }}
        </button>
    </div>
</form>
<!-- Hidden Variation Template -->
<div id="variationTemplate">
    <div class="variation-item">
        <div class="card-header">
            <span>{{ __('messages.variation') }} <span class="variation-number"></span></span>
            <button type="button" class="btn btn-danger btn-sm remove-variation">{{ __('messages.remove') }}</button>
        </div>
        <div class="card-body">
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
                        <input type="number" step="0.01" name="variations[INDEX][cost_price]" class="form-control variation-cost-price" value="0">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.selling_price') }}</label>
                        <input type="number" step="0.01" name="variations[INDEX][selling_price]" class="form-control variation-selling-price" value="0">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.stock_quantity') }}</label>
                        <input type="number" name="variations[INDEX][stock_quantity]" class="form-control variation-stock" value="0">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.discount') }}</label>
                        <input type="number" step="0.01" name="variations[INDEX][discount]" class="form-control variation-discount" value="0">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.tax_amount') }}</label>
                        <input type="number" step="0.01" name="variations[INDEX][tax_amount]" class="form-control variation-tax-amount" value="0">
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
                        <input type="number" step="0.01" name="variations[INDEX][total_price]" class="form-control variation-total-price" value="0" readonly>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="variations[INDEX][is_taxable]" value="1">
                        <label class="form-check-label">{{ __('messages.is_taxable') }}</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="variations[INDEX][is_featured]" value="1">
                        <label class="form-check-label">{{ __('messages.is_featured') }}</label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">{{__('organizations.options')}}</label>
                <div class="row">
                    @foreach($options as $option)
                        <div class="col-md-6 mb-2" data-option-id="{{ $option->id }}">
                            <label class="form-label">{{ $option->name }}</label>
                            <select name="variations[INDEX][option_items][]"
                                    class="form-select variation-option-select"
                                    data-option-id="{{ $option->id }}">
                                <option value="">{{ __('messages.select') }} {{ $option->name }}</option>
                                @foreach($option->items as $item)
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
                    <input type="file" name="variations[INDEX][main_images][]" multiple accept="image/*" class="variation-main-image-input">
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
                    <input type="file" name="variations[INDEX][additional_images][]" multiple accept="image/*" class="variation-image-input">
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Tab System
        const tabs = document.querySelectorAll('.nav-link');
        const panes = document.querySelectorAll('.tab-pane');
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                panes.forEach(p => p.classList.remove('active'));
                tab.classList.add('active');
                document.querySelector(tab.dataset.bsTarget).classList.add('active');
            });
        });

        // ===========================================
        // IMAGE UPLOAD FUNCTIONALITY
        // ===========================================

        // Handle Main Images Upload
        function setupImageUpload(inputElement, previewContainer, uploadArea) {
            if (!inputElement) return;

            // Store files in a DataTransfer object for proper multiple file handling
            let filesList = new DataTransfer();

            // Click to upload
            uploadArea?.addEventListener('click', (e) => {
                if (e.target.classList.contains('remove-image')) return;
                inputElement.click();
            });

            // File selection handler
            inputElement.addEventListener('change', function(e) {
                const newFiles = Array.from(this.files);
                newFiles.forEach(file => {
                    filesList.items.add(file);
                });

                // Update the input's files
                inputElement.files = filesList.files;

                handleFiles(newFiles, previewContainer, inputElement, filesList);
            });

            // Drag and drop
            uploadArea?.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadArea.style.borderColor = '#0d6efd';
            });

            uploadArea?.addEventListener('dragleave', (e) => {
                e.preventDefault();
                uploadArea.style.borderColor = '#dee2e6';
            });

            uploadArea?.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadArea.style.borderColor = '#dee2e6';
                const newFiles = Array.from(e.dataTransfer.files);

                newFiles.forEach(file => {
                    filesList.items.add(file);
                });

                // Update the input's files
                inputElement.files = filesList.files;

                handleFiles(newFiles, previewContainer, inputElement, filesList);
            });
        }

        // Handle file preview
        function handleFiles(files, previewContainer, inputElement, filesList) {
            if (!files || !previewContainer) return;

            Array.from(files).forEach((file, index) => {
                if (!file.type.startsWith('image/')) return;

                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewItem = document.createElement('div');
                    previewItem.className = 'image-preview-item';
                    previewItem.dataset.fileName = file.name;
                    previewItem.dataset.isExisting = 'false';
                    previewItem.innerHTML = `
                        <img src="${e.target.result}" alt="Preview">
                        <button type="button" class="remove-image" data-existing="false">×</button>
                    `;

                    previewContainer.appendChild(previewItem);

                    // Remove image handler for new uploads
                    previewItem.querySelector('.remove-image').addEventListener('click', function(e) {
                        e.stopPropagation();
                        const fileName = previewItem.dataset.fileName;

                        // Remove from DataTransfer
                        if (filesList) {
                            const dt = new DataTransfer();
                            const filesArray = Array.from(filesList.files);

                            filesArray.forEach(f => {
                                if (f.name !== fileName) {
                                    dt.items.add(f);
                                }
                            });

                            // Update input files
                            inputElement.files = dt.files;

                            // Update filesList reference
                            filesList.items.clear();
                            Array.from(dt.files).forEach(f => filesList.items.add(f));
                        }

                        previewItem.remove();
                    });
                };
                reader.readAsDataURL(file);
            });
        }

        // Remove existing images (mark for deletion)
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-image') && e.target.dataset.existing === 'true') {
                e.stopPropagation();
                const previewItem = e.target.closest('.image-preview-item');
                const mediaId = e.target.dataset.mediaId;

                // Remove the hidden input that keeps the image
                const keepInput = previewItem.querySelector('.keep-image-input');
                if (keepInput) {
                    keepInput.remove();
                }

                // Visually mark as deleted and remove from DOM
                previewItem.remove();
            }
        });

        // Convert existing images to File objects and merge with new files
        function convertExistingImagesToFiles(previewContainer, inputElement, imageType) {
            const existingImages = previewContainer.querySelectorAll('.image-preview-item[data-is-existing="true"]');
            const filesList = new DataTransfer();

            // Add existing images as hidden inputs (media IDs)
            existingImages.forEach(item => {
                const mediaId = item.dataset.mediaId;
                if (mediaId && !item.querySelector('.keep-image-input')) {
                    // Image was deleted, don't include it
                    return;
                }
            });

            // Add new files from input
            if (inputElement && inputElement.files) {
                Array.from(inputElement.files).forEach(file => {
                    filesList.items.add(file);
                });
            }

            return filesList;
        }

        // Before form submit, prepare all images
        document.getElementById('productForm').addEventListener('submit', function(e) {
            // Main Images: Rename existing images to match array name
            const mainPreview = document.getElementById('mainImagesPreview');
            const existingMainImages = mainPreview.querySelectorAll('.image-preview-item[data-is-existing="true"]');

            existingMainImages.forEach((item, index) => {
                const keepInput = item.querySelector('.keep-image-input');
                if (keepInput) {
                    keepInput.name = `main_images[existing][]`;
                }
            });

            // Additional Images: Rename existing images to match array name
            const additionalPreview = document.getElementById('additionalImagesPreview');
            const existingAdditionalImages = additionalPreview.querySelectorAll('.image-preview-item[data-is-existing="true"]');

            existingAdditionalImages.forEach((item, index) => {
                const keepInput = item.querySelector('.keep-image-input');
                if (keepInput) {
                    keepInput.name = `additional_images[existing][]`;
                }
            });

            // Variation Images
            document.querySelectorAll('.variation-item').forEach((variation, varIndex) => {
                // Variation Main Images
                const varMainPreview = variation.querySelector('.variation-main-image-preview');
                if (varMainPreview) {
                    const existingVarMainImages = varMainPreview.querySelectorAll('.image-preview-item[data-is-existing="true"]');
                    existingVarMainImages.forEach(item => {
                        const keepInput = item.querySelector('.keep-image-input');
                        if (keepInput) {
                            keepInput.name = `variations[${varIndex}][main_images][existing][]`;
                        }
                    });
                }

                // Variation Additional Images
                const varAdditionalPreview = variation.querySelector('.variation-image-preview');
                if (varAdditionalPreview) {
                    const existingVarAdditionalImages = varAdditionalPreview.querySelectorAll('.image-preview-item[data-is-existing="true"]');
                    existingVarAdditionalImages.forEach(item => {
                        const keepInput = item.querySelector('.keep-image-input');
                        if (keepInput) {
                            keepInput.name = `variations[${varIndex}][additional_images][existing][]`;
                        }
                    });
                }
            });

            // Clean up all variation option selects
            document.querySelectorAll('.variation-option-select').forEach(select => {
                if (select.value === '' || select.value === null) {
                    select.removeAttribute('name');
                }
            });
        });

        // Setup main images upload
        const mainImagesInput = document.getElementById('mainImagesInput');
        const mainImagesPreview = document.getElementById('mainImagesPreview');
        const mainImageUploadArea = document.getElementById('mainImageUploadArea');
        setupImageUpload(mainImagesInput, mainImagesPreview, mainImageUploadArea);

        // Setup additional images upload
        const additionalImagesInput = document.getElementById('additionalImagesInput');
        const additionalImagesPreview = document.getElementById('additionalImagesPreview');
        const additionalImageUploadArea = document.getElementById('additionalImageUploadArea');
        setupImageUpload(additionalImagesInput, additionalImagesPreview, additionalImageUploadArea);

        // ===========================================
        // VARIATION IMAGE UPLOADS
        // ===========================================

        function setupVariationImageUpload(variationElement) {
            // Setup variation main images
            const mainUploadArea = variationElement.querySelector('.variation-main-image-upload');
            const mainInputElement = variationElement.querySelector('.variation-main-image-input');
            const mainPreviewContainer = variationElement.querySelector('.variation-main-image-preview');

            if (mainUploadArea && mainInputElement && mainPreviewContainer) {
                setupImageUpload(mainInputElement, mainPreviewContainer, mainUploadArea);
            }

            // Setup variation additional images
            const uploadArea = variationElement.querySelector('.variation-image-upload');
            const inputElement = variationElement.querySelector('.variation-image-input');
            const previewContainer = variationElement.querySelector('.variation-image-preview');

            if (uploadArea && inputElement && previewContainer) {
                setupImageUpload(inputElement, previewContainer, uploadArea);
            }
        }

        // Setup image uploads for existing variations
        document.querySelectorAll('.variation-item').forEach(setupVariationImageUpload);

        // ===========================================
        // FIX OPTION ITEMS - REMOVE EMPTY VALUES BEFORE SUBMIT
        // ===========================================
        document.getElementById('productForm').addEventListener('submit', function(e) {
            // Clean up all variation option selects
            document.querySelectorAll('.variation-option-select').forEach(select => {
                if (select.value === '' || select.value === null) {
                    select.removeAttribute('name');
                }
            });
        });

        // ===========================================
        // MAIN PRICE CALCULATION
        // ===========================================
        function calculateMainPrice() {
            const selling = parseFloat(document.getElementById('selling_price')?.value) || 0;
            const discount = parseFloat(document.getElementById('discount')?.value) || 0;
            const taxAmount = parseFloat(document.getElementById('tax_amount')?.value) || 0;
            const taxType = document.getElementById('tax_type')?.value;
            const isTaxable = document.getElementById('is_taxable')?.checked;
            let total = selling - discount;
            if (isTaxable) {
                total += taxType == '1' ? taxAmount : (total * taxAmount / 100);
            }
            document.getElementById('total_price').value = total.toFixed(2);
        }
        ['selling_price', 'discount', 'tax_amount', 'tax_type', 'is_taxable'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener('change', calculateMainPrice);
                el.addEventListener('input', calculateMainPrice);
            }
        });

        // ===========================================
        // DYNAMIC VARIATIONS & IMAGE LOGIC
        // ===========================================
        let variationCounter = @isset($product) {{ $product->variations->count() }} @else 0 @endisset;
        const addBtn = document.getElementById('addVariation');
        const container = document.getElementById('variationsContainer');
        const template = document.getElementById('variationTemplate');
        const stockInput = document.getElementById('stock_quantity');

        // Reference to tabs and sections
        const pricingTabLi = document.querySelector('button[data-bs-target="#pricing"]').closest('.nav-item');
        const mainImagesContainer = document.getElementById('mainImagesContainer');
        const additionalImagesContainer = document.getElementById('additionalImagesContainer');
        const imagesDisabledNotice = document.getElementById('imagesDisabledNotice');

        function toggleImageSections() {
            const hasVariations = container.children.length > 0;

            if (hasVariations) {
                // Disable main product images
                mainImagesContainer.style.opacity = '0.5';
                additionalImagesContainer.style.opacity = '0.5';
                mainImagesContainer.style.pointerEvents = 'none';
                additionalImagesContainer.style.pointerEvents = 'none';
                imagesDisabledNotice.style.display = 'block';

                // Disable image inputs
                if (mainImagesInput) mainImagesInput.disabled = true;
                if (additionalImagesInput) additionalImagesInput.disabled = true;
            } else {
                // Enable main product images
                mainImagesContainer.style.opacity = '1';
                additionalImagesContainer.style.opacity = '1';
                mainImagesContainer.style.pointerEvents = 'auto';
                additionalImagesContainer.style.pointerEvents = 'auto';
                imagesDisabledNotice.style.display = 'none';

                // Enable image inputs
                if (mainImagesInput) mainImagesInput.disabled = false;
                if (additionalImagesInput) additionalImagesInput.disabled = false;
            }
        }

        function togglePricingTab() {
            const hasVariations = container.children.length > 0;
            if (hasVariations) {
                if (pricingTabLi) pricingTabLi.style.display = 'none';
                document.getElementById('cost_price')?.setAttribute('disabled', 'disabled');
                document.getElementById('selling_price')?.setAttribute('disabled', 'disabled');

                // Hide SKU, Barcode, Sort Order fields when variations exist
                hideBasicInfoFields();
            } else {
                if (pricingTabLi) pricingTabLi.style.display = '';
                document.getElementById('cost_price')?.removeAttribute('disabled');
                document.getElementById('selling_price')?.removeAttribute('disabled');

                // Show SKU, Barcode, Sort Order fields when no variations
                showBasicInfoFields();
            }
            updateTotalStock();
            toggleImageSections();
        }

        function hideBasicInfoFields() {
            const skuFieldWrapper = document.getElementById('sku-field-wrapper');
            const barcodeFieldWrapper = document.getElementById('barcode-field-wrapper');
            const sortOrderFieldWrapper = document.getElementById('sortorder-field-wrapper');
            const barcodeRow = document.getElementById('barcode-sortorder-row');

            if (skuFieldWrapper) {
                skuFieldWrapper.style.display = 'none';
                const input = skuFieldWrapper.querySelector('input[name="sku"]');
                if (input) input.value = '';
            }
            if (barcodeFieldWrapper) {
                barcodeFieldWrapper.style.display = 'none';
                const input = barcodeFieldWrapper.querySelector('input[name="barcode"]');
                if (input) input.value = '';
            }
            if (sortOrderFieldWrapper) {
                sortOrderFieldWrapper.style.display = 'none';
                const input = sortOrderFieldWrapper.querySelector('input[name="sort_order"]');
                if (input) input.value = '0';
            }

            // Hide entire row if both fields are hidden
            if (barcodeRow && barcodeFieldWrapper?.style.display === 'none' && sortOrderFieldWrapper?.style.display === 'none') {
                barcodeRow.style.display = 'none';
            }
        }

        function showBasicInfoFields() {
            const skuFieldWrapper = document.getElementById('sku-field-wrapper');
            const barcodeFieldWrapper = document.getElementById('barcode-field-wrapper');
            const sortOrderFieldWrapper = document.getElementById('sortorder-field-wrapper');
            const barcodeRow = document.getElementById('barcode-sortorder-row');

            if (skuFieldWrapper) skuFieldWrapper.style.display = '';
            if (barcodeFieldWrapper) barcodeFieldWrapper.style.display = '';
            if (sortOrderFieldWrapper) sortOrderFieldWrapper.style.display = '';
            if (barcodeRow) barcodeRow.style.display = '';
        }

        function updateTotalStock() {
            const hasVariations = container.children.length > 0;
            if (hasVariations) {
                hideBasicInfoFields();
                let total = 0;
                document.querySelectorAll('.variation-stock').forEach(input => {
                    total += parseFloat(input.value) || 0;
                });
                stockInput.value = total;
                stockInput.setAttribute('readonly', 'readonly');
                stockInput.style.backgroundColor = '#f8f9fa';
            } else {
                showBasicInfoFields();
                stockInput.removeAttribute('readonly');
                stockInput.style.backgroundColor = '#fff';
                if (stockInput.value === '' || isNaN(stockInput.value)) {
                    stockInput.value = 0;
                }
            }
        }

        function reindexVariations() {
            Array.from(container.children).forEach((variation, index) => {
                variation.querySelector('.variation-number').textContent = index + 1;
                const inputs = variation.querySelectorAll('input, select');
                inputs.forEach(input => {
                    if (input.name) {
                        input.name = input.name.replace(/\[variations\]\[\d+\]/, `[variations][${index}]`);
                    }
                });

                // Update variation image attributes
                const imageUpload = variation.querySelector('.variation-image-upload');
                const imagePreview = variation.querySelector('.variation-image-preview');
                const mainImageUpload = variation.querySelector('.variation-main-image-upload');
                const mainImagePreview = variation.querySelector('.variation-main-image-preview');

                if (imageUpload) imageUpload.dataset.variationIndex = index;
                if (imagePreview) imagePreview.dataset.variationIndex = index;
                if (mainImageUpload) mainImageUpload.dataset.variationIndex = index;
                if (mainImagePreview) mainImagePreview.dataset.variationIndex = index;
            });
            variationCounter = container.children.length;
            updateTotalStock();
        }

        addBtn?.addEventListener('click', () => {
            const clone = template.firstElementChild.cloneNode(true);
            clone.innerHTML = clone.innerHTML.replace(/INDEX/g, variationCounter);
            clone.querySelector('.variation-number').textContent = variationCounter + 1;
            container.appendChild(clone);
            setupVariationCalc(clone);
            setupVariationImageUpload(clone);
            variationCounter++;
            togglePricingTab();
            updateTotalStock();
        });

        function setupVariationCalc(variation) {
            const stockInputVar = variation.querySelector('.variation-stock');
            const inputs = [
                '.variation-selling-price',
                '.variation-discount',
                '.variation-tax-amount',
                '.variation-tax-type',
                'input[name*="is_taxable"]'
            ];
            const totalEl = variation.querySelector('.variation-total-price');
            function calculate() {
                const price = parseFloat(variation.querySelector('.variation-selling-price').value) || 0;
                const discount = parseFloat(variation.querySelector('.variation-discount').value) || 0;
                const tax = parseFloat(variation.querySelector('.variation-tax-amount').value) || 0;
                const type = variation.querySelector('.variation-tax-type').value;
                const taxable = variation.querySelector('input[name*="is_taxable"]').checked;
                let total = price - discount;
                if (taxable) total += type == '1' ? tax : (total * tax / 100);
                totalEl.value = total.toFixed(2);
                updateTotalStock();
            }
            inputs.forEach(selector => {
                const el = variation.querySelector(selector);
                if (el) {
                    el.addEventListener('input', calculate);
                    if (el.type === 'checkbox') el.addEventListener('change', calculate);
                }
            });
            if (stockInputVar) {
                stockInputVar.addEventListener('input', updateTotalStock);
            }
            variation.querySelector('.remove-variation').addEventListener('click', () => {
                variation.remove();
                togglePricingTab();
                reindexVariations();
            });
        }

        // Initialize existing variations
        document.querySelectorAll('.variation-item').forEach(setupVariationCalc);
        reindexVariations();
        togglePricingTab();

        // ===========================================
        // DYNAMIC CATEGORY SELECTION
        // ===========================================
        const categoryContainer = document.getElementById('category-selects-container');
        const categoryHiddenInput = document.getElementById('category_id');
        const categoryPathDisplay = document.getElementById('category-path');

        let selectedCategoryPath = [];
        let currentCategoryId = null;

        // Initialize category selection
        function initializeCategorySelection() {
            loadCategoryLevel(null, 0);

            // Load existing category if editing
            const existingCategoryId = categoryHiddenInput.value;
            if (existingCategoryId) {
                loadExistingCategoryPath(existingCategoryId);
            }
        }

        // Load category level
        function loadCategoryLevel(parentId, level) {
            const url = parentId
                ? `/organizations/categories/${parentId}/children`
                : '/organizations/categories/roots';

            fetch(url)
                .then(response => response.json())
                .then(categories => {
                    if (categories.length > 0) {
                        createCategorySelect(categories, level, parentId);
                    } else if (level === 0) {
                        categoryContainer.innerHTML = '<p class="text-muted small mb-0">{{ __('messages.no_categories') }}</p>';
                    }
                })
                .catch(error => {
                    console.error('Error loading categories:', error);
                });
        }

        // Create category select
        function createCategorySelect(categories, level, parentId) {
            // Remove all selects after this level
            const existingSelects = categoryContainer.querySelectorAll('.category-level');
            existingSelects.forEach((select, index) => {
                if (index >= level) {
                    select.remove();
                }
            });

            // Trim selected path
            selectedCategoryPath = selectedCategoryPath.slice(0, level);

            // Create wrapper
            const wrapper = document.createElement('div');
            wrapper.className = 'category-level';
            wrapper.dataset.level = level;

            // Create select
            const select = document.createElement('select');
            select.className = 'form-select form-select-sm category-select';
            select.dataset.level = level;

            // Default option
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = level === 0
                ? '{{ __('messages.main_category') }}'
                : '{{ __('messages.select_or_keep_parent') }}';
            select.appendChild(defaultOption);

            // Add categories
            categories.forEach(cat => {
                const option = document.createElement('option');
                option.value = cat.id;
                option.textContent = cat.name;
                option.dataset.hasChildren = cat.children_count > 0 ? '1' : '0';
                select.appendChild(option);
            });

            wrapper.appendChild(select);
            categoryContainer.appendChild(wrapper);

            // Event handler
            select.addEventListener('change', function() {
                const selectedId = this.value;
                const selectedName = this.options[this.selectedIndex].text;
                const hasChildren = this.options[this.selectedIndex].dataset.hasChildren === '1';

                if (selectedId) {
                    selectedCategoryPath[level] = {
                        id: selectedId,
                        name: selectedName
                    };

                    currentCategoryId = selectedId;
                    categoryHiddenInput.value = selectedId;

                    if (hasChildren) {
                        loadCategoryLevel(selectedId, level + 1);
                    } else {
                        // Remove any selects after this
                        const selectsToRemove = categoryContainer.querySelectorAll(`.category-level[data-level="${level + 1}"]`);
                        selectsToRemove.forEach(s => s.remove());
                        selectedCategoryPath = selectedCategoryPath.slice(0, level + 1);
                    }

                    updateCategoryPath();
                    filterOptionsByCategory(selectedId);
                } else {
                    // Clear selection at this level
                    const selectsToRemove = categoryContainer.querySelectorAll(`.category-level`);
                    selectsToRemove.forEach((s, index) => {
                        if (index > level) s.remove();
                    });

                    selectedCategoryPath = selectedCategoryPath.slice(0, level);

                    if (selectedCategoryPath.length > 0) {
                        currentCategoryId = selectedCategoryPath[selectedCategoryPath.length - 1].id;
                        categoryHiddenInput.value = currentCategoryId;
                        filterOptionsByCategory(currentCategoryId);
                    } else {
                        currentCategoryId = null;
                        categoryHiddenInput.value = '';
                        filterOptionsByCategory(null);
                    }

                    updateCategoryPath();
                }
            });
        }

        // Update category path display
        function updateCategoryPath() {
            if (selectedCategoryPath.length === 0) {
                categoryPathDisplay.innerHTML = '<span class="text-muted">{{ __('messages.please_select_category') }}</span>';
            } else {
                const pathText = selectedCategoryPath.map(item => item.name).join(' <i class="fas fa-angle-left mx-2"></i> ');
                categoryPathDisplay.innerHTML = pathText;
            }
        }

        // Load existing category path for edit
        function loadExistingCategoryPath(categoryId) {
            fetch(`/organizations/categories/${categoryId}/path`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        selectedCategoryPath = data;
                        currentCategoryId = categoryId;

                        // Recursively load and select categories
                        let currentLevel = 0;

                        function selectNext(index) {
                            if (index >= data.length) {
                                updateCategoryPath();
                                filterOptionsByCategory(categoryId);
                                return;
                            }

                            setTimeout(() => {
                                const select = categoryContainer.querySelector(`.category-select[data-level="${currentLevel}"]`);
                                if (select) {
                                    select.value = data[index].id;

                                    if (index < data.length - 1) {
                                        loadCategoryLevel(data[index].id, currentLevel + 1);
                                        currentLevel++;
                                        setTimeout(() => selectNext(index + 1), 300);
                                    } else {
                                        updateCategoryPath();
                                        filterOptionsByCategory(categoryId);
                                    }
                                }
                            }, 100);
                        }

                        selectNext(0);
                    }
                })
                .catch(error => {
                    console.error('Error loading category path:', error);
                });
        }

        // ===========================================
        // FILTER OPTIONS BY CATEGORY
        // ===========================================
        function filterOptionsByCategory(categoryId) {
            // Get all option containers
            const optionContainers = document.querySelectorAll('[data-option-id]');

            if (!categoryId) {
                // Show all options if no category selected
                optionContainers.forEach(container => {
                    container.style.display = '';
                });
                return;
            }

            // Fetch filtered options for this category
            fetch(`/organizations/categories/${categoryId}/options`)
                .then(response => response.json())
                .then(data => {
                    const allowedOptionIds = data.option_ids || [];

                    optionContainers.forEach(container => {
                        const optionId = parseInt(container.dataset.optionId);

                        if (allowedOptionIds.includes(optionId)) {
                            // Show this option
                            container.style.display = '';
                        } else {
                            // Hide this option and reset its value
                            container.style.display = 'none';
                            const select = container.querySelector('select');
                            if (select) {
                                select.value = '';
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('Error filtering options:', error);
                });
        }

        // Initialize
        initializeCategorySelection();

        // Re-apply filters when new variations are added
        const addVariationBtn = document.getElementById('addVariation');
        if (addVariationBtn) {
            const originalAddClick = addVariationBtn.onclick;
            addVariationBtn.addEventListener('click', function(e) {
                // Let the original add variation logic run
                setTimeout(() => {
                    const latestVariation = document.querySelector('#variationsContainer .variation-item:last-child');
                    if (latestVariation && currentCategoryId) {
                        filterOptionsByCategory(currentCategoryId);
                    }
                }, 100);
            });
        }

        @if(isset($product) && $product->variations && $product->variations->count() > 0)
        hideBasicInfoFields();
        @endif

        // Monitor variation container for changes
        const variationsContainer = document.getElementById('variationsContainer');
        if (variationsContainer) {
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.addedNodes.length > 0 && currentCategoryId) {
                        filterOptionsByCategory(currentCategoryId);
                    }
                });
            });

            observer.observe(variationsContainer, {
                childList: true,
                subtree: true
            });
        }
    });
</script>
