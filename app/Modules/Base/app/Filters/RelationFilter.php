<?php

namespace App\Modules\Base\app\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class RelationFilter extends BaseFilter
{
    protected array $relations = [];

    public function filter(Builder $builder): Builder
    {
        if (!filled($this->request) && empty($this->relations)) {
            return $builder;
        }
        foreach ($this->relations as $relation => $config) {
            $key = $config['key'] ?? null;
            $column = $config['column'] ?? null;
            $operator = strtolower($config['operator'] ?? '=');
            if (!$key || !$column || !$this->request->has($key)) {
                continue;
            }
            $value = $this->request->get($key);
            $builder->whereHas($relation, function ($query) use ($column, $operator, $value) {
                switch ($operator) {
                    case 'in':
                        $query->whereIn($column, (array)$value);
                        break;

                    case 'like':
                        $query->where($column, 'LIKE', "%{$value}%");
                        break;

                    default:
                        $query->where($column, $operator,$value);
                        break;
                }
            });
        }
        return $builder;
    }

    public function setRelations(array $relations): static
    {
        $this->relations = $relations;
        return $this;
    }

}
