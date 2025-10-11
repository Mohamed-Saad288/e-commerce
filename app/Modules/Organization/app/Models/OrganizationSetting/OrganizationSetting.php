<?php

namespace App\Modules\Organization\app\Models\OrganizationSetting;

use App\Modules\Admin\app\Models\Employee\Employee;
use App\Modules\Admin\app\Models\Organization\Organization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationSetting extends Model
{
    protected $table = 'organization_settings';

    public $timestamps = false;

    protected $fillable = [
        'organization_id',
        'employee_id',
        'logo',
        'primary_color',
        'secondary_color',
        'facebook_link',
        'instagram_link',
        'phone',
        'email',
        'address',
        'lat',
        'lng',
        'x_link',
        'tiktok_link',
    ];

    /**
     * Relations
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
