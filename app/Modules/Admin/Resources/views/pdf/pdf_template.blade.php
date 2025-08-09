<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __("messages." . $title) }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};
            text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};
        }
    </style>
</head>
<body>

<h2>{{ __("messages." . $title) }}</h2>

<table>
    <thead>
    <tr>
        @if(count($data) > 0)
            @foreach(array_keys($data->first()->toArray()) as $column)
                <th>{{ __("messages." . $column) }}</th>
            @endforeach
        @endif
    </tr>
    </thead>
    <tbody>
    @foreach($data as $row)
        <tr>
            @foreach($row->toArray() as $value)
                <td>{{ $value }}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
