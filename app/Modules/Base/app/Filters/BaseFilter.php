<?php

namespace App\Modules\Base\app\Filters;

use Closure;
use Illuminate\Http\Request;

abstract class BaseFilter
{
    protected Request $request;

    public function __construct(?Request $request = null)
    {
        $this->request = $request;
    }

    abstract public function handle($builder, Closure $next);
}
