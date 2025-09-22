@extends('organization::dashboard.master')
@section('title', __('organizations.payment_methods'))

@section('content')
    <div class="container">
        <h2 class="mb-4">{{ __('organizations.payment_methods') }}</h2>

        @foreach($paymentMethods as $method)
            @php
                $pivotData = $orgPaymentMethods[$method->id] ?? null;
                $isActive = $pivotData['is_active'] ?? false;
                $credentials = $pivotData['credentials'] ?? [];
                $requiredSettings = is_array($method->required_settings) ? $method->required_settings : (json_decode($method->required_settings, true) ?? []);
            @endphp

            <div class="card shadow-sm mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="fw-bold">{{ $method->name }}</span>

                    <div class="form-check form-switch">
                        <input class="form-check-input toggle-switch"
                               type="checkbox"
                               data-method-id="{{ $method->id }}"
                               data-update-url="{{ route('organization.payment_methods.update', $method->id) }}"
                            {{ $isActive ? 'checked' : '' }}>
                    </div>
                </div>

                <div class="card-body credentials-form" id="credentials-{{ $method->id }}" style="{{ $isActive ? '' : 'display:none;' }}">
                    <form class="update-credentials-form" data-method-id="{{ $method->id }}" data-update-url="{{ route('organization.payment_methods.update', $method->id) }}">
                        @csrf
                        @method('PUT')

                        {{-- We'll set is_active only on Save --}}
                        <input type="hidden" name="is_active" value="{{ $isActive ? '1' : '0' }}">

                        <div class="row">
                            @foreach($requiredSettings as $field)
                                @php $value = $credentials[$field] ?? ''; @endphp
                                <div class="col-md-6 mb-3">
                                    <label for="{{ $field }}" class="form-label">
                                        {{ ucfirst(str_replace('_', ' ', $field)) }}
                                    </label>
                                    <input type="text"
                                           id="field-{{ $field }}-{{ $method->id }}"
                                           name="credentials[{{ $field }}]"
                                           class="form-control"
                                           value="{{ old('credentials.'.$field, $value) }}">
                                    <div class="invalid-feedback d-none" id="error-{{ $field }}-{{ $method->id }}"></div>
                                </div>
                            @endforeach
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary save-credentials-btn">
                                <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                {{ __('Save Credentials') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('after_script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ensure CSRF meta exists in layout:
            // <meta name="csrf-token" content="{{ csrf_token() }}">

            function fetchWithHeaders(url, options = {}) {
                const defaultHeaders = {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                };
                options.headers = { ...defaultHeaders, ...(options.headers || {}) };
                return fetch(url, options);
            }

            // Toggle behavior:
            document.querySelectorAll('.toggle-switch').forEach(switchEl => {
                switchEl.addEventListener('change', function () {
                    const methodId = this.dataset.methodId;
                    const credentialsDiv = document.getElementById(`credentials-${methodId}`);
                    const updateUrl = this.dataset.updateUrl;
                    const isChecked = this.checked;

                    if (isChecked) {
                        // CHECKED: only show form, DO NOT persist yet
                        credentialsDiv.style.display = 'block';
                        // ensure hidden input default becomes 1 only after Save (we'll set when saving)
                        // keep UI checked to show user intention
                    } else {
                        // UNCHECKED: immediately persist disable
                        credentialsDiv.style.display = 'none';

                        const formData = new FormData();
                        formData.append('_method', 'PUT');
                        formData.append('is_active', '0');

                        fetchWithHeaders(updateUrl, {
                            method: 'POST',
                            body: formData
                        })
                            .then(res => {
                                if (!res.ok) throw res;
                                return res.json();
                            })
                            .then(json => {
                                if (json.status !== 'success') {
                                    alert('Failed to update status.');
                                    // revert checkbox if needed
                                    switchEl.checked = true;
                                    credentialsDiv.style.display = 'block';
                                } else {
                                    // success: ensure the hidden input inside form updated to 0
                                    const form = document.querySelector(`.update-credentials-form[data-method-id="${methodId}"]`);
                                    if (form) form.querySelector('input[name="is_active"]').value = '0';
                                }
                            })
                            .catch(err => {
                                console.error(err);
                                alert('Network error while disabling payment method.');
                                // revert UI
                                switchEl.checked = true;
                                credentialsDiv.style.display = 'block';
                            });
                    }
                });
            });

            // Save credentials handler (this will also enable)
            document.querySelectorAll('.update-credentials-form').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const methodId = this.dataset.methodId;
                    const updateUrl = this.dataset.updateUrl;
                    const btn = this.querySelector('.save-credentials-btn');
                    const spinner = btn.querySelector('.spinner-border');

                    // set is_active = 1 before submit to indicate enable intent
                    const isActiveInput = this.querySelector('input[name="is_active"]');
                    if (isActiveInput) isActiveInput.value = '1';

                    // clear previous errors
                    this.querySelectorAll('.invalid-feedback').forEach(el => {
                        el.classList.add('d-none');
                        el.textContent = '';
                    });
                    this.querySelectorAll('.form-control').forEach(el => el.classList.remove('is-invalid'));

                    btn.disabled = true;
                    spinner.classList.remove('d-none');

                    const formData = new FormData(this);
                    formData.append('_method', 'PUT');

                    fetchWithHeaders(updateUrl, {
                        method: 'POST',
                        body: formData
                    })
                        .then(async res => {
                            const contentType = res.headers.get('content-type') || '';
                            if (!res.ok) {
                                // try parse json errors
                                if (contentType.includes('application/json')) {
                                    const errJson = await res.json();
                                    throw { status: res.status, body: errJson };
                                }
                                throw { status: res.status };
                            }
                            return res.json();
                        })
                        .then(json => {
                            btn.disabled = false;
                            spinner.classList.add('d-none');

                            if (json.status === 'success') {
                                alert('✅ Credentials saved and payment method enabled.');
                                // ensure checkbox is checked (persisted)
                                const toggle = document.querySelector(`.toggle-switch[data-method-id="${methodId}"]`);
                                if (toggle) toggle.checked = true;
                            } else {
                                alert('❌ Failed to save credentials.');
                            }
                        })
                        .catch(err => {
                            btn.disabled = false;
                            spinner.classList.add('d-none');

                            if (err && err.status === 422 && err.body) {
                                // show validation errors (assumes structure { errors: { 'credentials.api_key': ['...'] } })
                                const errors = err.body.errors || {};
                                for (const key in errors) {
                                    // key like 'credentials.api_key'
                                    const fieldParts = key.split('.');
                                    const fieldName = fieldParts.slice(1).join('.'); // api_key
                                    const errorMsg = errors[key][0];

                                    const errorEl = document.getElementById(`error-${fieldName}-${methodId}`);
                                    const inputEl = document.getElementById(`field-${fieldName}-${methodId}`);
                                    if (errorEl) {
                                        errorEl.textContent = errorMsg;
                                        errorEl.classList.remove('d-none');
                                    }
                                    if (inputEl) inputEl.classList.add('is-invalid');
                                }
                            } else {
                                console.error(err);
                                alert('Network or server error while saving credentials.');
                            }
                        });
                });
            });
        });
    </script>
@endsection
