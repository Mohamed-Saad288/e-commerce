<?php

namespace App\Modules\Base\app\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class SearchFilter extends BaseFilter
{
    protected array $searchable = [];

    protected array $relations = [];

    protected string $searchParam = 'search';

    protected string $mode = 'like'; // like | exact | starts_with | ends_with

    public function filter(Builder $builder): Builder
    {
        $globalSearch = $this->get($this->searchParam);
        if ($globalSearch && ! empty($this->searchable)) {
            $builder->where(function (Builder $query) use ($globalSearch, $builder) {
                foreach ($this->searchable as $column) {
                    if ($this->isTranslatable($builder->getModel(), $column)) {
                        $query->orWhereHas('translations', function (Builder $transQuery) use ($column, $globalSearch) {
                            $transQuery->where($column, $this->getOperator(), $this->formatSearchTerm($globalSearch));
                        });
                        continue;
                    }
                    $query->orWhere($column, $this->getOperator(), $this->formatSearchTerm($globalSearch));
                }

                foreach ($this->relations as $relation => $columns) {
                    $query->orWhereHas($relation, function (Builder $relQuery) use ($columns, $globalSearch) {
                        $relatedModel = $relQuery->getModel();

                        $relQuery->where(function (Builder $subQuery) use ($columns, $globalSearch, $relatedModel) {
                            foreach ($columns as $column) {
                                if ($this->isTranslatable($relatedModel, $column)) {
                                    $subQuery->orWhereHas('translations', function (Builder $transQuery) use ($column, $globalSearch) {
                                        $transQuery->where($column, $this->getOperator(), $this->formatSearchTerm($globalSearch));
                                    });
                                    continue;
                                }
                                $subQuery->orWhere($column, $this->getOperator(), $this->formatSearchTerm($globalSearch));
                            }
                        });
                    });
                }
            });
        }

        foreach ($this->request->query() as $key => $value) {
            if (empty($value) || $key === $this->searchParam) {
                continue;
            }

            if (Str::contains($key, '.')) {
                [$relation, $column] = explode('.', $key);
                if (! isset($this->relations[$relation]) || ! in_array($column, $this->relations[$relation])) {
                    continue;
                }

                $builder->whereHas($relation, function (Builder $relQuery) use ($column, $value) {
                    $relQuery->where($column, $this->getOperator(), $this->formatSearchTerm($value));
                });
            } elseif (in_array($key, $this->searchable)) {
                $builder->where($key, $this->getOperator(), $this->formatSearchTerm($value));
            }
        }

        return $builder;
    }

    public function setSearchable(array $columns): static
    {
        $this->searchable = $columns;
        return $this;
    }

    public function setRelations(array $relations): static
    {
        $this->relations = $relations;
        return $this;
    }

    public function setSearchMode(string $mode): static
    {
        $this->mode = $mode;
        return $this;
    }

    protected function getOperator(): string
    {
        return $this->mode === 'exact' ? '=' : 'LIKE';
    }

    protected function formatSearchTerm(string $term): string
    {
        return match ($this->mode) {
            'starts_with' => "{$term}%",
            'ends_with' => "%{$term}",
            'exact' => $term,
            default => "%{$term}%",
        };
    }
}
