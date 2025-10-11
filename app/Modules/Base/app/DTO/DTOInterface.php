<?php

namespace App\Modules\Base\app\DTO;

use Illuminate\Foundation\Http\FormRequest;

interface DTOInterface
{
    public static function fromArray(FormRequest|array $data): self;

    public function toArray(): array;
}
