<?php

namespace App\Modules\Organization\app\Models\OurTeam;

use App\Modules\Admin\app\Models\Employee\Employee;
use App\Modules\Admin\app\Models\Organization\Organization;
use App\Modules\Base\app\Models\BaseModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OurTeam extends BaseModel
{
    protected $table = 'our_teams';
    protected $fillable = [
        "image",
        "organization_id",
        "employee_id",
        "facebook_link",
        'x_link',
        'instagram_link',
        'tiktok_link',
        'name'
    ];
    public function employee() : BelongsTo
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }
    public function organization() : BelongsTo
    {
        return $this->belongsTo(Organization::class,'organization_id');
    }
}
