<?php

namespace App\Models\ModelTraits;

use Illuminate\Database\Eloquent\Builder;

trait ScopeForwardMatchEmail
{
    /**
     * @param Builder $query
     * @param string $email
     */
    public function scopeForwardMatchEmail(Builder $query, string $email)
    {
        $query->where($this->getTable().".email", "like", "{$email}%");
    }
}
