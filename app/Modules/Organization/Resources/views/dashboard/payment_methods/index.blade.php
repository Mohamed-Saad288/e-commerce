@extends('organization::dashboard.master')
@section('title', __('organizations.payment_methods'))

@section('content')
    <div class="container">
        <h2>Manage Payment Methods</h2>

        @foreach($paymentMethods as $method)
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ $method->translateOrDefault(app()->getLocale())->name }}</span>
                    <form action="{{ route('organization.payment_methods.update', $method->id) }}" method="POST" class="payment-method-form">
                        @csrf
                        @method('PUT')
                        <div class="form-check form-switch">
                            <input class="form-check-input toggle-switch" type="checkbox"
                                   name="is_active"
                                   data-method-id="{{ $method->id }}"
                                {{ (isset($orgPaymentMethods[$method->id]) && json_decode($orgPaymentMethods[$method->id], true) !== null) ? 'checked' : '' }}>
                        </div>
                    </form>
                </div>
                <div class="card-body" id="credentials-{{ $method->id }}" style="display: none;">
                    <form action="{{ route('organization.payment_methods.update', $method->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        @php
                            $requiredSettings = json_decode($method->required_settings, true) ?? [];
                            $credentials = isset($orgPaymentMethods[$method->id]) ? json_decode($orgPaymentMethods[$method->id], true) : [];
                        @endphp

                        @foreach($requiredSettings as $fieldKey => $fieldValue)
                            <div class="mb-3">
                                <label for="{{ $fieldKey }}" class="form-label">
                                    {{ ucfirst(str_replace('_', ' ', $fieldKey)) }}
                                </label>
                                <input type="text" name="credentials[{{ $fieldKey }}]" class="form-control"
                                       value="{{ is_array($credentials[$fieldKey] ?? '') ? '' : ($credentials[$fieldKey] ?? '') }}"
                                    {{ is_array($credentials[$fieldKey] ?? '') ? '' : 'required' }}>
                            </div>
                        @endforeach

                        <button type="submit" class="btn btn-primary">Save Credentials</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('after_script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize toggle states
            document.querySelectorAll('.toggle-switch').forEach(switchEl => {
                const methodId = switchEl.dataset.methodId;
                const credentialDiv = document.getElementById(`credentials-${methodId}`);

                if (credentialDiv && switchEl.checked) {
                    credentialDiv.style.display = 'block';
                }

                // Handle toggle change with confirmation
                switchEl.addEventListener('change', function () {
                    const methodId = this.dataset.methodId;
                    const credentialDiv = document.getElementById(`credentials-${methodId}`);
                    const isChecked = this.checked;

                    if (credentialDiv) {
                        credentialDiv.style.display = isChecked ? 'block' : 'none';
                    }

                    // Submit via AJAX to prevent page reload for enable/disable
                    const formData = new FormData();
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                    formData.append('_method', 'PUT');
                    formData.append('is_active', isChecked ? '1' : '0');

                    fetch(`/organization/payment-methods/${methodId}`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            this.checked = !isChecked;
                            if (credentialDiv) {
                                credentialDiv.style.display = !isChecked ? 'block' : 'none';
                            }
                        });
                });
            });
        });
    </script>
@endsection
