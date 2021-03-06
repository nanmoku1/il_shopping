<?php

namespace App\Http\Requests\Admin\AdminUsers;

use App\Models\AdminUser;
use Illuminate\Foundation\Http\FormRequest;

class AdminUserStoreRequest extends FormRequest
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
            "email" => "required|string|email|max:255|unique:admin_users",
            "password" => "required|min:4|alpha_dash|confirmed",
            "is_owner" => "required|boolean",
        ];
    }

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
        ];
    }
}
