<?php

namespace App\Modules\Organization\app\Models\ProductVariation;

use Illuminate\Database\Eloquent\Model;

class ProductVariationTranslation extends Model
{
    protected $table = 'product_variation_translations';

    public $timestamps = false;

    protected $fillable = ['name'];
}
