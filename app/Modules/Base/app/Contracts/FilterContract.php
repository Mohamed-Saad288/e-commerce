<?php

namespace App\Modules\Base\app\Contracts;

use Closure;
use Illuminate\Database\Eloquent\Builder;

interface FilterContract
{
    /**
     * Apply the filter logic to the query builder.
     */
    public function handle(Builder $builder, Closure $next): Builder;

    /**
     * Determine whether this filter should be applied.
     */
    public function shouldApply(): bool;

    /**
     * Get a readable name for this filter (used for logging/debugging).
     */
    public function getName(): string;
}
