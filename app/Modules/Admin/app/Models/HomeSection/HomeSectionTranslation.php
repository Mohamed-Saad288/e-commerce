<?php

namespace App\Modules\Admin\app\Models\HomeSection;

use Illuminate\Database\Eloquent\Model;

class HomeSectionTranslation extends Model
{
    protected $table = "home_section_translations";
    public $timestamps = false;
    protected $fillable = [
        "home_section_id",
        "locale",
        "title",
        "description",
        "button_text",
    ];
}
