<!-- Product Form - All-in-One (HTML + CSS + JS) -->
<form action="{{ $route }}" method="POST" enctype="multipart/form-data" id="productForm">
    @csrf
    @method($method)

    <style>
        /* Reset & Base Styles */
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
    </style>

    <div class="card-body">
        <!-- Nav Tabs -->
        <ul class="nav-tabs" id="productTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#basic">Basic Info</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#pricing">Pricing & Tax</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#inventory">Inventory</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#translations">Translations</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#variations">Variations</button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- Basic Info -->
            <div class="tab-pane active" id="basic">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Slug</label>
                            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror"
                                   value="{{ old('slug') }}" id="slug">
                            @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">SKU</label>
                            <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror"
                                   value="{{ old('sku') }}">
                            @error('sku')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Brand</label>
                            <select name="brand_id" class="form-select @error('brand_id') is-invalid @enderror">
                                <option value="">Select Brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
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
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Product Type</label>
                            <select name="type" class="form-select @error('type') is-invalid @enderror">
                                <option value="1" {{ old('type', 1) == 1 ? 'selected' : '' }}>Physical</option>
                                <option value="2" {{ old('type') == 2 ? 'selected' : '' }}>Digital</option>
                                <option value="3" {{ old('type') == 3 ? 'selected' : '' }}>Service</option>
                            </select>
                            @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Barcode</label>
                            <input type="text" name="barcode" class="form-control @error('barcode') is-invalid @enderror"
                                   value="{{ old('barcode') }}">
                            @error('barcode')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror"
                                   value="{{ old('sort_order', 0) }}">
                            @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="requires_shipping" value="1"
                                   id="requires_shipping" {{ old('requires_shipping', 1) ? 'checked' : '' }}>
                            <label class="form-check-label" for="requires_shipping">Requires Shipping</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_featured" value="1"
                                   id="is_featured" {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">Featured Product</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pricing & Tax -->
            <div class="tab-pane" id="pricing">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Cost Price</label>
                            <input type="number" step="0.01" name="cost_price" class="form-control @error('cost_price') is-invalid @enderror"
                                   value="{{ old('cost_price', 0) }}" id="cost_price">
                            @error('cost_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Selling Price</label>
                            <input type="number" step="0.01" name="selling_price" class="form-control @error('selling_price') is-invalid @enderror"
                                   value="{{ old('selling_price', 0) }}" id="selling_price">
                            @error('selling_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Discount</label>
                            <input type="number" step="0.01" name="discount" class="form-control @error('discount') is-invalid @enderror"
                                   value="{{ old('discount', 0) }}" id="discount">
                            @error('discount')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Total Price</label>
                            <input type="number" step="0.01" name="total_price" class="form-control"
                                   value="{{ old('total_price', 0) }}" id="total_price" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_taxable" value="1"
                                   id="is_taxable" {{ old('is_taxable') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_taxable">Is Taxable</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Tax Type</label>
                            <select name="tax_type" class="form-select @error('tax_type') is-invalid @enderror" id="tax_type">
                                <option value="1" {{ old('tax_type', 1) == 1 ? 'selected' : '' }}>Amount</option>
                                <option value="2" {{ old('tax_type') == 2 ? 'selected' : '' }}>Percentage</option>
                            </select>
                            @error('tax_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Tax Amount</label>
                            <input type="number" step="0.01" name="tax_amount" class="form-control @error('tax_amount') is-invalid @enderror"
                                   value="{{ old('tax_amount', 0) }}" id="tax_amount">
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
                            <label class="form-label">Stock Quantity</label>
                            <input type="number" name="stock_quantity" class="form-control @error('stock_quantity') is-invalid @enderror"
                                   value="{{ old('stock_quantity', 0) }}" id="stock_quantity">
                            @error('stock_quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Low Stock Threshold</label>
                            <input type="number" name="low_stock_threshold" class="form-control @error('low_stock_threshold') is-invalid @enderror"
                                   value="{{ old('low_stock_threshold', 5) }}" id="low_stock_threshold">
                            @error('low_stock_threshold')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
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
                                <label class="form-label">Name</label>
                                <input type="text" name="{{ $locale }}[name]" class="form-control @error("$locale.name") is-invalid @enderror"
                                       value="{{ old("$locale.name", $product?->translate($locale)?->name ?? '') }}" required>
                                @error("$locale.name")
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Short Description</label>
                                <input type="text" name="{{ $locale }}[short_description]" class="form-control @error("$locale.short_description") is-invalid @enderror"
                                       value="{{ old("$locale.short_description", $product?->translate($locale)?->short_description ?? '') }}" required>
                                @error("$locale.short_description")
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="{{ $locale }}[description]" class="form-control @error("$locale.description") is-invalid @enderror"
                                          rows="3" required>{{ old("$locale.description", $product?->translate($locale)?->description ?? '') }}</textarea>
                                @error("$locale.description")
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Variations -->
            <div class="tab-pane" id="variations">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Variations</h5>
                    <button type="button" class="btn btn-success btn-sm" id="addVariation">
                        <i class="fas fa-plus"></i> Add Variation
                    </button>
                </div>
                <div id="variationsContainer"></div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="card-footer">
        <a href="{{ route('organization.products.index') }}" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">
            {{ isset($product) ? 'Update Product' : 'Create Product' }}
        </button>
    </div>
</form>

<!-- Hidden Variation Template -->
<div id="variationTemplate">
    <div class="variation-item">
        <div class="card-header">
            <span>Variation <span class="variation-number"></span></span>
            <button type="button" class="btn btn-danger btn-sm remove-variation">Remove</button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">SKU</label>
                        <input type="text" name="variations[INDEX][sku]" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Barcode</label>
                        <input type="text" name="variations[INDEX][barcode]" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Cost Price</label>
                        <input type="number" step="0.01" name="variations[INDEX][cost_price]" class="form-control variation-cost-price" value="0">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Selling Price</label>
                        <input type="number" step="0.01" name="variations[INDEX][selling_price]" class="form-control variation-selling-price" value="0">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Stock Quantity</label>
                        <input type="number" name="variations[INDEX][stock_quantity]" class="form-control" value="0">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Discount</label>
                        <input type="number" step="0.01" name="variations[INDEX][discount]" class="form-control variation-discount" value="0">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Tax Amount</label>
                        <input type="number" step="0.01" name="variations[INDEX][tax_amount]" class="form-control variation-tax-amount" value="0">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Tax Type</label>
                        <select name="variations[INDEX][tax_type]" class="form-select variation-tax-type">
                            <option value="1">Amount</option>
                            <option value="2">Percentage</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Total Price</label>
                        <input type="number" step="0.01" name="variations[INDEX][total_price]" class="form-control variation-total-price" value="0" readonly>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="variations[INDEX][is_taxable]" value="1">
                        <label class="form-check-label">Is Taxable</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="variations[INDEX][is_featured]" value="1">
                        <label class="form-check-label">Is Featured</label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Options</label>
                <div class="row">
                    @foreach($options as $option)
                        <div class="col-md-6 mb-2">
                            <label class="form-label">{{ $option->name }}</label>
                            <select name="variations[INDEX][option_items][]" class="form-select">
                                <option value="">Select {{ $option->name }}</option>
                                @foreach($option->items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Variation Names</label>
                @foreach(config('translatable.locales') as $locale)
                    <div class="mb-2">
                        <label class="form-label">{{ ucfirst($locale) }}</label>
                        <input type="hidden" name="variations[INDEX][translations][{{ $locale }}][locale]" value="{{ $locale }}">
                        <input type="text" name="variations[INDEX][translations][{{ $locale }}][name]" class="form-control" placeholder="Name in {{ ucfirst($locale) }}">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    // Pure JavaScript (no jQuery) for Tabs, Slug, Price Calc, Variations
    document.addEventListener('DOMContentLoaded', function () {
        // Slug from English name
        const nameEn = document.querySelector('input[name="en[name]"]') || document.getElementById('name_en');
        const slugInput = document.getElementById('slug');
        if (nameEn && slugInput) {
            nameEn.addEventListener('input', function () {
                const value = this.value.trim();
                if (value) {
                    const slug = value
                        .toLowerCase()
                        .replace(/[^a-z0-9\s-]/g, '')
                        .replace(/[\s_-]+/g, '-')
                        .replace(/^-+|-+$/g, '');
                    slugInput.value = slug;
                }
            });
        }

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

        // Main Price Calculation
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

        // Dynamic Variations
        let variationIndex = 0;
        const addBtn = document.getElementById('addVariation');
        const container = document.getElementById('variationsContainer');
        const template = document.getElementById('variationTemplate');

        addBtn?.addEventListener('click', () => {
            const clone = template.firstElementChild.cloneNode(true);
            clone.innerHTML = clone.innerHTML.replace(/INDEX/g, variationIndex);
            clone.querySelector('.variation-number').textContent = variationIndex + 1;

            container.appendChild(clone);

            setupVariationCalc(clone);
            variationIndex++;
        });

        function setupVariationCalc(variation) {
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
            }

            inputs.forEach(selector => {
                const el = variation.querySelector(selector);
                if (el) {
                    el.addEventListener('input', calculate);
                    if (el.type === 'checkbox') el.addEventListener('change', calculate);
                }
            });

            // Remove button
            variation.querySelector('.remove-variation').addEventListener('click', () => {
                variation.remove();
            });
        }
    });
</script>
