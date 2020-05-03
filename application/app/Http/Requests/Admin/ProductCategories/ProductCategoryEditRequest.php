<?php

namespace App\Http\Requests\Admin\ProductCategories;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryEditRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required|string|max:255",
            "order_no" => "required|integer",
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages()
    {
        return [
            "name.required" => "ログイン名は必須です。",
            "name.max" => "名前は255文字以内です。",
            "order_no.required" => "並び順番号は必須です。",
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
    public function orderNo()
    {
        return $this->input('order_no');
    }
}
