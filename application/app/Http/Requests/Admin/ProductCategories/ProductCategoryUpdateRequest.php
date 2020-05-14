<?php

namespace App\Http\Requests\Admin\ProductCategories;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryUpdateRequest extends FormRequest
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
            "name.required" => "カテゴリー名は必須です。",
            "name.max" => "カテゴリー名は255文字以内です。",
            "order_no.required" => "並び順番号は必須です。",
        ];
    }
}
