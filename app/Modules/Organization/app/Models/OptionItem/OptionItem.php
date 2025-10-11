<?php

namespace App\Modules\Organization\app\Models\OptionItem;

use App\Modules\Base\app\Models\BaseModel;
use App\Modules\Organization\app\Models\Option\Option;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OptionItem extends BaseModel implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['name'];

    protected $fillable = [
        'option_id',
        'organization_id',
        'employee_id',
    ];

    protected $table = 'option_items';

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }
}
