<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use App\Models\ProductCategory;

class ProductCategories
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $product_categories = ProductCategory::sort("order_no", "asc")->select(["id", "name", "order_no"])->get();
        View::share(compact("product_categories"));
        return $next($request);;
    }
}
