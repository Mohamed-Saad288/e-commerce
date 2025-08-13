<?php

namespace App\Modules\Organization\app\Models\Product;

use App\Modules\Base\app\Models\BaseModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Product extends  BaseModel implements TranslatableContract
{
    use Translatable;

    public array $translatedAttributes = ['name', 'description' , "short_description"];

    protected $table = 'products';

    protected $fillable = [
      "slug",
      "brand_id",
      "category_id",
      "sort_order",
      "sku",
      "barcode",
      "type",
      "stock_quantity",
      "low_stock_threshold",
      "requires_shipping",
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
