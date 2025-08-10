<?php

namespace App\Modules\Admin\Enums\Feature;

enum FeatureTypeEnum : int
{
    case LIMIT = 1;
    case BOOLEAN = 2;
    case TEXT = 3;


    public function label(): string
    {
        return match ($this) {
            self::LIMIT => 'Limit',
            self::BOOLEAN => 'Boolean',
            self::TEXT => 'Text',
        };
    }

}
