<?php

namespace App\Http\Requests\Admin\AdminUsers;

use App\Models\AdminUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminUserEditRequest extends FormRequest
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
                Rule::unique(AdminUser::class)->ignore($this->admin_user),
            ],
        ];
        if ($this->filled("password") && strlen($this->password()) > 0) {
            $rules["password"] = "min:4|regex:/^[0-9a-zA-Z\\-\\_]+$/|same:password_confirmation";
        }
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
            "password.regex" => "パスワードにアルファベット、数字、アンダーバー、ハイフン以外の文字があります。",
            "password.same" => "パスワードが確認と一致していません。",
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
    public function email()
    {
        return $this->input('email');
    }

    /**
     * @return mixed
     */
    public function password()
    {
        return $this->input('password');
    }

    /**
     * @return mixed
     */
    public function isOwner()
    {
        return $this->input('is_owner');
    }
}
