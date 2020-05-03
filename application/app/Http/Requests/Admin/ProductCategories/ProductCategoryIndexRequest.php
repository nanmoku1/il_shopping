<?php

namespace App\Http\Requests\Admin\ProductCategories;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryIndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "sort_column" => "in:id,name,email",
            "sort_direction" => "in:asc,desc",
            "page_unit" => "integer",
        ];
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
