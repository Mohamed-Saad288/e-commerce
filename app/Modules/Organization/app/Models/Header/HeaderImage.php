<?php

namespace App\Modules\Organization\app\Models\Header;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HeaderImage extends Model
{
    protected $table = "header_images";
    protected $fillable = [
        "image",
        "header_id"
    ];

    public function header(): BelongsTo
    {
        return $this->belongsTo(Header::class,'header_id');
    }
}
