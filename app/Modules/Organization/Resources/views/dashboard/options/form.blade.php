<form action="{{ isset($option) ? route('organization.options.update', $option->id) : route('organization.options.store') }}"
      method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($option))
        @method('PUT')
    @endif

    {{-- Dynamic Cascading Category Selects --}}
    <div class="form-group mb-4">
        <label>{{ __('messages.category') }}</label>

        {{-- Container for dynamic selects --}}
        <div id="category-selects-container" class="row">
            {{-- First level (Main Categories) --}}
            <div class="col-md-4 category-level" data-level="0">
                <label class="text-muted small">{{ __('messages.main_category') }}</label>
                <select class="form-control category-select" data-level="0">
                    <option value="">{{ __('messages.select') }}</option>
                    @foreach($mainCategories as $cat)
                        <option value="{{ $cat->id }}" data-has-children="{{ $cat->children_count > 0 ? '1' : '0' }}">
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Hidden input for final selected category --}}
        <input type="hidden" name="category_id" id="category_id" class="@error('category_id') is-invalid @enderror">

        @error('category_id')
        <div class="text-danger mt-2">{{ $message }}</div>
        @enderror

        {{-- Selected Path Display --}}
        <div class="mt-3 p-2 bg-light rounded">
            <small class="text-muted">
                <i class="fas fa-sitemap"></i> {{ __('messages.selected_path') }}:
            </small>
            <div id="category-path" class="text-primary font-weight-bold mt-1">
                <span class="text-muted">{{ __('messages.please_select_category') }}</span>
            </div>
        </div>
    </div>

    {{-- Name Fields --}}
    <div class="row">
        @foreach (config('translatable.locales') as $locale)
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name_{{ $locale }}">{{ __("messages.name_$locale") }}</label>
                    <input type="text" name="{{ $locale }}[name]" id="name_{{ $locale }}"
                           class="form-control @error("$locale.name") is-invalid @enderror"
                           value="{{ old("$locale.name", isset($option) ? $option->translate($locale)->name : '') }}" required>
                    @error("$locale.name")
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        @endforeach
    </div>

    <br><br>
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> {{ __('messages.submit') }}
    </button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('category-selects-container');
        const hiddenInput = document.getElementById('category_id');
        const pathDisplay = document.getElementById('category-path');

        let selectedPath = []; // Store selected categories info

        // Update the visual path display
        function updatePathDisplay() {
            if (selectedPath.length === 0) {
                pathDisplay.innerHTML = '<span class="text-muted">{{ __('messages.please_select_category') }}</span>';
            } else {
                const pathText = selectedPath.map(item => item.name).join(' <i class="fas fa-angle-left mx-2"></i> ');
                pathDisplay.innerHTML = pathText;
            }
        }

        // Update hidden input with final selected category
        function updateHiddenInput() {
            if (selectedPath.length > 0) {
                const lastSelected = selectedPath[selectedPath.length - 1];
                hiddenInput.value = lastSelected.id;
            } else {
                hiddenInput.value = '';
            }
        }

        // Remove all selects after a specific level
        function removeSelectsAfterLevel(level) {
            const selectsToRemove = container.querySelectorAll(`.category-level[data-level="${level + 1}"]`);
            selectsToRemove.forEach(select => select.remove());

            // Also remove all levels after this one
            const allSelects = container.querySelectorAll('.category-level');
            allSelects.forEach(select => {
                const selectLevel = parseInt(select.getAttribute('data-level'));
                if (selectLevel > level) {
                    select.remove();
                }
            });
        }

        // Load children and create new select if needed
        function loadChildren(parentId, parentName, currentLevel) {
            if (!parentId) {
                removeSelectsAfterLevel(currentLevel);
                selectedPath = selectedPath.slice(0, currentLevel);
                updatePathDisplay();
                updateHiddenInput();
                return;
            }

            // Update selected path
            selectedPath = selectedPath.slice(0, currentLevel + 1);
            selectedPath[currentLevel] = { id: parentId, name: parentName };

            fetch(`/organizations/categories/${parentId}/children`)
                .then(response => response.json())
                .then(data => {
                    // Remove any existing selects after current level
                    removeSelectsAfterLevel(currentLevel);

                    if (data.length > 0) {
                        // Has children - create new select
                        const newLevel = currentLevel + 1;
                        const colDiv = document.createElement('div');
                        colDiv.className = 'col-md-4 category-level';
                        colDiv.setAttribute('data-level', newLevel);
                        colDiv.style.animation = 'slideIn 0.3s ease-out';

                        const label = document.createElement('label');
                        label.className = 'text-muted small';
                        label.textContent = `{{ __('messages.level') }} ${newLevel + 1}`;

                        const select = document.createElement('select');
                        select.className = 'form-control category-select';
                        select.setAttribute('data-level', newLevel);

                        const defaultOption = document.createElement('option');
                        defaultOption.value = '';
                        defaultOption.textContent = '{{ __('messages.select_or_skip') }}';
                        select.appendChild(defaultOption);

                        data.forEach(cat => {
                            const option = document.createElement('option');
                            option.value = cat.id;
                            option.textContent = cat.name;
                            option.setAttribute('data-has-children', cat.children_count > 0 ? '1' : '0');
                            select.appendChild(option);
                        });

                        colDiv.appendChild(label);
                        colDiv.appendChild(select);
                        container.appendChild(colDiv);

                        // Add event listener to new select
                        select.addEventListener('change', handleSelectChange);

                        // User can keep parent as final selection
                        updatePathDisplay();
                        updateHiddenInput();
                    } else {
                        // No children, this is the final category
                        updatePathDisplay();
                        updateHiddenInput();
                    }
                })
                .catch(error => {
                    console.error('Error loading categories:', error);
                    alert('{{ __('messages.error_loading_categories') }}');
                });
        }

        // Handle select change
        function handleSelectChange(event) {
            const select = event.target;
            const level = parseInt(select.getAttribute('data-level'));
            const selectedOption = select.options[select.selectedIndex];
            const categoryId = selectedOption.value;
            const categoryName = selectedOption.textContent;
            const hasChildren = selectedOption.getAttribute('data-has-children') === '1';

            if (!categoryId) {
                removeSelectsAfterLevel(level);
                selectedPath = selectedPath.slice(0, level);
                updatePathDisplay();
                updateHiddenInput();
                return;
            }

            if (hasChildren) {
                // Load children
                loadChildren(categoryId, categoryName, level);
            } else {
                // No children, this is final selection
                removeSelectsAfterLevel(level);
                selectedPath = selectedPath.slice(0, level + 1);
                selectedPath[level] = { id: categoryId, name: categoryName };
                updatePathDisplay();
                updateHiddenInput();
            }
        }

        // Attach event listeners to initial select
        const initialSelect = container.querySelector('.category-select');
        if (initialSelect) {
            initialSelect.addEventListener('change', handleSelectChange);
        }

        // Load initial data if editing
        @if(isset($option) && $option->category_id)
        fetch(`/organizations/categories/{{ $option->category_id }}/path`)
            .then(response => response.json())
            .then(data => {
                if (data && data.length > 0) {
                    // Recursively load and select categories
                    let currentLevel = 0;

                    function selectNext(index) {
                        if (index >= data.length) return;

                        const select = container.querySelector(`.category-select[data-level="${currentLevel}"]`);
                        if (select) {
                            select.value = data[index].id;

                            if (index < data.length - 1) {
                                // Load children for next level
                                loadChildren(data[index].id, data[index].name, currentLevel);
                                currentLevel++;
                                setTimeout(() => selectNext(index + 1), 300);
                            } else {
                                // Last item
                                selectedPath = data;
                                updatePathDisplay();
                                updateHiddenInput();
                            }
                        }
                    }

                    selectNext(0);
                }
            });
        @endif
    });
</script>

<style>
    .category-level {
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
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
        transition: border-color 0.3s ease;
    }

    .category-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }

    .bg-light {
        background-color: #f8f9fa !important;
    }
</style>
