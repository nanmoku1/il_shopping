<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use App\Models\ModelTraits\ScopeUserNameEmailExtraction;

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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser forwardMatchEmail($email)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser fuzzyName($name)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser sort($column, $direction)
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
    use ScopeUserNameEmailExtraction;

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
     * @param string $column
     * @param string $direction
     * @return Builder
     */
    public function scopeSort(Builder $query, string $column, string $direction)
    {
        $order_by_column = null;
        switch ($column) {
            case "name":
                $order_by_column = "name";
                break;
            case "email":
                $order_by_column = "email";
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

    /**
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        if (filled($value)) {
            $this->attributes['password'] = \Hash::make($value);
        }
    }
}
