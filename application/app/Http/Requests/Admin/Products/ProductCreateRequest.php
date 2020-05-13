<?php

namespace App\Http\Requests\Admin\Products;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "product_category_id" => "required|exists:product_categories,id",
            "price" => "required|integer|min:0",
            "name" => "required|string|max:255",
            "description" => "nullable",
            "image_path" => "nullable|image",
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages()
    {
        return [
            "product_category_id.required" => "カテゴリーは必須です。",
            "product_category_id.exists" => "存在しないカテゴリーです。",
            "price.required" => "価格は必須です。",
            "price.integer" => "価格は数値で入力してください。",
            "price.min" => "価格は0円以上で入力してください。",
            "name.required" => "名称は必須です",
            "name.max" => "名前は255文字以内です。",
            "image_path.image" => "イメージは画像ファイルをアップロードしてください。",
        ];
    }
}
