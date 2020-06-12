<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ScopeForwardMatchTrait
{
    /**
     * @param Builder $query
     * @param string $column
     * @param string $keyword
     * @return Builder
     */
    public function scopeForwardMatch(Builder $query, string $column, string $keyword)
    {
        return $query->where($column, "like", "{$keyword}%");
    }
}
