<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class ProductIndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * @return mixed
     */
    public function productCategoryId()
    {
        return $this->input('product_category_id');
    }

    /**
     * @return mixed
     */
    public function keyword()
    {
        return $this->input('keyword');
    }

    /**
     * @return false|string[]
     */
    public function sort()
    {
        $sort_conditions = explode('-', $this->input('sort', 'review_rank-desc'));
        return [
            "column" => filled($sort_conditions[0]) ? $sort_conditions[0] : "",
            "direction" => filled($sort_conditions[1]) ? $sort_conditions[1] : "",
        ];
    }
}
