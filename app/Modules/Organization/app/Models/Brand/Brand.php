<?php

namespace App\Modules\Organization\app\Models\Brand;

use App\Modules\Base\app\Models\BaseModel;
use App\Modules\Organization\app\Models\Category\Category;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Brand extends BaseModel implements TranslatableContract
{

    use Translatable;

    public array $translatedAttributes = ['name', 'description'];


    protected $table = 'brands';

    protected $fillable = [
        'slug',
        'category_id',
        "organization_id",
        "employee_id"
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
