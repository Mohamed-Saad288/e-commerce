<?php

namespace App\Modules\Base\Traits;

use Illuminate\Pipeline\Pipeline;

trait Filterable
{
    protected function applyFilters($query, array $filters = []): mixed
    {
        return app(Pipeline::class)
            ->send($query)
            ->through($filters)
            ->thenReturn();
    }
}
