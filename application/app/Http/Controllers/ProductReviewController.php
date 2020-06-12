<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductReviews\ProductReviewStoreRequest;
use App\Http\Requests\ProductReviews\ProductReviewUpdateRequest;
use App\Models\Product;
use App\Models\ProductReview;

class ProductReviewController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(ProductReview::class, 'product_review');
    }

    /**
     * @param Product $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Product $product)
    {
        return view('product_reviews.create', compact('product'));
    }

    /**
     * @param ProductReviewStoreRequest $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductReviewStoreRequest $request, Product $product)
    {
        $product_review = ProductReview::create(
            array_merge(
                $request->validated(),
                [
                    "user_id" => auth("user")->user()->id,
                    "product_id" => $product->id,
                ]
            )
        );
        return redirect()->route("products.show", $product->id);
    }

    /**
     * @param Product $product
     * @param ProductReview $product_review
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Product $product, ProductReview $product_review)
    {
        return view('product_reviews.edit', compact('product', 'product_review'));
    }

    /**
     * @param ProductReviewUpdateRequest $request
     * @param Product $product
     * @param ProductReview $product_review
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductReviewUpdateRequest $request, Product $product, ProductReview $product_review)
    {
        $product_review->update($request->validated());
        return redirect()->route("products.show", $product->id);
    }
}
