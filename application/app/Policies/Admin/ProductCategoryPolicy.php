<?php

namespace App\Policies\Admin;

use App\Models\AdminUser;
use App\Models\ProductCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * @param AdminUser $login_user
     * @return bool
     */
    public function viewAny(AdminUser $login_user)
    {
        return true;
    }

    /**
     * @param AdminUser $login_user
     * @param ProductCategory $product_category
     * @return bool
     */
    public function view(AdminUser $login_user, ProductCategory $product_category)
    {
        return true;
    }

    /**
     * @param AdminUser $login_user
     * @return bool
     */
    public function create(AdminUser $login_user)
    {
        return true;
    }

    /**
     * @param AdminUser $login_user
     * @param ProductCategory $product_category
     * @return bool
     */
    public function update(AdminUser $login_user, ProductCategory $product_category)
    {
        return true;
    }

    /**
     * @param AdminUser $login_user
     * @param ProductCategory $product_category
     * @return bool
     */
    public function delete(AdminUser $login_user, ProductCategory $product_category)
    {
        //カテゴリーに紐づく商品が存在しない場合に削除可能
        return $product_category->products()->doesntExist();
    }
}
