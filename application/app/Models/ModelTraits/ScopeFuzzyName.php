<?php

namespace App\Models\ModelTraits;

use Illuminate\Database\Eloquent\Builder;

trait ScopeFuzzyName
{
    /**
     * @param Builder $query
     * @param string $name
     */
    public function scopeFuzzyName(Builder $query, string $name)
    {
        $query->where($this->getTable().".name", "like", "%{$name}%");
    }
}
