<?php

use Carbon\Carbon;

function getSiteName() : string
{
    return config('app.name');
}

function convertCreatedAt($createdAt = null): ?string
{
    return $createdAt ? Carbon::parse($createdAt)->format('Y-m-d') : null;
}

function convertToArray($data): array
{
    return is_array($data) && !empty($data) ? $data : [$data] ?? [];
}

