<?php

namespace App\Modules\Base\app\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (app()->bound('organization_id')) {
            $builder->where(
                $model->getTable().'.organization_id',
                app('organization_id')
            );
        }
    }
}
