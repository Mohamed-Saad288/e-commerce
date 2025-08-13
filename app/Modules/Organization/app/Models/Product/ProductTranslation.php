<?php

namespace App\Modules\Organization\app\Models\Product;

use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{

    protected $table = 'product_translations';
    protected $guarded = ['id'];
    public $timestamps = false;
}
