<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\ProductIndexRequest;
use App\Http\Requests\Admin\Products\ProductStoreRequest;
use App\Http\Requests\Admin\Products\ProductUpdateRequest;
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
        $product_categories = $this->_get_product_categories();
        $product = Product::select([
            "products.*"
        ])
            ->with("productCategory");
        if (filled($request->name())) {
            $product->fuzzy("products.name", $request->name());
        }
        if (filled($request->price())) {
            $product->comparePrice($request->price(), $request->priceCompare());
        }
        if (filled($request->productCategoryId())) {
            $product->whereProductCategoryId($request->productCategoryId());
        }
        $product->sort($request->sortColumn(), $request->sortDirection());
        $products = $product->paginate($request->pageUnit());
        return view('admin.products.index', compact("products","product_categories"));
    }

    /**
     * @param Product $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact("product"));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $product_categories = $this->_get_product_categories();
        return view('admin.products.create', compact("product_categories"));
    }

    /**
     * @param ProductStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductStoreRequest $request)
    {
        $product = Product::create($request->validated());
        return redirect()->route("admin.products.show", $product->id);
    }

    /**
     * @param Product $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Product $product)
    {
        $product_categories = $this->_get_product_categories();
        return view('admin.products.edit', compact("product", "product_categories"));
    }

    /**
     * @param ProductUpdateRequest $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $update_data = $request->validated();
        if ($request->imageDelete()) {
            $update_data["image_path"] = null;
        }
        $product->update($update_data);
        return redirect()->route("admin.products.show", $product->id);
    }

    /**
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route("admin.products.index");
    }

    /**
     * @return ProductCategory[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    private function _get_product_categories()
    {
        return ProductCategory::sort("order_no", "asc")->get();
    }
}
