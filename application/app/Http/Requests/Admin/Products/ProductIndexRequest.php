<?php

namespace App\Http\Requests\Admin\Products;

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
            "price" => "nullable|integer",
            "price_compare" => "string",
            "sort_column" => "in:id,product_category,name,price",
            "sort_direction" => "in:asc,desc",
            "page_unit" => "integer",
        ];
    }

    /**
     * @return mixed
     */
    public function price()
    {
        return $this->input('price');
    }

    /**
     * @return mixed
     */
    public function priceCompare()
    {
        return $this->input('price_compare');
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
    public function name()
    {
        return $this->input('name');
    }

    /**
     * @return mixed
     */
    public function sortColumn()
    {
        return $this->input('sort_column', 'id');
    }

    /**
     * @return mixed
     */
    public function sortDirection()
    {
        return $this->input('sort_direction', 'asc');
    }

    /**
     * @return mixed
     */
    public function pageUnit()
    {
        return $this->input('page_unit', 10);
    }
}
