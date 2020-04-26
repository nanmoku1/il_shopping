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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser listSearch($conditions = [])
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser query()
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
     * @param array $conditions
     * @return Builder
     */
    public function scopeListSearch(Builder $query, array $conditions = [])
    {
        //名称
        if (!empty($conditions["name"])) {
            $query->where("name", "like", "%{$conditions["name"]}%");
        }
        //メールアドレス
        if (!empty($conditions["email"])) {
            $query->where("email", "like", "{$conditions["email"]}%");
        }
        //権限
        if (isset($conditions["is_owner"])) {
            $query->where("is_owner", "=", $conditions["is_owner"]);
        }
        //ソート
        if (isset($conditions["order_key"])) {
            $order_key = null;
            switch ($conditions["order_key"]) {
                case "id":
                    $order_key = "id";
                    break;
                case "name":
                    $order_key = "name";
                    break;
                case "email":
                    $order_key = "email";
                    break;
            }

            if ($order_key) {
                $asc_desc = null;
                if (isset($conditions["asc_desc"])) {
                    switch ($conditions["asc_desc"]) {
                        case "asc":
                            $asc_desc = "ASC";
                            break;
                        case "desc":
                            $asc_desc = "DESC";
                            break;
                    }
                }

                $query->orderBy($order_key, $asc_desc);
            }
        }

        return $query;
    }
}
