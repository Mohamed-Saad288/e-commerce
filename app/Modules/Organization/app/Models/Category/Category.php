<?php

namespace App\Modules\Organization\app\Models\Category;

use App\Modules\Base\app\Models\BaseModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends BaseModel implements TranslatableContract
{

    use Translatable;

    public array $translatedAttributes = ['name', 'description'];

    protected $table = 'categories';
    protected $fillable = [
        'parent_id',
        'sort_order',
        "slug",
        "organization_id",
        "employee_id"
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

}
