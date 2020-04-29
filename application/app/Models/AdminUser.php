<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\AdminUser
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property bool $is_owner
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser fuzzyEmail($email)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser fuzzyName($name)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser sort($sort_key = 'id', $sort_asc_desc = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser whereIsOwner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AdminUser extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_owner',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'is_owner' => 'boolean'
    ];

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
    public function scopeFuzzyEmail(Builder $query, string $email)
    {
        $query->where("email", "like", "{$email}%");
    }

    /**
     * @param Builder $query
     * @param string $sort_key
     * @param string $sort_asc_desc
     * @return Builder
     */
    public function scopeSort(Builder $query, string $sort_key = "id", string $sort_asc_desc = "asc")
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
}
