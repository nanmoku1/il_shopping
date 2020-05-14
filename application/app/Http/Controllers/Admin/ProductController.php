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
        $product_categories = ProductCategory::sort("id", "asc")
            ->select([
                "id",
                "name",
            ])->get();
        $builder_product = Product::leftJoinProductCategory()
            ->select([
                "products.id",
                "products.name",
                "product_categories.name AS product_category_name",
                "products.price",
            ]);
        if (filled($request->name())) {
            $builder_product->fuzzyName($request->name());
        }
        if (filled($request->price())) {
            $builder_product->comparePrice($request->price(), $request->priceCompare());
        }
        if (filled($request->productCategoryId())) {
            $builder_product->whereProductCategoryId($request->productCategoryId());
        }
        $builder_product->sort($request->sortColumn(), $request->sortDirection());
        $products = $builder_product->paginate($request->pageUnit());
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
        $product_categories = ProductCategory::sort("id", "asc")
            ->select([
                "id",
                "name",
            ])->get();
        return view('admin.products.create', compact("product_categories"));
    }

    /**
     * @param ProductStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductStoreRequest $request)
    {

        $create_product = Product::create($request->validated());
        return redirect()->route("admin.products.show", $create_product->id);
    }

    /**
     * @param Product $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Product $product)
    {
        $product_categories = ProductCategory::sort("id", "asc")
            ->select([
                "id",
                "name",
            ])->get();
        return view('admin.products.edit', compact("product", "product_categories"));
    }

    /**
     * @param ProductUpdateRequest $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $old_image_path = $product->image_path;
        $update_data = $request->validated();
        if ($request->imageDel()) {
            $update_data["image_path"] = null;
        }
        if ($product->update($update_data) && $old_image_path !== $product->image_path
            && filled($old_image_path) && \Storage::exists($old_image_path)) {
            \Storage::delete($old_image_path);
        }
        return redirect()->route("admin.products.show", $product->id);
    }

    /**
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Product $product)
    {
        $old_image_path = $product->image_path;
        if ($product->delete() && filled($old_image_path) && \Storage::exists($old_image_path)) {
            \Storage::delete($old_image_path);
        }
        return redirect()->route("admin.products.index");
    }
}
