<?php

use App\Modules\Organization\Enums\Product\TaxTypeEnum;

function calculateTotalPrice(array $data): float
{
    $selling_price = $data['selling_price'] ?? 0;
    $discount = $data['discount'] ?? 0;
    $tax_amount = $data['tax_amount'] ?? 0;
    $tax_type = $data['tax_type'] ?? 0;
    $is_taxable = $data['is_taxable'] ?? false;
    $total = $selling_price - $discount;

    if ($is_taxable) {
        $total += ($tax_type == TaxTypeEnum::amount->value) ? $tax_amount : ($total * $tax_amount / 100);
    }

    return round($total, 2);
}



// In helpers.php or AppServiceProvider
function format_price($price): string
{
    return number_format($price, 2);
}
