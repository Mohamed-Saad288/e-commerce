<?php

namespace App\Modules\Base\app\Filters;

use Closure;

class StringSearch extends BaseFilter
{

    public function handle($builder, Closure $next , $column = "search"): void
    {
        if (filled($this->request) && $this->request->has($column)){
            $value = $this->request->get($column);
            $builder->whereTranslationLike("title",$value)
                ->orWhereTranslationLike("name" , $value)
                ->orWhereTranslationLike("slug" , $value)
                ->orWhereTranslationLike("description" , $value);
        }
    }
}
