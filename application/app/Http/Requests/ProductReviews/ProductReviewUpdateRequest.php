<?php

namespace App\Http\Requests\ProductReviews;

use Illuminate\Foundation\Http\FormRequest;

class ProductReviewUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "title" => "required|string|max:255",
            "body" => "required|string|max:255",
            "rank" => "required|integer|min:1|max:5",
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages()
    {
        return [
            "title.required" => "タイトルは必須です。",
            "title.max" => "タイトルは255文字以内です。",
            "body.required" => "本文は必須です。",
            "body.max" => "本文は255文字以内です。",
            "rank.required" => "評価は必須です。",
            "rank.max" => "評価は1〜5の範囲で入力してください。",
        ];
    }
}
