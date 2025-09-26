<?php

namespace App\Models;

use App\Modules\Website\app\Enums\OtpPurposeEnum;
use App\Modules\Website\app\Enums\OtpStatusEnum;
use App\Modules\Website\app\Enums\OtpTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserOtp extends Model
{
    protected $fillable = [
        'user_id',
        'email',
        'phone',
        'otp_code',
        'expires_at',
        'type',
        'purpose',
        'status',
        'used_at',
        'attempts',
        'ip_address',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
        'type' => OtpTypeEnum::class,
        'purpose' => OtpPurposeEnum::class,
        'status' => OtpStatusEnum::class,
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class , "user_id");
    }

    public function isActive(): bool
    {
        return $this->status === OtpStatusEnum::PENDING && $this->expires_at->isFuture();
    }
}
