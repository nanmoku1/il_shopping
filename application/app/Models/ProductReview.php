<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductReview
 *
 * @property int $id
 * @property int $product_id
 * @property int $user_id
 * @property string $title
 * @property string $body
 * @property int $rank
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductReview newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductReview newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductReview query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductReview whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductReview whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductReview whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductReview whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductReview whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductReview whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductReview whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductReview whereUserId($value)
 * @mixin \Eloquent
 */
class ProductReview extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'title',
        'body',
        'rank',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, "product_id", "id");
    }
}
