<?php

namespace App\Modules\Organization\app\Models\Option;

use App\Modules\Base\app\Models\BaseModel;
use App\Modules\Organization\app\Models\Category\Category;
use App\Modules\Organization\app\Models\OptionItem\OptionItem;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Option extends BaseModel implements TranslatableContract
{
    use Translatable;

    public array $translatedAttributes = ['name'];

    protected $table = 'options';

    protected $fillable = ['organization_id', 'employee_id', 'category_id'];

    public function items(): HasMany
    {
        return $this->hasMany(OptionItem::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
