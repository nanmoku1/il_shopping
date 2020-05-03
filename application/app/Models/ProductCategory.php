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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductCategory sort($sort_key, $sort_asc_desc)
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

    public function scopeSort(Builder $query, string $sort_key, string $sort_asc_desc)
    {
        $order_by_key = null;
        switch ($sort_key) {
            case "name":
                $order_by_key = "name";
                break;
            case "order_no":
                $order_by_key = "order_no";
                break;
            default:
                $order_by_key = "id";
        }

        $order_by_asc_desc = null;
        switch ($sort_asc_desc) {
            case "desc":
                $order_by_asc_desc = "DESC";
                break;
            default:
                $order_by_asc_desc = "ASC";
        }

        return $query->orderBy($order_by_key, $order_by_asc_desc);
    }
}
