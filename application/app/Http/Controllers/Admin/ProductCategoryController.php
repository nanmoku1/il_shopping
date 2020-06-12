<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductCategories\ProductCategoryStoreRequest;
use App\Http\Requests\Admin\ProductCategories\ProductCategoryUpdateRequest;
use App\Http\Requests\Admin\ProductCategories\ProductCategoryIndexRequest;
use App\Models\AdminUser;
use App\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    /**
     * AdminUserController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(ProductCategory::class, "product_category");
    }

    /**
     * @param ProductCategoryIndexRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(ProductCategoryIndexRequest $request)
    {
        $product_category = ProductCategory::query();
        if (filled($request->name())) {
            $product_category->fuzzy("product_categories.name", $request->name());
        }

        $product_category->sort($request->sortColumn(), $request->sortDirection());
        $product_categories = $product_category->paginate($request->pageUnit());
        return view('admin.product_categories.index', compact("product_categories"));
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
     * @param ProductCategoryStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductCategoryStoreRequest $request)
    {
        $product_category = ProductCategory::create($request->validated());
        return redirect()->route("admin.product_categories.show", $product_category->id);
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
     * @param ProductCategoryUpdateRequest $request
     * @param ProductCategory $product_category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductCategoryUpdateRequest $request, ProductCategory $product_category)
    {
        $product_category->update($request->validated());
        return redirect()->route("admin.product_categories.show", $product_category->id);
    }

    /**
     * @param AdminUser $admin_user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(ProductCategory $product_category)
    {
        $product_category->delete();
        return redirect()->route("admin.product_categories.index");
    }
}
