<?php

namespace App\Models\ModelTraits;

use Illuminate\Database\Eloquent\Builder;

trait ScopeWhereTrait
{
    /**
     * @param Builder $query
     * @param string $column
     * @param string $keyword
     */
    public function scopeFuzzy(Builder $query, string $column, string $keyword)
    {
        $query->where($column, "like", "%{$keyword}%");
    }

    /**
     * @param Builder $query
     * @param string $column
     * @param string $keyword
     */
    public function scopeForwardMatch(Builder $query, string $column, string $keyword)
    {
        $query->where($column, "like", "{$keyword}%");
    }
}
