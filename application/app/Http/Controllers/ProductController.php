<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\ProductIndexRequest;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductController extends Controller
{
    /**
     * @param ProductIndexRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(ProductIndexRequest $request)
    {
        $product = Product::query();
        if (auth('user')->check()) {
            $product->with(['wishedUsers' => function($query) {
                $query->where('wish_products.user_id', auth('user')->user()->id);
            }]);
        }
        if (filled($request->keyword())) {
            $product->fuzzyName($request->keyword());
        }
        if (filled($request->productCategoryId())) {
            $product->whereProductCategoryId($request->productCategoryId());
        }
        $sort_conditions = $request->sort();
        $product->sort($sort_conditions["column"], $sort_conditions["direction"]);

        $products = $product->paginate(15);

        $specified_category = $this->getSpecifiedCategory($request->productCategoryId());
        return view('products.index', compact('products', 'specified_category'));
    }

    /**
     * @param Product $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Product $product)
    {
        $product->load([
            "productReviews" => function($query) {
                $query->orderBy("id", "DESC");
            }
        ]);
        return view('products.show', compact('product'));
    }

    /**
     * @param $product_category_id
     * @return string
     */
    private function getSpecifiedCategory($product_category_id)
    {
        $specified_category = "";
        if (filled($product_category_id)) {
            if ($product_category = ProductCategory::find($product_category_id)) {
                $specified_category = $product_category->name;
            }
        }
        return $specified_category;
    }
}
