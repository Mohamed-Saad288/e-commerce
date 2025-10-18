<?php

namespace App\Modules\Base\app\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class BooleanFilter extends BaseFilter
{
    protected array $filters = [];

    public function setFilters(array $filters): static
    {
        $this->filters = $filters;

        return $this;
    }

    public function filter(Builder $builder): Builder
    {
        if (! filled($this->request) || empty($this->filters)) {
            return $builder;
        }

        foreach ($this->filters as $key => $config) {
            if (! $this->request->has($key) || empty($config['column'])) {
                continue;
            }

            $value = $this->request->get($key);
            $isTrue = in_array($value, [1, '1', true, 'true'], true);
            $isFalse = in_array($value, [0, '0', false, 'false'], true);

            $column = $config['column'];

            if (Str::contains($column, '.')) {
                [$relation, $col] = explode('.', $column, 2);

                $builder->whereHas($relation, function (Builder $query) use ($isTrue, $isFalse, $col, $config) {
                    $this->applyBooleanCondition($query, $col, $isTrue, $isFalse, $config);
                });

                continue;
            }

            $this->applyBooleanCondition($builder, $column, $isTrue, $isFalse, $config);
        }

        return $builder;
    }

    protected function applyBooleanCondition(Builder $builder, string $column, bool $isTrue, bool $isFalse, array $config): void
    {
        if ($isTrue) {
            if (isset($config['true_condition'])) {
                [$operator, $val] = $config['true_condition'];
                $builder->where($column, $operator, $val);
            } else {
                $builder->where($column, true);
            }
        } elseif ($isFalse) {
            if (isset($config['false_condition'])) {
                [$operator, $val] = $config['false_condition'];
                $builder->where($column, $operator, $val);
            } else {
                $builder->where($column, false);
            }
        }
    }
}
