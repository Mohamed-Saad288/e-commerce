<?php

namespace App\Modules\Base\app\DTO;

interface DTOInterface
{
    public static function fromArray(array $data) : self;
    public function toArray(): array;
}
