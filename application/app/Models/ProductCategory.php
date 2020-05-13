<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductCategory
 *
 * @property int $id
 * @property string $name
 * @property int $order_no
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductCategory fuzzyName($name)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductCategory sort($column, $direction)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductCategory whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductCategory extends Model
{
    protected $fillable = [
        'name',
        'order_no',
    ];

    public function scopeFuzzyName(Builder $query, string $name)
    {
        $query->where("name", "like", "%{$name}%");
    }

    public function scopeSort(Builder $query, string $column, string $direction)
    {
        $order_by_column = null;
        switch ($column) {
            case "name":
                $order_by_column = "name";
                break;
            case "order_no":
                $order_by_column = "order_no";
                break;
            default:
                $order_by_column = "id";
        }

        $order_by_direction = null;
        switch ($direction) {
            case "desc":
                $order_by_direction = "DESC";
                break;
            default:
                $order_by_direction = "ASC";
        }

        return $query->orderBy($order_by_column, $order_by_direction);
    }
}
