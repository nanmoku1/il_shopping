<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProductReview;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductReviewPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $login_user
     * @return bool
     */
    public function create(User $login_user)
    {
        return true;
    }

    /**
     * @param User $login_user
     * @param ProductReview $product_review
     * @return bool
     */
    public function update(User $login_user, ProductReview $product_review)
    {
        return $login_user->id === $product_review->user_id;
    }
}
