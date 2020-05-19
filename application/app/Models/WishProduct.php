<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\WishProduct
 *
 * @property int $user_id
 * @property int $product_id
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WishProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WishProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WishProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WishProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WishProduct whereUserId($value)
 * @mixin \Eloquent
 */
class WishProduct extends Model
{
    protected $primaryKey = [
        'user_id',
        'product_id',
    ];

    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'product_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product()
    {
        return $this->hasOne(Product::class, "id", "product_id");
    }
}
