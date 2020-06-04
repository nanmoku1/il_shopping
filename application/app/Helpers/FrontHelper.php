<?php

use App\Models\ProductCategory;

if (! function_exists('productCategoriesSelectInputTag')) {
    /**
     * @param array $attributes
     * @param $select_product_category_id
     * @return string
     */
    function productCategoriesSelectInputTag(array $attributes, $select_product_category_id)
    {
        $output_tag = "<select";
        foreach ($attributes as $attribute_key => $attribute_value) {
            $output_tag .= " {$attribute_key}='{$attribute_value}'";
        }
        $output_tag .= ">";
        $output_tag .= "<option value=''>すべてのカテゴリー</option>";

        $product_categories = ProductCategory::sort("order_no", "asc")->select(["id", "name", "order_no"])->get();
        foreach ($product_categories as $product_category) {
            $output_tag .= "<option value='{$product_category->id}'";
            if (intval($select_product_category_id) === $product_category->id) {
                $output_tag .= " selected";
            }
            $output_tag .= ">{$product_category->name}</option>";
        }

        $output_tag .= '</select>';
        return $output_tag;
    }
}
