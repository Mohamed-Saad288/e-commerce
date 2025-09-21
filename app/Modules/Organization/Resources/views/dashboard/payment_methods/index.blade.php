@extends('organization::dashboard.master')
@section('title', __('keys.payment_methods'))
@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Payment Methods</h1>
            <p class="text-gray-600">Enable or disable payment methods for your store.</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($paymentMethods as $pm)
                <div class="bg-white rounded-lg shadow-sm border p-5 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center space-x-3">
                            @if($pm->icon)
                                <img src="{{ asset($pm->icon) }}" alt="{{ $pm->name }}" class="w-12 h-12 object-contain">
                            @else
                                <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                    <span class="text-gray-500 uppercase text-sm font-bold">{{ substr($pm->code, 0, 2) }}</span>
                                </div>
                            @endif
                            <div>
                                <h4 class="font-medium text-gray-800">{{ $pm->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $pm->description }}</p>
                            </div>
                        </div>

                        <div class="flex flex-col items-end space-y-2">
                            <!-- Toggle Form -->
                            <form action="{{ route('vendor.payment-methods.toggle') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="payment_method_id" value="{{ $pm->id }}">

                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_active" class="sr-only peer"
                                           onchange="this.form.submit()"
                                        {{ $pm->pivot->is_active ? 'checked' : '' }}
                                    >
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </form>

                            <!-- Configure Button -->
                            @if(count(json_decode($pm->required_settings, true)) > 0)
                                <a href="{{ route('vendor.payment-methods.configure', $pm) }}"
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Configure
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        {{ $pm->pivot->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $pm->pivot->is_active ? 'Active' : 'Inactive' }}
                    </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

