<?php

namespace App\Http\Requests\Users;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            "name" => "required|string|max:255",
            "email" => [
                "required",
                "string",
                "email",
                "max:255",
                Rule::unique(User::class)->ignore($this->user),
            ],
            "password" => "nullable|min:4|alpha_dash|confirmed",
            "image_path" => "nullable|image",
            "image_delete" => "nullable|boolean",
        ];
        return $rules;
    }

    /**
     * @return array|string[]
     */
    public function messages()
    {
        return [
            "name.required" => "ログイン名は必須です。",
            "name.max" => "名前は255文字以内です。",
            "email.required" => "メールアドレスは必須です。",
            "email.email" => "メールアドレスの形式が不正です。",
            "email.max" => "メールアドレスは255文字以内です。",
            "email.unique" => "既に登録されているメールアドレスです。",
            "password.min" => "パスワードが4文字以下です。",
            "password.confirmed" => "パスワードが確認と一致していません。",
            "image_path.image" => "イメージは画像ファイルをアップロードしてください。",
        ];
    }

    /**
     * @return bool
     */
    public function imageDelete()
    {
        return !empty($this->input('image_delete'));
    }
}
