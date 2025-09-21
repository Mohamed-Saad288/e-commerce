@extends('organization::dashboard.master')
@section('title', __('keys.payment_methods'))
@section("styles")
    <style>
        .toggle {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }
    </style>
@endsection
@section('content')
    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <div class="mb-6">
            <a href="{{ route('vendor.payment-methods') }}" class="text-blue-600 hover:underline">&larr; Back to Payment Methods</a>
            <h1 class="text-2xl font-bold text-gray-800 mt-2">Configure {{ $paymentMethod->name }}</h1>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('vendor.payment-methods.save-credentials') }}" method="POST">
                @csrf
                <input type="hidden" name="payment_method_id" value="{{ $paymentMethod->id }}">

                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-2">Required Settings</h3>
                    <p class="text-gray-600 text-sm">Fill in the credentials required to activate this payment method.</p>
                </div>

                @php
                    $settings = json_decode($paymentMethod->required_settings, true) ?? [];
                @endphp

                @if(count($settings) > 0)
                    @foreach($settings as $key => $label)
                        <div class="mb-4">
                            <label for="{{ $key }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
                            <input
                                type="text"
                                id="{{ $key }}"
                                name="credentials[{{ $key }}]"
                                value="{{ old('credentials.'.$key, $credentials[$key] ?? '') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                placeholder="{{ $label }}"
                            >
                            @error('credentials.'.$key)
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500">No configuration required for this payment method.</p>
                @endif

                <div class="flex justify-end space-x-3 mt-6">
                    <a href="{{ route('vendor.payment-methods') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Save Credentials
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
