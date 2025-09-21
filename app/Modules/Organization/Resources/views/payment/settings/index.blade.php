@extends('organization::layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('Payment Methods Settings') }}</h4>
                </div>
                <div class="card-body">
                    <div class="payment-methods-list" id="sortable-payment-methods">
                        @foreach($paymentMethods as $method)
                            @php
                                $organizationMethod = $organizationPaymentMethods->firstWhere('payment_method_id', $method->id);
                            @endphp
                            <div class="card mb-3 payment-method-item" data-id="{{ $organizationMethod?->id }}">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="handle cursor-move">
                                                <i class="fas fa-grip-vertical"></i>
                                            </span>
                                        </div>
                                        <div class="col-auto">
                                            @if($method->icon)
                                                <img src="{{ $method->icon }}" alt="{{ $method->name }}" class="payment-icon">
                                            @else
                                                <i class="fas fa-credit-card fa-2x"></i>
                                            @endif
                                        </div>
                                        <div class="col">
                                            <h5 class="mb-0">{{ $method->name }}</h5>
                                            <p class="text-muted mb-0">{{ $method->description }}</p>
                                        </div>
                                        <div class="col-auto">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input toggle-status" type="checkbox"
                                                       id="status_{{ $method->id }}"
                                                       {{ $organizationMethod?->is_active ? 'checked' : '' }}
                                                       data-method-id="{{ $organizationMethod?->id }}">
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-primary btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#settingsModal_{{ $method->id }}">
                                                {{ __('Configure') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Settings Modal -->
                            <div class="modal fade" id="settingsModal_{{ $method->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('organization.payment.settings.update', $method->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title">{{ __('Configure') }} {{ $method->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                @dd($method)
                                                @foreach(json_decode($method->required_settings) as $key => $setting)
                                                    <div class="mb-3">
                                                        <label class="form-label">{{ $setting['label'] }}</label>
                                                        <input type="{{ $setting['type'] }}"
                                                               name="settings[{{ $key }}]"
                                                               class="form-control"
                                                               value="{{ $organizationMethod?->settings[$key] ?? '' }}"
                                                               {{ $setting['required'] ? 'required' : '' }}>
                                                    </div>
                                                @endforeach

                                                <div class="form-check form-switch mb-3">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="is_active"
                                                           value="1"
                                                           {{ $organizationMethod?->is_active ? 'checked' : '' }}>
                                                    <label class="form-check-label">
                                                        {{ __('Enable this payment method') }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    {{ __('Close') }}
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    {{ __('Save Changes') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .payment-icon {
        width: 40px;
        height: 40px;
        object-fit: contain;
    }
    .cursor-move {
        cursor: move;
    }
    .handle {
        color: #999;
        padding: 10px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize sortable
    const sortable = new Sortable(document.getElementById('sortable-payment-methods'), {
        handle: '.handle',
        animation: 150,
        onEnd: function() {
            updateOrder();
        }
    });

    // Toast notification
    function showToast(message, isSuccess = true) {
        let toast = document.createElement('div');
        toast.className = 'toast align-items-center text-white ' + (isSuccess ? 'bg-success' : 'bg-danger') + ' border-0 position-fixed top-0 end-0 m-3';
        toast.style.zIndex = 9999;
        toast.innerHTML = `<div class="d-flex"><div class="toast-body">${message}</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>`;
        document.body.appendChild(toast);
        let bsToast = new bootstrap.Toast(toast, { delay: 2500 });
        bsToast.show();
        toast.addEventListener('hidden.bs.toast', function() { toast.remove(); });
    }

    // Update order function
    function updateOrder() {
        const items = document.querySelectorAll('.payment-method-item');
        const orders = Array.from(items).map((item, index) => ({
            id: item.dataset.id,
            order: index
        }));

        fetch('{{ route("organization.payment.settings.update-order") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ orders })
        });
    }

    // Toggle status
    document.querySelectorAll('.toggle-status').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const methodId = this.dataset.methodId;
            const self = this;
            self.disabled = true;
            fetch(`{{ route("organization.payment.settings.toggle-status", "") }}/${methodId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, true);
                } else {
                    self.checked = !self.checked;
                    showToast('Failed to update status', false);
                }
            })
            .catch(() => {
                self.checked = !self.checked;
                showToast('Network error', false);
            })
            .finally(() => {
                self.disabled = false;
            });
        });
    });
});
</script>
@endpush
