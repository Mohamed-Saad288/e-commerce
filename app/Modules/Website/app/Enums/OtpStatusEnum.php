<?php

namespace App\Modules\Website\app\Enums;

enum OtpStatusEnum : int
{
    case PENDING = 1;
    case USED = 0;
    case EXPIRED = -1;
}
