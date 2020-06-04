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
            \DB::table('wish_products')->insert([
                'user_id' => auth('user')->user()->id,
                'product_id' => $product->id,
            ]);
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
            \DB::table('wish_products')
                ->where('product_id', $product->id)
                ->where('user_id', auth('user')->user()->id)
                ->delete();
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
