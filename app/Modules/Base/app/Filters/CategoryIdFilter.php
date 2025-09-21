<?php

namespace App\Modules\Base\app\Filters;

use Closure;

class CategoryIdFilter extends BaseFilter
{


    public function handle($builder, Closure $next, $column = "category_id")
    {
        if (filled($this->request) && $this->request->has($column)) {
            $value = $this->request->get($column);
            $builder->whereHas('categories', function ($query) use ($value) {
                $query->where('categories.id', $value);
            });
        }

        return $next($builder);
    }
}
