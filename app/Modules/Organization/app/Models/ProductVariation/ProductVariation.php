<?php

namespace App\Modules\Organization\app\Models\ProductVariation;

use App\Modules\Base\app\Models\BaseModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends BaseModel implements TranslatableContract
{
    use Translatable;

    public array $translatedAttributes = ['name'];

    protected $table = 'product_variations';


    protected $fillable = [
        "product_id",
        "sku",
        "barcode",
        "stock_quantity",
        "is_featured",
        "is_taxable",
        "tax_type",
        "tax_amount",
        "discount",
        "cost_price",
        "selling_price",
        "total_price",
        "added_by_id",
        "organization_id",
        "employee_id",
    ];

}
