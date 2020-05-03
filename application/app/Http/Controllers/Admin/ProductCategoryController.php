<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductCategories\ProductCategoryCreateRequest;
use App\Http\Requests\Admin\ProductCategories\ProductCategoryEditRequest;
use App\Http\Requests\Admin\ProductCategories\ProductCategoryIndexRequest;
use App\Models\AdminUser;
use App\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    /**
     * @param ProductCategoryIndexRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(ProductCategoryIndexRequest $request)
    {
        $builder_product_category = ProductCategory::select([
            "id",
            "name",
            "order_no",
        ]);
        if (filled($request->name())) {
            $builder_product_category->fuzzyName($request->name());
        }

        $builder_product_category->sort($request->sortColumn(), $request->sortDirection());
        $product_categories = $builder_product_category->paginate($request->pageUnit());
        return view('admin.product_categories.index', compact("product_categories", "request"));
    }

    /**
     * @param ProductCategory $product_category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(ProductCategory $product_category)
    {
        return view('admin.product_categories.show', compact("product_category"));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.product_categories.create');
    }

    /**
     * @param ProductCategoryCreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductCategoryCreateRequest $request)
    {
        $create_product_category = ProductCategory::create($request->validated());
        return redirect()->route("admin.product_categories.show", $create_product_category->id);
    }

    /**
     * @param ProductCategory $product_category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(ProductCategory $product_category)
    {
        return view('admin.product_categories.edit', compact("product_category"));
    }

    /**
     * @param ProductCategoryEditRequest $request
     * @param ProductCategory $product_category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductCategoryEditRequest $request, ProductCategory $product_category)
    {
        $product_category->update($request->validated());
        return redirect()->route("admin.product_categories.show", $product_category->id);
    }

    /**
     * @param AdminUser $admin_user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(AdminUser $admin_user)
    {
        $admin_user->delete();
        return redirect()->route("admin.product_categories.index");
    }
}
