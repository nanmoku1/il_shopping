<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductReview[] $productReview
 * @property-read int|null $product_review_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $wishProduct
 * @property-read int|null $wish_product_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product comparePrice($price, $compare)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product fuzzyName($name)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product leftJoinProductCategory()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product sort($sort_key, $sort_asc_desc)
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

    public function productCategory()
    {
        return $this->hasOne(ProductCategory::class, "id", "product_category_id");
    }

    public function productReview()
    {
        return $this->hasMany(ProductReview::class, "product_id", "id");
    }

    public function wishProduct()
    {
        return $this->belongsToMany(User::class, "wish_products","product_id", "user_id");
    }

    public function scopeLeftJoinProductCategory(Builder $query)
    {
        $query->leftJoin("product_categories", "product_categories.id", "=", "products.product_category_id");
    }

    public function scopeFuzzyName(Builder $query, string $name)
    {
        $query->where("products.name", "like", "%{$name}%");
    }

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
    public function scopeSort(Builder $query, string $sort_key, string $sort_asc_desc)
    {
        $order_by_asc_desc = null;
        switch ($sort_asc_desc) {
            case "desc":
                $order_by_asc_desc = "DESC";
                break;
            default:
                $order_by_asc_desc = "ASC";
        }

        $order_by_key = null;
        switch ($sort_key) {
            case "product_category":
                return $query->orderBy("product_categories.order_no", $order_by_asc_desc)->orderBy("products.id", "ASC");
                break;
            case "name":
                $order_by_key = "products.name";
                break;
            case "price":
                $order_by_key = "products.price";
                break;
            default:
                $order_by_key = "products.id";
        }
        return $query->orderBy($order_by_key, $order_by_asc_desc);
    }

    /**
     * @param UploadedFile|null $value
     */
    public function setImagePathAttribute(?UploadedFile $value)
    {
        if (is_null($value)) {
            $this->attributes['image_path'] = null;
            return;
        }

        $this->attributes['image_path'] = $value->store("product_images");
    }
}
