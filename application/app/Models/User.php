<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Http\UploadedFile;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $image_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductReview[] $productReviews
 * @property-read int|null $product_reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $wishProducts
 * @property-read int|null $wish_products_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User fuzzyEmail($email)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User fuzzyName($name)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User sort($sort_key, $sort_asc_desc)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image_path',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productReviews()
    {
        return $this->hasMany(ProductReview::class, "user_id", "id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function wishProducts()
    {
        return $this->belongsToMany(Product::class, "wish_products","user_id", "product_id");
    }

    /**
     * @param Builder $query
     * @param string $name
     */
    public function scopeFuzzyName(Builder $query, string $name)
    {
        $query->where("name", "like", "%{$name}%");
    }

    /**
     * @param Builder $query
     * @param string $email
     */
    public function scopePrefixMatchEmail(Builder $query, string $email)
    {
        $query->where("email", "like", "{$email}%");
    }

    /**
     * @param Builder $query
     * @param string $sort_key
     * @param string $sort_asc_desc
     * @return Builder
     */
    public function scopeSort(Builder $query, string $sort_key, string $sort_asc_desc)
    {
        $order_by_key = null;
        switch ($sort_key) {
            case "name":
                $order_by_key = "name";
                break;
            case "email":
                $order_by_key = "email";
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

    /**
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        if (filled($value)) {
            $this->attributes['password'] = \Hash::make($value);
        }
    }

    /**
     * @param UploadedFile|null $value
     */
    public function setImagePathAttribute(?UploadedFile $value)
    {
        if (is_null($value)) {
            $this->attributes['image_path'] = null;
        } else {
            $this->attributes['image_path'] = $value->store("user_images");
        }
        \Storage::delete($this->getOriginal("image_path"));
    }
}
