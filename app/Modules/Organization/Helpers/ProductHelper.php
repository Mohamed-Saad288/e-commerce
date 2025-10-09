<?php

use Illuminate\Support\Str;

function generateSlug(string $title): string
{
    return Str::slug($title, '-');
}

function generateSku(int $productId, string $prefix = 'PRD'): string
{
    return $prefix.'-'.str_pad($productId, 5, '0', STR_PAD_LEFT);
}
