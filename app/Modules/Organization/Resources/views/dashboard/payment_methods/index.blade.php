@extends('organization::dashboard.master')
@section('title', __('organizations.payment_methods'))

@section('content')
    <div class="container py-4">
        <h2 class="mb-4 text-center text-primary fw-bold">{{ __('organizations.payment_methods') }}</h2>

        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header bg-light border-bottom-0 py-3">
                <!-- Smart Tabs System with Active Methods Counter -->
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Visible Tabs (Max 7) -->
                    <ul class="nav nav-pills" id="paymentMethodTabs" role="tablist">
                        @php
                            $visibleMethods = $paymentMethods->take(7);
                            $hiddenMethods = $paymentMethods->slice(7);

                            // Count active methods
                            $activeMethodsCount = 0;
                            foreach($paymentMethods as $method) {
                                $pivotData = $orgPaymentMethods[$method->id] ?? null;
                                if(($pivotData['is_active'] ?? false)) {
                                    $activeMethodsCount++;
                                }
                            }
                        @endphp

                        @foreach($visibleMethods as $index => $method)
                            @php
                                $isActiveTab = ($activeMethodId === $method->id) || ($activeMethodId === null && $index === 0);
                            @endphp
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $isActiveTab ? 'active' : '' }} mx-1"
                                        id="tab-{{ $method->id }}"
                                        data-bs-toggle="pill"
                                        data-bs-target="#content-{{ $method->id }}"
                                        type="button"
                                        role="tab"
                                        aria-controls="content-{{ $method->id }}"
                                        aria-selected="{{ $isActiveTab ? 'true' : 'false' }}">
                                    <span class="fw-bold">{{ $method->name }}</span>
                                </button>
                            </li>
                        @endforeach

                        <!-- More Dropdown for hidden tabs -->
                        @if($hiddenMethods->count() > 0)
                            <li class="nav-item dropdown" role="presentation">
                                <button class="nav-link dropdown-toggle"
                                        id="moreTabsDropdown"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                    More...
                                </button>
                                <ul class="dropdown-menu">
                                    @foreach($hiddenMethods as $method)
                                        <li>
                                            <button class="dropdown-item"
                                                    data-bs-toggle="pill"
                                                    data-bs-target="#content-{{ $method->id }}"
                                                    type="button"
                                                    role="tab">
                                                {{ $method->name }}
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    </ul>

                    <!-- Stats indicator -->
                    <div class="d-flex gap-3">
                        <small class="text-muted">
                            <i class="fas fa-toggle-on text-success me-1"></i>
                            <span class="fw-bold text-success">{{ $activeMethodsCount }}</span> active
                        </small>
                        <small class="text-muted">
                            <i class="fas fa-credit-card me-1"></i>
                            {{ $paymentMethods->count() }} total
                        </small>
                    </div>
                </div>

                <!-- Active Methods Summary (Optional) -->
                @if($activeMethodsCount > 0)
                    <div class="mt-2">
                        <small class="text-success">
                            <i class="fas fa-check-circle me-1"></i>
                            Active methods:
                            @php
                                $activeMethodNames = [];
                                foreach($paymentMethods as $method) {
                                    $pivotData = $orgPaymentMethods[$method->id] ?? null;
                                    if(($pivotData['is_active'] ?? false)) {
                                        $activeMethodNames[] = $method->name;
                                    }
                                }
                                echo implode(', ', array_slice($activeMethodNames, 0, 3));
                                if(count($activeMethodNames) > 3) {
                                    echo ' and ' . (count($activeMethodNames) - 3) . ' more';
                                }
                            @endphp
                        </small>
                    </div>
                @endif
            </div>

            <div class="card-body p-4">
                <div class="tab-content" id="paymentMethodTabContent">
                    @foreach($paymentMethods as $index => $method)
                        @php
                            $pivotData = $orgPaymentMethods[$method->id] ?? null;
                            $isActive = $pivotData['is_active'] ?? false;
                            $credentials = $pivotData['credentials'] ?? [];
                            $requiredSettings = is_array($method->required_settings) ? $method->required_settings : (json_decode($method->required_settings, true) ?? []);

                            $isActiveTab = ($activeMethodId === $method->id) || ($activeMethodId === null && $index === 0);
                        @endphp

                        <div class="tab-pane {{ $isActiveTab ? 'show active' : '' }}"
                             id="content-{{ $method->id }}"
                             role="tabpanel"
                             aria-labelledby="tab-{{ $method->id }}">

                            <div class="d-flex justify-content-between align-items-center mb-4 p-3 border rounded-3 {{ $isActive ? 'bg-success bg-opacity-10 border-success' : 'bg-light' }}">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-credit-card fa-lg me-3 {{ $isActive ? 'text-success' : 'text-muted' }}"></i>
                                    <span class="fw-bold">{{ $method->name }}</span>
                                    @if($isActive)
                                        <span class="badge bg-success ms-2">ACTIVE</span>
                                    @endif
                                </div>
                                <div class="form-check form-switch ms-auto">
                                    <input class="form-check-input toggle-switch"
                                           type="checkbox"
                                           role="switch"
                                           id="switch-{{ $method->id }}"
                                           data-method-id="{{ $method->id }}"
                                           data-update-url="{{ route('organization.payment_methods.update', $method->id) }}"
                                        {{ $isActive ? 'checked' : '' }}>
                                    <label class="form-check-label text-{{ $isActive ? 'success' : 'danger' }} fw-bold status-label"
                                           for="switch-{{ $method->id }}">
                                        {{ $isActive ? 'Active' : 'Inactive' }}
                                    </label>
                                </div>
                            </div>

                            @if (empty($requiredSettings))
                                <div class="alert alert-info" role="alert">
                                    <i class="fas fa-info-circle me-2"></i>
                                    This payment method does not require any additional credentials.
                                </div>
                            @else
                                <div class="credentials-form" id="credentials-{{ $method->id }}" style="{{ $isActive ? '' : 'display:none;' }}">
                                    <form class="update-credentials-form"
                                          id="form-{{ $method->id }}"
                                          data-method-id="{{ $method->id }}"
                                          data-update-url="{{ route('organization.payment_methods.update', $method->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="is_active" value="{{ $isActive ? '1' : '0' }}">
                                        <div class="row g-3">
                                            @foreach($requiredSettings as $field)
                                                @php $value = $credentials[$field] ?? ''; @endphp
                                                <div class="col-md-6">
                                                    <label for="field-{{ $field }}-{{ $method->id }}" class="form-label">
                                                        <i class="fas fa-key me-1"></i>
                                                        {{ ucfirst(str_replace('_', ' ', $field)) }}
                                                    </label>
                                                    <input type="text"
                                                           id="field-{{ $field }}-{{ $method->id }}"
                                                           name="credentials[{{ $field }}]"
                                                           class="form-control"
                                                           value="{{ old('credentials.'.$field, $value) }}">
                                                    <div class="invalid-feedback" id="error-{{ $field }}-{{ $method->id }}"></div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="text-end mt-4">
                                            <button type="submit" class="btn btn-{{ $isActive ? 'success' : 'primary' }} save-credentials-btn">
                                                <span class="spinner-border spinner-border-sm d-none me-2" role="status"></span>
                                                <i class="fas fa-save me-1"></i>
                                                {{ $isActive ? __('Update Credentials') : __('Save Credentials') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after_script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Check if CSRF token exists
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            if (!csrfMeta) {
                console.error('CSRF token meta tag not found');
                return;
            }

            function fetchWithHeaders(url, options = {}) {
                const defaultHeaders = {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfMeta.content
                };
                options.headers = { ...defaultHeaders, ...(options.headers || {}) };
                return fetch(url, options);
            }

            function handleValidationErrors(errors, methodId) {
                for (const key in errors) {
                    if (errors.hasOwnProperty(key)) {
                        const fieldParts = key.split('.');
                        const fieldName = fieldParts.length > 1 ? fieldParts.slice(1).join('.') : fieldParts[0];
                        const errorMsg = errors[key][0];

                        const errorEl = document.getElementById(`error-${fieldName}-${methodId}`);
                        const inputEl = document.getElementById(`field-${fieldName}-${methodId}`);

                        if (errorEl) {
                            errorEl.textContent = errorMsg;
                            errorEl.style.display = 'block';
                        }
                        if (inputEl) {
                            inputEl.classList.add('is-invalid');
                        }
                    }
                }
            }

            // Initialize Toastr if available
            function showToast(message, type = 'success') {
                if (typeof toastr !== 'undefined') {
                    toastr[type](message);
                } else {
                    // Simple fallback
                    const alertType = type === 'error' ? 'danger' : type;
                    alert(message);
                }
            }

            // Update active methods counter
            function updateActiveMethodsCounter() {
                try {
                    const activeSwitches = document.querySelectorAll('.toggle-switch:checked');
                    const activeCount = activeSwitches.length;

                    // Update counter in header
                    const counterElement = document.querySelector('.text-success.fw-bold');
                    if (counterElement) {
                        counterElement.textContent = activeCount;
                    }

                    // Update summary text
                    const summaryElement = document.querySelector('small.text-success');
                    if (summaryElement && activeCount > 0) {
                        // This would require more complex logic to rebuild the list
                        // For now, we'll just refresh the page to show updated summary
                    }
                } catch (error) {
                    console.error('Error updating active methods counter:', error);
                }
            }

            // Toggle switch handler
            document.querySelectorAll('.toggle-switch').forEach(switchEl => {
                if (!switchEl.dataset.methodId || !switchEl.dataset.updateUrl) {
                    console.warn('Toggle switch missing required data attributes');
                    return;
                }

                switchEl.addEventListener('change', function () {
                    const methodId = this.dataset.methodId;
                    const credentialsDiv = document.getElementById(`credentials-${methodId}`);
                    const updateUrl = this.dataset.updateUrl;
                    const isChecked = this.checked;
                    const label = document.querySelector(`label[for="switch-${methodId}"]`);
                    const tabContent = document.querySelector(`#content-${methodId}`);
                    const badge = tabContent?.querySelector('.badge');

                    const formData = new FormData();
                    formData.append('_method', 'PUT');

                    if (credentialsDiv) {
                        if (isChecked) {
                            credentialsDiv.style.display = 'block';
                            if (label) {
                                label.textContent = 'Active';
                                label.classList.remove('text-danger');
                                label.classList.add('text-success');
                            }
                            if (tabContent) {
                                tabContent.querySelector('.d-flex').classList.remove('bg-light');
                                tabContent.querySelector('.d-flex').classList.add('bg-success', 'bg-opacity-10', 'border-success');
                                tabContent.querySelector('.fa-credit-card').classList.remove('text-muted');
                                tabContent.querySelector('.fa-credit-card').classList.add('text-success');

                                // Add badge if not exists
                                if (!badge) {
                                    const badgeHtml = '<span class="badge bg-success ms-2">ACTIVE</span>';
                                    const container = tabContent.querySelector('.d-flex.align-items-center');
                                    if (container) {
                                        container.insertAdjacentHTML('beforeend', badgeHtml);
                                    }
                                }
                            }
                        } else {
                            credentialsDiv.style.display = 'none';
                            if (label) {
                                label.textContent = 'Inactive';
                                label.classList.remove('text-success');
                                label.classList.add('text-danger');
                            }
                            if (tabContent) {
                                tabContent.querySelector('.d-flex').classList.remove('bg-success', 'bg-opacity-10', 'border-success');
                                tabContent.querySelector('.d-flex').classList.add('bg-light');
                                tabContent.querySelector('.fa-credit-card').classList.remove('text-success');
                                tabContent.querySelector('.fa-credit-card').classList.add('text-muted');

                                // Remove badge
                                if (badge) {
                                    badge.remove();
                                }
                            }

                            formData.append('is_active', '0');
                            sendToggleRequest(updateUrl, formData, switchEl, credentialsDiv, label, methodId);
                        }
                    } else {
                        if (label) {
                            label.textContent = isChecked ? 'Active' : 'Inactive';
                            label.classList.remove(isChecked ? 'text-danger' : 'text-success');
                            label.classList.add(isChecked ? 'text-success' : 'text-danger');
                        }
                        if (tabContent) {
                            if (isChecked) {
                                tabContent.querySelector('.d-flex').classList.remove('bg-light');
                                tabContent.querySelector('.d-flex').classList.add('bg-success', 'bg-opacity-10', 'border-success');
                                tabContent.querySelector('.fa-credit-card').classList.remove('text-muted');
                                tabContent.querySelector('.fa-credit-card').classList.add('text-success');

                                // Add badge if not exists
                                if (!badge) {
                                    const badgeHtml = '<span class="badge bg-success ms-2">ACTIVE</span>';
                                    const container = tabContent.querySelector('.d-flex.align-items-center');
                                    if (container) {
                                        container.insertAdjacentHTML('beforeend', badgeHtml);
                                    }
                                }
                            } else {
                                tabContent.querySelector('.d-flex').classList.remove('bg-success', 'bg-opacity-10', 'border-success');
                                tabContent.querySelector('.d-flex').classList.add('bg-light');
                                tabContent.querySelector('.fa-credit-card').classList.remove('text-success');
                                tabContent.querySelector('.fa-credit-card').classList.add('text-muted');

                                // Remove badge
                                if (badge) {
                                    badge.remove();
                                }
                            }
                        }

                        formData.append('is_active', isChecked ? '1' : '0');
                        sendToggleRequest(updateUrl, formData, switchEl, credentialsDiv, label, methodId);
                    }
                });
            });

            function sendToggleRequest(url, formData, switchEl, credentialsDiv, label, methodId) {
                fetchWithHeaders(url, {
                    method: 'POST',
                    body: formData
                })
                    .then(res => {
                        if (!res.ok) throw res;
                        return res.json();
                    })
                    .then(json => {
                        if (json.status !== 'success') {
                            showToast('Failed to update status.', 'error');
                            if (switchEl) switchEl.checked = !switchEl.checked;
                            if (credentialsDiv) credentialsDiv.style.display = switchEl?.checked ? 'block' : 'none';
                            updateLabel(label, switchEl?.checked);
                            updateActiveMethodsCounter();
                        } else {
                            showToast(json.message || 'Status updated successfully.', 'success');
                            updateActiveMethodsCounter();
                        }
                    })
                    .catch(err => {
                        console.error('Toggle request error:', err);
                        showToast('An error occurred while updating the payment method.', 'error');

                        if (switchEl) switchEl.checked = !switchEl.checked;
                        if (credentialsDiv) credentialsDiv.style.display = switchEl?.checked ? 'block' : 'none';
                        updateLabel(label, switchEl?.checked);
                        updateActiveMethodsCounter();
                    });
            }

            function updateLabel(label, isActive) {
                if (label) {
                    label.textContent = isActive ? 'Active' : 'Inactive';
                    label.classList.remove(isActive ? 'text-danger' : 'text-success');
                    label.classList.add(isActive ? 'text-success' : 'text-danger');
                }
            }

            // Form submission handler
            document.querySelectorAll('.update-credentials-form').forEach(form => {
                if (!form.dataset.methodId || !form.dataset.updateUrl) {
                    console.warn('Form missing required data attributes');
                    return;
                }

                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const methodId = this.dataset.methodId;
                    const updateUrl = this.dataset.updateUrl;
                    const btn = this.querySelector('.save-credentials-btn');
                    const spinner = btn?.querySelector('.spinner-border');
                    const icon = btn?.querySelector('.fas');

                    const isActiveInput = this.querySelector('input[name="is_active"]');
                    if (isActiveInput) isActiveInput.value = '1';

                    // Clear validation errors
                    document.querySelectorAll(`#content-${methodId} .invalid-feedback`).forEach(el => {
                        el.style.display = 'none';
                        el.textContent = '';
                    });
                    document.querySelectorAll(`#content-${methodId} .form-control`).forEach(el => el.classList.remove('is-invalid'));

                    // Show loading
                    if (btn) btn.disabled = true;
                    if (spinner) spinner.classList.remove('d-none');
                    if (icon) icon.classList.add('d-none');

                    const formData = new FormData(this);
                    formData.append('_method', 'PUT');

                    fetchWithHeaders(updateUrl, {
                        method: 'POST',
                        body: formData
                    })
                        .then(async res => {
                            if (!res.ok) {
                                const errJson = await res.json();
                                throw { status: res.status, body: errJson };
                            }
                            return res.json();
                        })
                        .then(json => {
                            // Hide loading
                            if (btn) btn.disabled = false;
                            if (spinner) spinner.classList.add('d-none');
                            if (icon) icon.classList.remove('d-none');

                            if (json.status === 'success') {
                                showToast('Credentials saved and payment method enabled.', 'success');
                                const toggle = document.getElementById(`switch-${methodId}`);
                                if (toggle) {
                                    toggle.checked = true;
                                    const label = document.querySelector(`label[for="switch-${methodId}"]`);
                                    updateLabel(label, true);

                                    // Update UI elements
                                    const tabContent = document.querySelector(`#content-${methodId}`);
                                    if (tabContent) {
                                        tabContent.querySelector('.d-flex').classList.remove('bg-light');
                                        tabContent.querySelector('.d-flex').classList.add('bg-success', 'bg-opacity-10', 'border-success');
                                        tabContent.querySelector('.fa-credit-card').classList.remove('text-muted');
                                        tabContent.querySelector('.fa-credit-card').classList.add('text-success');

                                        // Add badge if not exists
                                        const badge = tabContent.querySelector('.badge');
                                        if (!badge) {
                                            const badgeHtml = '<span class="badge bg-success ms-2">ACTIVE</span>';
                                            const container = tabContent.querySelector('.d-flex.align-items-center');
                                            if (container) {
                                                container.insertAdjacentHTML('beforeend', badgeHtml);
                                            }
                                        }
                                    }
                                }
                                updateActiveMethodsCounter();
                            } else {
                                showToast('Failed to save credentials.', 'error');
                            }
                        })
                        .catch(err => {
                            // Hide loading
                            if (btn) btn.disabled = false;
                            if (spinner) spinner.classList.add('d-none');
                            if (icon) icon.classList.remove('d-none');

                            if (err && err.status === 422 && err.body && err.body.errors) {
                                handleValidationErrors(err.body.errors, methodId);
                                showToast('Please fix the validation errors.', 'error');
                            } else {
                                console.error('Form submission error:', err);
                                showToast('An error occurred while saving credentials.', 'error');
                            }
                        });
                });
            });

            // Handle dropdown items
            document.querySelectorAll('.dropdown-item').forEach(item => {
                item.addEventListener('click', function () {
                    // Get target tab content
                    const target = this.dataset.bsTarget;
                    if (!target) return;

                    // Activate the tab content
                    const tabContent = document.querySelector(target);
                    if (tabContent) {
                        // Hide all tab contents
                        document.querySelectorAll('.tab-pane').forEach(pane => {
                            pane.classList.remove('show', 'active');
                        });

                        // Show target tab content
                        tabContent.classList.add('show', 'active');
                    }
                });
            });
        });
    </script>
@endsection
