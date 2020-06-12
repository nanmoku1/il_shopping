<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use App\Models\Traits\ScopeFuzzyTrait;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property int $product_category_id
 * @property string $name
 * @property int $price
 * @property string|null $description
 * @property string|null $image_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ProductCategory $productCategory
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductReview[] $productReviews
 * @property-read int|null $product_reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $wishedUsers
 * @property-read int|null $wished_users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product comparePrice($price, $compare)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product fuzzy($column, $keyword)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product sort($column, $direction)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereProductCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    use ScopeFuzzyTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_category_id',
        'name',
        'price',
        'description',
        'image_path',
    ];

    /**
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        self::deleting(function($product) {
            $product->productReviews()->delete();
            $product->wishedUsers()->detach();
            \Storage::delete($product->image_path);
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function productCategory()
    {
        return $this->hasOne(ProductCategory::class, "id", "product_category_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productReviews()
    {
        return $this->hasMany(ProductReview::class, "product_id", "id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function wishedUsers()
    {
        return $this->belongsToMany(User::class, "wish_products", "product_id", "user_id");
    }

    /**
     * @param Builder $query
     * @param int $price
     * @param string $compare
     */
    public function scopeComparePrice(Builder $query, int $price, string $compare)
    {
        switch ($compare) {
            case "lteq":
                $query->where("products.price", "<=", $price);
                break;
            default:
                $query->where("products.price", ">=", $price);
        }
    }

    /**
     * @param Builder $query
     * @param string $sort_key
     * @param string $sort_asc_desc
     * @return Builder
     */
    public function scopeSort(Builder $query, string $column, string $direction)
    {
        $order_by_column = null;
        switch ($direction) {
            case "desc":
                $order_by_column = "DESC";
                break;
            default:
                $order_by_column = "ASC";
        }

        $order_by_direction = null;
        switch ($column) {
            case "product_category":
                return $query->leftJoin("product_categories", "product_categories.id", "=", "products.product_category_id")
                    ->orderBy("product_categories.order_no", $order_by_column)
                    ->orderBy("products.id", "ASC");
                break;
            case "review_rank":
                return $query
                    ->leftJoin('product_reviews', 'product_reviews.product_id', '=', 'products.id')
                    ->groupBy('products.id')
                    ->select('products.*')
                    ->orderByRaw('avg(`product_reviews`.`rank`) desc')
                    ->orderBy('products.id', 'asc');
                break;
            case "name":
                $order_by_direction = "products.name";
                break;
            case "price":
                $order_by_direction = "products.price";
                break;
            default:
                $order_by_direction = "products.id";
        }
        return $query->orderBy($order_by_direction, $order_by_column);
    }

    /**
     * @param UploadedFile|null $value
     */
    public function setImagePathAttribute(?UploadedFile $value)
    {
        if (is_null($value)) {
            $this->attributes['image_path'] = null;
        } else {
            $this->attributes['image_path'] = $value->store("product_images");
        }
        \Storage::delete($this->getOriginal("image_path"));
    }
}
