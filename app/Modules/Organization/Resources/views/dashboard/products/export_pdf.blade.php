<!DOCTYPE html>
<html>
<head>
    <title>{{ __('organizations.products') }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .badge { padding: 3px 6px; border-radius: 3px; font-size: 12px; }
        .badge-success { background-color: #28a745; color: white; }
        .badge-warning { background-color: #ffc107; color: black; }
        .badge-danger { background-color: #dc3545; color: white; }
    </style>
</head>
<body>
<h1>{{ __('organizations.products') }}</h1>
<p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>

<table>
    <thead>
    <tr>
        <th>#</th>
        <th>{{ __('messages.name') }}</th>
        <th>{{ __('messages.description') }}</th>
        <th>{{ __('messages.short_description') }}</th>
        <th>{{ __('messages.slug') }}</th>
        <th>{{ __('messages.sku') }}</th>
        <th>{{ __('organizations.category') }}</th>
        <th>{{ __('organizations.brand') }}</th>
        <th>{{ __('organizations.stock') }}</th>
        <th>{{ __('messages.status') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($products as $product)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->description ?? '-' }}</td>
            <td>{{ $product->short_description ?? '-' }}</td>
            <td>{{ $product->slug ?? '-' }}</td>
            <td>{{ $product->sku ?? '-' }}</td>
            <td>{{ $product->category?->name ?? '-' }}</td>
            <td>{{ $product->brand?->name ?? '-' }}</td>
            <td>
                @if($product->stock_quantity > 10)
                    <span class="badge badge-success">{{ __('organizations.in_stock') }}</span>
                @elseif($product->stock_quantity > 0)
                    <span class="badge badge-warning">{{ __('organizations.low_stock') }}</span>
                @else
                    <span class="badge badge-danger">{{ __('organizations.out_of_stock') }}</span>
                @endif
            </td>
            <td>{{ $product->is_active ? __('messages.active') : __('messages.inactive') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
