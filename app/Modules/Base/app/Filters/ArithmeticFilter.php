<?php

namespace App\Modules\Base\app\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ArithmeticFilter extends BaseFilter
{
    protected array $filters = [];

    public function setFilters(array $filters): static
    {
        $this->filters = $filters;
        return $this;
    }

    public function filter(Builder $builder): Builder
    {
        $data = $this->request->all();

        foreach ($this->filters as $key => $options) {
            $requestKey = $options['key'] ?? $key;

            if (!isset($data[$requestKey])) {
                continue;
            }

            $value = $data[$requestKey];
            if ($value === '' || $value === null) {
                continue;
            }

            $column = $options['column'] ?? $key;
            $operator = $options['operator'] ?? '=';
            $isRange = $options['range'] ?? false;

            if (Str::contains($column, '.')) {
                [$relation, $column] = explode('.', $column, 2);

                $builder->whereHas($relation, function ($query) use ($column, $operator, $isRange, $value) {
                    $this->applyCondition($query, $column, $operator, $isRange, $value);
                });
            } else {
                $this->applyCondition($builder, $column, $operator, $isRange, $value);
            }
        }

        return $builder;
    }

    protected function applyCondition(Builder $query, string $column, string $operator, bool $isRange, mixed $value): void
    {
        if ($isRange) {
            if (is_string($value)) {
                $value = explode(',', $value);
            }

            $min = $value[0] ?? null;
            $max = $value[1] ?? null;

            $query->where(function ($q) use ($column, $min, $max) {
                if ($min !== null && $min !== '') {
                    $q->where($column, '>=', $min);
                }
                if ($max !== null && $max !== '') {
                    $q->where($column, '<=', $max);
                }
            });
        } else {
            $query->where($column, $operator, $value);
        }
    }
}
