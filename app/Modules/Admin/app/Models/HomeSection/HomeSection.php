<?php

namespace App\Modules\Admin\app\Models\HomeSection;

use App\Modules\Admin\app\Models\Organization\Organization;
use App\Modules\Organization\app\Models\Product\Product;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class HomeSection extends Model
{
    use Translatable;
    protected $table = "home_sections";
    public array $translatedAttributes = ['title','description'];
    protected $casts = [
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
    ];

    protected $fillable = [
        "organization_id",
        "start_date",
        "end_date",
        "type",
        "sort_order",
    ];

    public function organization() : BelongsTo
    {
        return $this->belongsTo(Organization::class,"organization_id");
    }
    public function products() : BelongsToMany
    {
        return $this->belongsToMany(Product::class,"home_section_products","home_section_id","product_id");
    }
}
