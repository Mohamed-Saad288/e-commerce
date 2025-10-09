<?php

namespace App\Modules\Website\app\Enums;

enum OtpPurposeEnum: int
{
    case VERIFICATION = 1;
    case PASSWORD_RESET = 2;
    case LOGIN_VERIFICATION = 3;
}
