<script>
    document.addEventListener('DOMContentLoaded', function() {
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
        // COLLAPSIBLE VARIATIONS FEATURE
        // ===========================================

        // Make this function globally accessible within this scope
        window.setupVariationCollapse = function(variationElement) {
            const header = variationElement.querySelector('.variation-header');
            const body = variationElement.querySelector('.variation-body');
            const icon = variationElement.querySelector('.variation-collapse-icon');

            if (header && body && icon) {
                // Remove any existing listeners to prevent duplicates
                const newHeader = header.cloneNode(true);
                header.parentNode.replaceChild(newHeader, header);

                newHeader.addEventListener('click', function(e) {
                    // Don't collapse if clicking the remove button
                    if (e.target.closest('.remove-variation')) {
                        return;
                    }

                    const currentBody = variationElement.querySelector('.variation-body');
                    const currentIcon = variationElement.querySelector('.variation-collapse-icon');

                    currentBody.classList.toggle('collapsed');
                    currentIcon.classList.toggle('collapsed');
                });
            }
        }

        // Collapse all variations
        document.getElementById('collapseAllVariations')?.addEventListener('click', function() {
            document.querySelectorAll('.variation-item').forEach(variation => {
                const body = variation.querySelector('.variation-body');
                const icon = variation.querySelector('.variation-collapse-icon');

                if (body && icon) {
                    body.classList.add('collapsed');
                    icon.classList.add('collapsed');
                }
            });
        });

        // Expand all variations
        document.getElementById('expandAllVariations')?.addEventListener('click', function() {
            document.querySelectorAll('.variation-item').forEach(variation => {
                const body = variation.querySelector('.variation-body');
                const icon = variation.querySelector('.variation-collapse-icon');

                if (body && icon) {
                    body.classList.remove('collapsed');
                    icon.classList.remove('collapsed');
                }
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
                    previewItem.querySelector('.remove-image').addEventListener('click', function(
                        e) {
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

        // Before form submit, prepare all images
        document.getElementById('productForm').addEventListener('submit', function(e) {
            // Main Images: Rename existing images to match array name
            const mainPreview = document.getElementById('mainImagesPreview');
            const existingMainImages = mainPreview.querySelectorAll(
                '.image-preview-item[data-is-existing="true"]');

            existingMainImages.forEach((item, index) => {
                const keepInput = item.querySelector('.keep-image-input');
                if (keepInput) {
                    keepInput.name = `main_images[existing][]`;
                }
            });

            // Additional Images: Rename existing images to match array name
            const additionalPreview = document.getElementById('additionalImagesPreview');
            const existingAdditionalImages = additionalPreview.querySelectorAll(
                '.image-preview-item[data-is-existing="true"]');

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
                    const existingVarMainImages = varMainPreview.querySelectorAll(
                        '.image-preview-item[data-is-existing="true"]');
                    existingVarMainImages.forEach(item => {
                        const keepInput = item.querySelector('.keep-image-input');
                        if (keepInput) {
                            keepInput.name =
                                `variations[${varIndex}][main_images][existing][]`;
                        }
                    });
                }

                // Variation Additional Images
                const varAdditionalPreview = variation.querySelector(
                    '.variation-image-preview');
                if (varAdditionalPreview) {
                    const existingVarAdditionalImages = varAdditionalPreview.querySelectorAll(
                        '.image-preview-item[data-is-existing="true"]');
                    existingVarAdditionalImages.forEach(item => {
                        const keepInput = item.querySelector('.keep-image-input');
                        if (keepInput) {
                            keepInput.name =
                                `variations[${varIndex}][additional_images][existing][]`;
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

        document.getElementById('clearAllVariations')?.addEventListener('click', function() {
            Swal.fire({
                title: "{{ __('messages.delete_all_variations_title') }}",
                text: "{{ __('messages.delete_all_variations_text') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "{{ __('messages.yes_delete_all') }}",
                cancelButtonText: "{{ __('messages.no_cancel') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    container.innerHTML = '';
                    variationCounter = 0;
                    togglePricingTab();
                    updateTotalStock();

                    Swal.fire({
                        title: "{{ __('messages.deleted') }}",
                        text: "{{ __('messages.all_variations_deleted_successfully') }}",
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        });


        // ===========================================
        // DYNAMIC VARIATIONS & IMAGE LOGIC
        // ===========================================
        let variationCounter =
            @isset($product)
                {{ $product->variations->count() }}
            @else
                0
            @endisset ;
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
            if (barcodeRow && barcodeFieldWrapper?.style.display === 'none' && sortOrderFieldWrapper?.style
                .display === 'none') {
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
            document.getElementById('variationsCount').textContent = container.children.length;
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
                        input.name = input.name.replace(/\[variations\]\[\d+\]/,
                            `[variations][${index}]`);
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
            window.setupVariationCollapse(clone);
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

            const removeBtn = variation.querySelector('.remove-variation');
            removeBtn.addEventListener('click', function(e) {
                e.stopPropagation();

                Swal.fire({
                    title: "{{ __('messages.confirm_delete') }}",
                    text: "{{ __('messages.are_you_sure_delete_variation') }}",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "{{ __('messages.yes_delete') }}",
                    cancelButtonText: "{{ __('messages.no_cancel') }}"
                }).then((result) => {
                    if (result.isConfirmed) {
                        variation.remove();
                        reindexVariations();
                        togglePricingTab();
                        updateTotalStock();

                        Swal.fire({
                            title: "{{ __('messages.deleted') }}",
                            text: "{{ __('messages.deleted_successfully') }}",
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            });
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
        }

        document.querySelectorAll('.variation-item').forEach(window.setupVariationCollapse);
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
            const url = parentId ?
                `/organizations/categories/${parentId}/children` :
                '/organizations/categories/roots';

            fetch(url)
                .then(response => response.json())
                .then(categories => {
                    if (categories.length > 0) {
                        createCategorySelect(categories, level, parentId);
                    } else if (level === 0) {
                        categoryContainer.innerHTML =
                            '<p class="text-muted small mb-0">{{ __('messages.no_categories') }}</p>';
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
            defaultOption.textContent = level === 0 ?
                '{{ __('messages.main_category') }}' :
                '{{ __('messages.select_or_keep_parent') }}';
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
                        const selectsToRemove = categoryContainer.querySelectorAll(
                            `.category-level[data-level="${level + 1}"]`);
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
                categoryPathDisplay.innerHTML =
                    '<span class="text-muted">{{ __('messages.please_select_category') }}</span>';
            } else {
                const pathText = selectedCategoryPath.map(item => item.name).join(
                    ' <i class="fas fa-angle-left mx-2"></i> ');
                categoryPathDisplay.innerHTML = pathText;
            }
        }

        // Load existing category path for edit
        async function loadExistingCategoryPath(categoryId) {
            try {
                const response = await fetch(`/organizations/categories/${categoryId}/path`);
                const data = await response.json();

                if (data && data.length > 0) {
                    selectedCategoryPath = data;
                    currentCategoryId = categoryId;

                    // Load categories level by level, waiting for each to complete
                    for (let index = 0; index < data.length; index++) {
                        // Wait for the category level to load
                        await loadCategoryLevelAsync(index === 0 ? null : data[index - 1].id, index);

                        // Wait a bit for DOM to update
                        await new Promise(resolve => setTimeout(resolve, 50));

                        // Select the category at this level
                        const select = categoryContainer.querySelector(
                            `.category-select[data-level="${index}"]`);
                        if (select) {
                            select.value = data[index].id;

                            // Trigger change event if not the last level
                            if (index < data.length - 1) {
                                // Don't trigger the change event, just set the value
                                // The next iteration will load the next level
                            }
                        }
                    }

                    // Update UI after all levels are loaded
                    updateCategoryPath();
                    filterOptionsByCategory(categoryId);
                }
            } catch (error) {
                console.error('Error loading category path:', error);
            }
        }

        // Async version of loadCategoryLevel that returns a promise
        function loadCategoryLevelAsync(parentId, level) {
            return new Promise((resolve, reject) => {
                const url = parentId ?
                    `/organizations/categories/${parentId}/children` :
                    '/organizations/categories/roots';

                fetch(url)
                    .then(response => response.json())
                    .then(categories => {
                        if (categories.length > 0) {
                            createCategorySelect(categories, level, parentId);
                        } else if (level === 0) {
                            categoryContainer.innerHTML =
                                '<p class="text-muted small mb-0">{{ __('messages.no_categories') }}</p>';
                        }
                        resolve();
                    })
                    .catch(error => {
                        console.error('Error loading categories:', error);
                        reject(error);
                    });
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

        @if (isset($product) && $product->variations && $product->variations->count() > 0)
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
