<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\ProductCategory;

class ProductCategoriesComposer
{
    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $product_categories = ProductCategory::allProductCategories()->get();
        $view->with(compact('product_categories'));
    }
}
