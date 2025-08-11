<form action="{{ $route }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method($method)

    {{-- Name Field --}}
    <div class="row">
        @foreach (config('translatable.locales') as $locale)
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name_{{ $locale }}">{{ __("messages.name_$locale") }}</label>
                    <input type="text" name="{{ $locale }}[name]" id="name_{{ $locale }}"
                           class="form-control @error("$locale.name") is-invalid @enderror"
                           value="{{ old("$locale.name", $plan ? $plan->translate($locale)->name : '') }}" required>
                    @error("$locale.name")
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        @endforeach
    </div>

    {{-- Description Field --}}
    <div class="row">
        @foreach (config('translatable.locales') as $locale)
            <div class="col-md-6">
                <div class="form-group">
                    <label for="description_{{ $locale }}">{{ __("messages.description_$locale") }}</label>
                    <textarea name="{{ $locale }}[description]" id="description_{{ $locale }}"
                              class="form-control @error("$locale.description") is-invalid @enderror" rows="3" required>{{ old("$locale.description", $plan ? $plan->translate($locale)->description : '') }}</textarea>
                    @error("$locale.description")
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        @endforeach
    </div>

    {{-- Slug and Billing Type --}}
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label for="slug" class="font-weight-bold">{{ __("messages.slug") }}</label>
                <input type="text" name="slug" id="slug"
                       class="form-control @error('slug') is-invalid @enderror"
                       value="{{ old('slug', $plan->slug ?? '') }}" required>
                @error('slug')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="billing_type" class="font-weight-bold">{{ __("messages.billing_type") }}</label>
                <select name="billing_type" id="billing_type"
                        class="form-control @error('billing_type') is-invalid @enderror" required>
                    @foreach($types as $type)
                        <option value="{{ $type->value }}"
                            {{ old('billing_type', $plan->billing_type ?? 1) == $type->value ? 'selected' : '' }}>
                            {{ $type->label() }}
                        </option>
                    @endforeach
                </select>
                @error('billing_type')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>

    {{-- Price and Duration --}}
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="price" class="font-weight-bold">{{ __("messages.price") }}</label>
                <input type="number" step="0.01" name="price" id="price"
                       class="form-control @error('price') is-invalid @enderror"
                       value="{{ old('price', $plan ? $plan->price : '') }}" required>
                @error('price')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="duration" class="font-weight-bold">{{ __("messages.duration") }}</label>
                <input type="number" name="duration" id="duration"
                       class="form-control @error('duration') is-invalid @enderror"
                       value="{{ old('duration', $plan ? $plan->duration : '') }}" required>
                @error('duration')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>

    {{-- Trial Period and Sort Order --}}
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="trial_period" class="font-weight-bold">{{ __("messages.trial_period") }}</label>
                <input type="number" name="trial_period" id="trial_period"
                       class="form-control @error('trial_period') is-invalid @enderror"
                       value="{{ old('trial_period', $plan ? $plan->trial_period : '') }}" required>
                @error('trial_period')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="sort_order" class="font-weight-bold">{{ __("messages.sort_order") }}</label>
                <input type="number" name="sort_order" id="sort_order"
                       class="form-control @error('sort_order') is-invalid @enderror"
                       value="{{ old('sort_order', $plan ? $plan->sort_order : '') }}" required>
                @error('sort_order')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>

    {{-- Features Selection with Select2 --}}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="features" class="font-weight-bold">{{ __("messages.features") }}</label>
                <select multiple name="features[]" id="features"
                        class="form-control select2-features @error('features') is-invalid @enderror">
                    @foreach($features as $feature)
                        @php
                            $isSelected = false;
                            if (old('features')) {
                                $isSelected = in_array($feature->id, old('features', []));
                            } elseif (isset($plan) && $plan->features) {
                                $isSelected = $plan->features->contains('id', $feature->id);
                            }
                        @endphp
                        <option value="{{ $feature->id }}"
                                data-type="{{ $feature->type }}"
                            {{ $isSelected ? 'selected' : '' }}>
                            {{ $feature->name }}
                        </option>
                    @endforeach
                </select>
                @error('features')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>

    {{-- Dynamic Feature Values in Grid --}}
    <div class="row">
        <div class="col-md-12">
            <div id="feature-values-container" style="display: none;">
                <label class="font-weight-bold mb-3">{{ __("messages.feature_values") }}</label>
                <div class="row" id="feature-values">
                    {{-- Dynamic content will be added here --}}
                </div>
            </div>
        </div>
    </div>

    {{-- File Upload and Status --}}
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="image" class="font-weight-bold">{{ __("messages.image") }}</label>
                @if(isset($plan) && $plan->getFirstMediaUrl('images'))
                    <div class="mb-2">
                        <img src="{{ $plan->getFirstMediaUrl('images') }}" alt="Current Image"
                             class="img-thumbnail" width="100">
                    </div>
                @endif
                <div class="custom-file">
                    <input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror"
                           id="image" accept="image/*" {{ !isset($plan) ? 'required' : '' }}>
                    <label class="custom-file-label" for="image">{{ __("messages.choose_file") }}</label>
                    @error('image')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>

        <div class="col-md-6 d-flex align-items-center">
            <p class="mb-0 mr-3">{{ __('messages.is_active') }}</p>
            <div class="custom-control custom-switch">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" class="custom-control-input" id="customSwitch1" name="is_active" value="1"
                    {{ old('is_active', $plan ? $plan->is_active : false) ? 'checked' : '' }}>
                <label class="custom-control-label" for="customSwitch1">{{ __('messages.yes') }}</label>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>
            <a href="{{ route('admin.plans.index') }}" class="btn btn-secondary ml-2">{{ __('messages.cancel') }}</a>
        </div>
    </div>
</form>

{{-- Include Select2 CSS --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" />

{{-- Include Select2 JS --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<style>
    .feature-value-card {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        padding: 15px;
        margin-bottom: 15px;
        background-color: #f8f9fa;
        transition: all 0.3s ease;
    }

    .feature-value-card:hover {
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .feature-title {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .feature-input {
        margin-bottom: 0;
    }

    .select2-container--bootstrap .select2-selection--multiple {
        min-height: 38px;
    }

    .select2-container--bootstrap .select2-selection--multiple .select2-selection__choice {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
        padding: 2px 8px;
        margin: 2px;
    }

    .select2-container--bootstrap .select2-selection--multiple .select2-selection__choice__remove {
        color: white;
        margin-right: 5px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Select2
        $('.select2-features').select2({
            theme: 'bootstrap',
            placeholder: '{{ __("messages.select_features") }}',
            allowClear: true,
            width: '100%',
            language: {
                noResults: function() {
                    return '{{ __("messages.no_results_found") }}';
                },
                searching: function() {
                    return '{{ __("messages.searching") }}...';
                }
            }
        });

        const featuresSelect = document.getElementById('features');
        const featureValuesContainer = document.getElementById('feature-values-container');
        const featureValuesGrid = document.getElementById('feature-values');

        // Available features data with types
        const featuresData = @json($features ?? []);

        // Existing feature values for edit mode
        const existingValues = @json(isset($plan) && $plan->features ?
        $plan->features->mapWithKeys(function($feature) {
            return [$feature->id => $feature->pivot->feature_value ?? ''];
        })->toArray() :
        []
    );

        // Old values from validation errors
        const oldValues = @json(old('feature_values', []));

        // Initialize on page load if there are selected features
        updateFeatureValues();

        // Listen for Select2 changes
        $('.select2-features').on('change', function() {
            updateFeatureValues();
        });

        function updateFeatureValues() {
            const selectedFeatures = Array.from(featuresSelect.selectedOptions).map(option => option.value);
            featureValuesGrid.innerHTML = '';

            if (selectedFeatures.length === 0) {
                featureValuesContainer.style.display = 'none';
                return;
            }

            featureValuesContainer.style.display = 'block';

            selectedFeatures.forEach((featureId, index) => {
                const feature = featuresData.find(f => f.id == featureId);
                if (feature) {
                    const card = createFeatureValueCard(feature, index);
                    featureValuesGrid.appendChild(card);
                }
            });
        }

        function createFeatureValueCard(feature, index) {
            const colDiv = document.createElement('div');
            colDiv.className = 'col-md-4 col-sm-6';

            const cardDiv = document.createElement('div');
            cardDiv.className = 'feature-value-card';
            cardDiv.setAttribute('data-feature-id', feature.id);

            const title = document.createElement('div');
            title.className = 'feature-title';
            title.textContent = feature.name;

            const inputGroup = document.createElement('div');
            inputGroup.className = 'feature-input';

            const existingValue = oldValues[feature.id] || existingValues[feature.id] || '';

            let inputHTML = `<input type="hidden" name="features[${index}][feature_id]" value="${feature.id}">`;

            switch (parseInt(feature.type)) {
                case 1:
                    inputHTML += `
                <input type="number"
                       name="features[${index}][value]"
                       class="form-control form-control-sm"
                       placeholder="{{ __('messages.enter_limit') }}"
                       value="${existingValue}"
                       min="0">`;
                    break;
                case 2:
                    const isChecked = existingValue == '1' || existingValue === true;
                    inputHTML += `
                <div class="custom-control custom-switch">
                    <input type="hidden" name="features[${index}][value]" value="0">
                    <input type="checkbox"
                           class="custom-control-input"
                           id="feature_${feature.id}"
                           name="features[${index}][value]"
                           value="1"
                           ${isChecked ? 'checked' : ''}>
                    <label class="custom-control-label" for="feature_${feature.id}">
                        {{ __('messages.enabled') }}
                    </label>
                </div>`;
                    break;
                case 3:
                    inputHTML += `
                <input type="text"
                       name="features[${index}][value]"
                       class="form-control form-control-sm"
                       placeholder="{{ __('messages.enter_text') }}"
                       value="${existingValue}">`;
                    break;
                default:
                    inputHTML += `
                <input type="text"
                       name="features[${index}][value]"
                       class="form-control form-control-sm"
                       placeholder="{{ __('messages.enter_value') }}"
                       value="${existingValue}">`;
            }

            inputGroup.innerHTML = inputHTML;
            cardDiv.appendChild(title);
            cardDiv.appendChild(inputGroup);
            colDiv.appendChild(cardDiv);

            return colDiv;
        }

        // Update file input label
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || '{{ __("keys.choose_file") }}';
            e.target.nextElementSibling.innerText = fileName;
        });
    });
</script>
