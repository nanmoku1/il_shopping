<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;

class WishProductController extends Controller
{
    /**
     * @param Product $product
     * @return array
     */
    public function store(Product $product)
    {
        try {
            $product->wishedUsers()->attach(auth('user')->user()->id);
        }
        catch (\Exception $error) {
            return [
                'success' => 0,
            ];
        }
        return [
            'success' => 1,
        ];
    }

    /**
     * @param Product $product
     * @return array
     */
    public function destroy(Product $product)
    {
        try {
            $product->wishedUsers()->detach(auth('user')->user()->id);
        }
        catch (\Exception $error) {
            return [
                'success' => 0,
            ];
        }
        return [
            'success' => 1,
        ];
    }
}
