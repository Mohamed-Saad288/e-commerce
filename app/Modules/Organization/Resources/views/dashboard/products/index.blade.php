@extends('organization::dashboard.master')
@section('title', __('organizations.products'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ __('organizations.products') }}</h4>
                        <div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fas fa-download"></i> {{ __('organizations.export') }}
                                </button>

                                <ul class="dropdown-menu @if (LaravelLocalization::getCurrentLocale() == 'ar') dropdown-menu-end @endif">
                                    <li>
                                        <a class="dropdown-item export-btn" href="#" data-type="excel"
                                            role="menuitem">
                                            <i class="far fa-file-excel me-2"></i> {{ __('organizations.excel') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item export-btn" href="#" data-type="csv" role="menuitem">
                                            <i class="fas fa-file-csv me-2"></i> {{ __('organizations.csv') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item export-btn" href="#" data-type="pdf" role="menuitem">
                                            <i class="far fa-file-pdf me-2"></i> {{ __('organizations.pdf') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <a href="{{ route('organization.products.create') }}" class="btn btn-primary ms-2">
                                {{ __('organizations.add_product') }}
                            </a>
                        </div>
                    </div>

                    <!-- Filter Section -->
                    <div class="card-body border-bottom">
                        <form id="filterForm" method="GET" action="{{ route('organization.products.index') }}">
                            <!-- Search and Results Row -->
                            <div class="row mb-3 align-items-end">
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">{{ __('messages.search') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fe fe-search text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0 ps-0" id="search-input"
                                            placeholder="{{ __('messages.search') }}..." value="{{ request('search') }}">
                                        <button class="btn btn-outline-secondary" type="button" id="clear-search"
                                            title="{{ __('messages.clear') }}">
                                            <i class="fe fe-x"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-2 ms-auto text-end">
                                    <label class="form-label small text-muted mb-1">{{ __('messages.results') }}</label>
                                    <div class="badge bg-primary fs-6 py-2 px-3 w-100" id="results-count">0</div>
                                </div>
                            </div>

                            <!-- Filters Row -->
                            <div class="row mb-4 align-items-end">
                                <!-- Category Filter -->
                                <div class="col-md-3">
                                    <label
                                        class="form-label small text-muted mb-1">{{ __('organizations.category') }}</label>
                                    <select name="category" id="category" class="form-control filter-select">
                                        <option value="">{{ __('organizations.all_categories') }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Brand Filter -->
                                <div class="col-md-3">
                                    <label class="form-label small text-muted mb-1">{{ __('organizations.brand') }}</label>
                                    <select name="brand" id="brand" class="form-control filter-select">
                                        <option value="">{{ __('organizations.all_brands') }}</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Stock Status Filter -->
                                <div class="col-md-3">
                                    <label
                                        class="form-label small text-muted mb-1">{{ __('organizations.stock_status') }}</label>
                                    <select name="stock_status" id="stock_status" class="form-control filter-select">
                                        <option value="">{{ __('organizations.all_stock_status') }}</option>
                                        <option value="in_stock"
                                            {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>
                                            {{ __('organizations.in_stock') }}
                                        </option>
                                        <option value="out_of_stock"
                                            {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>
                                            {{ __('organizations.out_of_stock') }}
                                        </option>
                                        <option value="low_stock"
                                            {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>
                                            {{ __('organizations.low_stock') }}
                                        </option>
                                    </select>
                                </div>

                                <!-- Status Filter -->
                                <div class="col-md-3">
                                    <label class="form-label small text-muted mb-1">{{ __('messages.status') }}</label>
                                    <select name="status" id="status" class="form-control filter-select">
                                        <option value="">{{ __('organizations.all_status') }}</option>
                                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>
                                            {{ __('messages.active') }}
                                        </option>
                                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>
                                            {{ __('messages.inactive') }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Products Table -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table datatables" id="productsTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('messages.image') }}</th>
                                        <th>{{ __('messages.name') }} / SKU</th>
                                        <th>{{ __('organizations.options') }}</th>
                                        <th>{{ __('organizations.category') }}</th>
                                        <th>{{ __('organizations.brand') }}</th>
                                        <th>{{ __('organizations.price') }}</th>
                                        <th>{{ __('organizations.stock') }}</th>
                                        <th>{{ __('messages.status') }}</th>
                                        <th>{{ __('messages.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="productsTableBody">
                                    @include('organization::dashboard.products.products_rows', [
                                        'products' => $products,
                                    ])
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4" id="paginationContainer">
                            @if ($products->hasPages())
                                {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Edit Variation Modal -->
    <div class="modal fade" id="quickEditModal" tabindex="-1" aria-labelledby="quickEditModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quickEditModalLabel">{{ __('messages.quick_edit_variation') }}</h5>
                    <button type="button" class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="quickEditForm">
                    @csrf
                    <input type="hidden" id="edit_variation_id" name="variation_id">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">SKU</label>
                                <input type="text" class="form-control" id="edit_sku" name="sku" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('messages.barcode') }}</label>
                                <input type="text" class="form-control" id="edit_barcode" name="barcode">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">{{ __('messages.cost_price') }}</label>
                                <input type="number" step="0.01" class="form-control" id="edit_cost_price"
                                    name="cost_price" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">{{ __('messages.selling_price') }}</label>
                                <input type="number" step="0.01" class="form-control" id="edit_selling_price"
                                    name="selling_price" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">{{ __('messages.stock_quantity') }}</label>
                                <input type="number" class="form-control" id="edit_stock_quantity"
                                    name="stock_quantity" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('messages.discount') }}</label>
                                <input type="number" step="0.01" class="form-control" id="edit_discount"
                                    name="discount">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('messages.tax_amount') }}</label>
                                <input type="number" step="0.01" class="form-control" id="edit_tax_amount"
                                    name="tax_amount">
                            </div>
                        </div>

                        <!-- Main Images -->
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.variation_main_images') }}</label>
                            <div class="image-upload-container" id="quickEditMainImageUpload">
                                <input type="file" name="main_images[]" id="quickEditMainImages" multiple
                                    accept="image/*">
                                <div class="upload-text">
                                    <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                                    <p>{{ __('messages.click_to_upload_main') }}</p>
                                </div>
                            </div>
                            <div class="image-preview-grid mt-2" id="quickEditMainImagesPreview"></div>
                        </div>

                        <!-- Additional Images -->
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.variation_additional_images') }}</label>
                            <div class="image-upload-container" id="quickEditAdditionalImageUpload">
                                <input type="file" name="additional_images[]" id="quickEditAdditionalImages" multiple
                                    accept="image/*">
                                <div class="upload-text">
                                    <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                                    <p>{{ __('messages.click_to_upload_additional') }}</p>
                                </div>
                            </div>
                            <div class="image-preview-grid mt-2" id="quickEditAdditionalImagesPreview"></div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('messages.save_changes') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Make quick edit modal images smaller */
        #quickEditMainImagesPreview .image-preview-item,
        #quickEditAdditionalImagesPreview .image-preview-item {
            width: 80px;
            height: 80px;
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid #e0e0e0;
        }

        #quickEditMainImagesPreview .image-preview-item img,
        #quickEditAdditionalImagesPreview .image-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Improve X button design */
        #quickEditMainImagesPreview .image-preview-item .remove-image,
        #quickEditAdditionalImagesPreview .image-preview-item .remove-image {
            position: absolute;
            top: 2px;
            right: 2px;
            width: 20px;
            height: 20px;
            background: rgba(255, 0, 0, 0.8);
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            font-size: 14px;
            line-height: 18px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            z-index: 10;
        }

        #quickEditMainImagesPreview .image-preview-item .remove-image:hover,
        #quickEditAdditionalImagesPreview .image-preview-item .remove-image:hover {
            background: rgba(200, 0, 0, 1);
            transform: scale(1.1);
        }

        #quickEditMainImagesPreview,
        #quickEditAdditionalImagesPreview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        /* Fix modal header close button (X) visibility */
        .modal-header .btn-close {
            opacity: 1;
            font-size: 1.2rem;
            padding: 0.5rem;
            margin: -0.5rem -0.5rem -0.5rem auto;
        }

        .modal-header .btn-close:focus {
            box-shadow: none;
            opacity: 0.8;
        }

        /* Custom close button for better visibility */
        .btn-close-custom {
            background: transparent;
            border: none;
            font-size: 2rem;
            line-height: 1;
            color: #000;
            opacity: 0.5;
            padding: 0;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .btn-close-custom:hover {
            opacity: 1;
        }

        .btn-close-custom:focus {
            outline: none;
            opacity: 0.8;
        }
    </style>
@endsection

@section('after_script')

    <script>
        $(document).ready(function() {
            // Quick Edit Modal - Load variation data
            $(document).on('click', '.quick-edit-variation', function() {
                const variationId = $(this).data('variation-id');

                // CRITICAL: Clear everything first to prevent duplicates
                $('#quickEditMainImagesPreview').html('');
                $('#quickEditAdditionalImagesPreview').html('');
                $('#quickEditMainImages').val('');
                $('#quickEditAdditionalImages').val('');

                // Also clear the form fields
                $('#quickEditForm')[0].reset();

                // Show the modal
                $('#quickEditModal').modal('show');

                // Fetch variation data
                $.ajax({
                    url: `/organizations/product-variations/${variationId}`,
                    type: 'GET',
                    success: function(data) {
                        // Fill form fields
                        $('#edit_variation_id').val(data.id);
                        $('#edit_sku').val(data.sku);
                        $('#edit_barcode').val(data.barcode || '');
                        $('#edit_cost_price').val(data.cost_price);
                        $('#edit_selling_price').val(data.selling_price);
                        $('#edit_stock_quantity').val(data.stock_quantity);
                        $('#edit_discount').val(data.discount || '');
                        $('#edit_tax_amount').val(data.tax_amount || '');

                        // Clear again before adding images (double safety)
                        $('#quickEditMainImagesPreview').html('');
                        $('#quickEditAdditionalImagesPreview').html('');

                        // Display existing main images
                        if (data.main_images && data.main_images.length > 0) {
                            console.log('Loading main images:', data.main_images.length);
                            data.main_images.forEach(function(image) {
                                const preview = `
                                <div class="image-preview-item existing-image" data-media-id="${image.id}">
                                    <img src="${image.url}" alt="Main Image">
                                    <button type="button" class="remove-image" data-existing="true" data-media-id="${image.id}">×</button>
                                    <input type="hidden" name="main_images_existing[]" value="${image.id}" class="keep-image-input">
                                </div>
                            `;
                                $('#quickEditMainImagesPreview').append(preview);
                            });
                        }

                        // Display existing additional images
                        if (data.additional_images && data.additional_images.length > 0) {
                            console.log('Loading additional images:', data.additional_images
                                .length);
                            data.additional_images.forEach(function(image) {
                                const preview = `
                                <div class="image-preview-item existing-image" data-media-id="${image.id}">
                                    <img src="${image.url}" alt="Additional Image">
                                    <button type="button" class="remove-image" data-existing="true" data-media-id="${image.id}">×</button>
                                    <input type="hidden" name="additional_images_existing[]" value="${image.id}" class="keep-image-input">
                                </div>
                            `;
                                $('#quickEditAdditionalImagesPreview').append(preview);
                            });
                        }

                        console.log('Total main images in preview:', $(
                            '#quickEditMainImagesPreview .image-preview-item').length);
                        console.log('Total additional images in preview:', $(
                                '#quickEditAdditionalImagesPreview .image-preview-item')
                            .length);
                    },
                    error: function() {
                        toastr.error('{{ __('messages.error_loading_data') }}');
                    }
                });
            });

            // Quick Edit Modal - Save changes
            $('#quickEditForm').on('submit', function(e) {
                e.preventDefault();

                const variationId = $('#edit_variation_id').val();
                const formData = new FormData();

                // Add basic fields
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('_method', 'PUT');
                formData.append('sku', $('#edit_sku').val());
                formData.append('barcode', $('#edit_barcode').val() || '');
                formData.append('cost_price', $('#edit_cost_price').val());
                formData.append('selling_price', $('#edit_selling_price').val());
                formData.append('stock_quantity', $('#edit_stock_quantity').val());
                formData.append('discount', $('#edit_discount').val() || 0);
                formData.append('tax_amount', $('#edit_tax_amount').val() || 0);

                // Add new main images
                const mainImageFiles = $('#quickEditMainImages')[0].files;
                for (let i = 0; i < mainImageFiles.length; i++) {
                    formData.append('main_images[]', mainImageFiles[i]);
                }

                // Add new additional images
                const additionalImageFiles = $('#quickEditAdditionalImages')[0].files;
                for (let i = 0; i < additionalImageFiles.length; i++) {
                    formData.append('additional_images[]', additionalImageFiles[i]);
                }

                // Add existing images to keep
                $('#quickEditMainImagesPreview .keep-image-input').each(function() {
                    formData.append('main_images_existing[]', $(this).val());
                });

                $('#quickEditAdditionalImagesPreview .keep-image-input').each(function() {
                    formData.append('additional_images_existing[]', $(this).val());
                });

                $.ajax({
                    url: `/organizations/product-variations/${variationId}`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success('{{ __('messages.updated') }}');
                            $('#quickEditModal').modal('hide');
                            applyFilters(); // Reload the table
                        } else {
                            toastr.error('{{ __('messages.something_wrong') }}');
                        }
                    },
                    error: function() {
                        toastr.error('{{ __('messages.error_occurred') }}');
                    }
                });
            });

            // Quick Edit Modal - Main Images Upload Preview
            $('#quickEditMainImages').off('change').on('change', function(e) {
                const files = e.target.files;

                // Remove ONLY new upload previews, keep existing images
                $('#quickEditMainImagesPreview .new-upload').remove();

                if (files.length > 0) {
                    console.log('Adding main images:', files.length);

                    // Add new previews
                    Array.from(files).forEach((file, index) => {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            // Check if this preview already exists
                            if ($('#quickEditMainImagesPreview').find(
                                    `[data-index="${index}"].new-upload`).length === 0) {
                                const preview = `
                                <div class="image-preview-item new-upload" data-index="${index}">
                                    <img src="${event.target.result}" alt="Preview">
                                    <button type="button" class="remove-image remove-new" data-index="${index}">×</button>
                                </div>
                            `;
                                $('#quickEditMainImagesPreview').append(preview);
                            }
                        };
                        reader.readAsDataURL(file);
                    });
                }
            });

            // Quick Edit Modal - Additional Images Upload Preview
            $('#quickEditAdditionalImages').off('change').on('change', function(e) {
                const files = e.target.files;

                // Remove ONLY new upload previews, keep existing images
                $('#quickEditAdditionalImagesPreview .new-upload').remove();

                if (files.length > 0) {
                    console.log('Adding additional images:', files.length);

                    // Add new previews
                    Array.from(files).forEach((file, index) => {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            // Check if this preview already exists
                            if ($('#quickEditAdditionalImagesPreview').find(
                                    `[data-index="${index}"].new-upload`).length === 0) {
                                const preview = `
                                <div class="image-preview-item new-upload" data-index="${index}">
                                    <img src="${event.target.result}" alt="Preview">
                                    <button type="button" class="remove-image remove-new" data-index="${index}">×</button>
                                </div>
                            `;
                                $('#quickEditAdditionalImagesPreview').append(preview);
                            }
                        };
                        reader.readAsDataURL(file);
                    });
                }
            });

            // Remove image from preview
            $(document).on('click',
                '#quickEditMainImagesPreview .remove-image, #quickEditAdditionalImagesPreview .remove-image',
                function() {
                    const $item = $(this).closest('.image-preview-item');
                    const isExisting = $(this).data('existing');
                    const isNew = $(this).hasClass('remove-new');

                    if (isExisting) {
                        // For existing images, remove the keep-image-input to mark for deletion
                        $item.find('.keep-image-input').remove();
                        $item.fadeOut(300, function() {
                            $(this).remove();
                        });
                    } else if (isNew) {
                        // For new uploads, remove preview
                        const $container = $item.parent();
                        $item.remove();

                        // If no more new uploads, reset the file input
                        if ($container.find('.new-upload').length === 0) {
                            if ($container.attr('id') === 'quickEditMainImagesPreview') {
                                $('#quickEditMainImages').val('');
                            } else {
                                $('#quickEditAdditionalImages').val('');
                            }
                        }
                    } else {
                        // Fallback: just remove
                        $item.remove();
                    }
                });

            // Clear modal when it's hidden (extra safety)
            $('#quickEditModal').on('hidden.bs.modal', function() {
                $('#quickEditMainImagesPreview').html('');
                $('#quickEditAdditionalImagesPreview').html('');
                $('#quickEditMainImages').val('');
                $('#quickEditAdditionalImages').val('');
                $('#quickEditForm')[0].reset();
            });

            // تهيئة Select2 لجميع القوائم المنسدلة
            $('.filter-select').each(function() {
                $(this).select2({
                    placeholder: $(this).find('option[value=""]').text(),
                    allowClear: true,
                    width: '100%',
                    language: "{{ app()->getLocale() }}",
                    theme: 'bootstrap-5',
                    dropdownCssClass: 'custom-select2-dropdown',
                    minimumResultsForSearch: 10
                });
            });

            let searchTimeout;

            // تحديث عداد النتائج عند التحميل
            updateResultsCount();

            // 🔍 البحث الحي
            $('#search-input').on('keyup', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => applyFilters(), 400);
            });

            // 🔽 فلتر بالقوائم المنسدلة
            $('.filter-select').on('change', function() {
                applyFilters();
            });

            // ❌ مسح البحث والفلاتر
            $('#clear-search').on('click', function() {
                $('#search-input').val('');
                $('.filter-select').val('').trigger('change');
                applyFilters();
            });

            // 🖱️ إعادة تعيين الفلاتر عند اختيار "الكل"
            $('.filter-select').on('select2:clear', function() {
                applyFilters();
            });

            // 📄 Pagination AJAX
            $(document).on('click', '#paginationContainer .pagination a', function(e) {
                e.preventDefault();
                let pageUrl = $(this).attr('href');
                applyFilters(pageUrl);
            });

            // 🧠 دالة تطبيق الفلاتر والبحث
            function applyFilters(pageUrl = "{{ route('organization.products.index') }}") {
                let formData = $('#filterForm').serialize();
                if ($('#search-input').val()) {
                    formData += '&search=' + encodeURIComponent($('#search-input').val());
                }

                $.ajax({
                    url: pageUrl,
                    type: "GET",
                    data: formData,
                    beforeSend: function() {
                        $('#productsTableBody').html(`
                        <tr>
                            <td colspan="10" class="text-center">
                                <div class="spinner-border text-primary" style="width:3rem;height:3rem;" role="status">
                                    <span class="visually-hidden">{{ __('messages.loading') }}</span>
                                </div>
                            </td>
                        </tr>
                    `);
                    },
                    success: function(response) {
                        $('#productsTableBody').html(response.products_rows);
                        $('#paginationContainer').html(response.pagination);
                        updateResultsCount();
                    },
                    error: function() {
                        $('#productsTableBody').html(`
                        <tr>
                            <td colspan="10" class="text-center text-danger">{{ __('messages.error_loading_data') }}</td>
                        </tr>
                    `);
                    }
                });
            }

            // 🔢 تحديث عداد النتائج
            function updateResultsCount() {
                let rowsCount = $('#productsTableBody tr').not(':has(.no-data)').length;
                $('#results-count').text(rowsCount);
            }

            // تصدير البيانات
            $('.export-btn').click(function(e) {
                e.preventDefault();
                const exportType = $(this).data('type');
                let formData = $('#filterForm').serialize();
                if ($('#search-input').val()) {
                    formData += '&search=' + encodeURIComponent($('#search-input').val());
                }
                const url = "{{ route('organization.products.export') }}?type=" + exportType + "&" +
                    formData;
                window.location.href = url;
            });

            // تبديل الحالة
            $(document).on('change', '.toggle-status', function() {
                let productId = $(this).data('id');
                $.ajax({
                    url: "{{ route('organization.products.change_status', ':id') }}".replace(':id',
                        productId),
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        product_id: productId,
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success("{{ __('messages.updated') }}");
                            applyFilters();
                        } else {
                            toastr.error("{{ __('messages.something_wrong') }}");
                        }
                    },
                    error: function() {
                        toastr.error("{{ __('messages.error_occurred') }}");
                    }
                });
            });

            // حذف منتج أو variation
            $(document).on('click', '.delete-faq', function(e) {
                e.preventDefault();
                let itemId = $(this).data('id');
                let itemType = $(this).data('type');

                let deleteUrl = `/organizations/product-variations/${itemId}`;
                let row = $(this).closest('tr');

                Swal.fire({
                    title: "{{ __('messages.confirm_delete') }}",
                    text: "{{ __('messages.are_you_sure') }}",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "{{ __('messages.yes_delete') }}",
                    cancelButtonText: "{{ __('messages.no_cancel') }}"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: deleteUrl,
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                _method: "DELETE"
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire("{{ __('messages.deleted') }}", response
                                        .message, "success");
                                    applyFilters();
                                } else {
                                    Swal.fire("{{ __('messages.error') }}",
                                        "{{ __('messages.something_wrong') }}",
                                        "error");
                                }
                            },
                            error: function() {
                                Swal.fire("{{ __('messages.error') }}",
                                    "{{ __('messages.error_occurred') }}", "error");
                            }
                        });
                    }
                });
            });

            // 🖮 دعم اختصارات لوحة المفاتيح
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape') {
                    $('#search-input').val('');
                    $('.filter-select').val('').trigger('change');
                    applyFilters();
                }
            });
        });
    </script>

    <style>
        /* تحسين مظهر Select2 */
        .select2-container--bootstrap-5 .select2-selection {
            border-radius: 0.5rem;
            border: 1px solid #ced4da;
            height: 40px;
            padding: 0.375rem 0.75rem;
            display: flex;
            align-items: center;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            line-height: 1.5;
            color: #495057;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
            height: 100%;
        }

        .select2-container--bootstrap-5 .select2-results__option--highlighted {
            background-color: #0d6efd !important;
            color: #fff !important;
        }

        .custom-select2-dropdown {
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .select2-container--bootstrap-5 .select2-selection__clear {
            color: #dc3545;
            font-size: 1.2rem;
            cursor: pointer;
        }

        /* تحسين تأثير التحميل */
        .spinner-border {
            border-width: 0.3rem;
            animation: spin 0.8s linear infinite;
        }

        /* تحسين مظهر مربع البحث */
        .input-group-text {
            background-color: #f8f9fa;
            border-right: 0;
        }

        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        #results-count {
            background-color: #0d6efd;
            color: #fff;
            font-size: 1.25rem;
            font-weight: 700;
            border-radius: 0.5rem;
            text-align: center;
        }

        #clear-search:hover {
            background-color: #dc3545;
            color: #fff;
            border-color: #dc3545;
        }

        .btn:active {
            transform: scale(0.97);
            opacity: 0.85;
        }

        /* ضمان محاذاة العناصر في سطر واحد */
        .row.align-items-end {
            display: flex;
            align-items: flex-end;
        }
    </style>
@endsection
