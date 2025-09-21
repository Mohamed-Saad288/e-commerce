<?php

namespace App\Modules\Organization\app\Models\Review;

use App\Models\User;
use App\Modules\Base\app\Models\BaseModel;
use App\Modules\Organization\app\Models\Product\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends BaseModel
{

    protected $table = 'reviews';
    protected $fillable = ['comment', 'rate', 'is_active', 'product_id', "user_id", "product_variation_id"];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, "product_id");
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }

}
