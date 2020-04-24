<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminUser;

class AdminUserController extends Controller
{
    /**
     * AdminUserController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(AdminUser::class, "admin_user");
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //オーナー権限ユーザーのみ利用可
        $parameter = $request->all();
        $page_unit = isset($parameter["page_unit"]) && ctype_digit($parameter["page_unit"]) ? $parameter["page_unit"] : 10;
        $builder_admin_users = AdminUser::select(["id", "name", "email", "is_owner"]);
        if (isset($parameter["name"])) {
            $builder_admin_users->where("name", "like", "%{$parameter['name']}%");
        }
        if (isset($parameter["email"])) {
            $builder_admin_users->where("email", "like", "{$parameter['email']}%");
        }
        if (isset($parameter["authority"])) {
            $builder_admin_users->where("is_owner", "=", $parameter["authority"]);
        }
        $order_key = null;
        if (isset($parameter["sort_column"])) {
            switch ($parameter["sort_column"]) {
                case "id":
                    $order_key = "id";
                    break;
                case "name":
                    $order_key = "name";
                    break;
                case "email":
                    $order_key = "email";
                    break;
            }
        }
        if ($order_key && isset($parameter["sort_direction"])) {
            $asc_desc = null;
            switch ($parameter["sort_direction"]) {
                case "asc":
                    $asc_desc = "ASC";
                    break;
                case "desc":
                    $asc_desc = "DESC";
                    break;
            }

            if ($asc_desc) {
                $builder_admin_users->orderBy($order_key, $asc_desc);
            }
        }

        $admin_users = $builder_admin_users->paginate($page_unit);
        return view('admin.users_index', compact("admin_users", "parameter"));
    }

    /**
     * @param Request $request
     * @param AdminUser $admin_user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, AdminUser $admin_user)
    {
        //オーナー権限ユーザーかログインユーザー本人でなければ利用不可
        return view('admin.users_show', compact("admin_user"));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        //オーナー権限ユーザーのみ利用可
        return view('admin.users_create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        //オーナー権限ユーザーのみ利用可
        $vali = \Validator::make($request->all(),
            [
                "name" => "required|string|max:255"
                ,
                "email" => [
                    "required",
                    "string",
                    "email",
                    "max:255",
                    function ($attribute, $value, $fail) {
                        $admin_user = AdminUser::select(["id"])->where("email", "=", $value)->first();
                        if ($admin_user) {
                            return $fail("既に登録されているメールアドレスです。");
                        }
                    },
                ],
                "password" => "required|min:4|regex:/^[0-9a-zA-Z\\-\\_]+$/|same:password_confirmation",
            ],
            [
                "name.required" => "ログイン名は必須です。",
                "name.max" => "名前は255文字以内です。",
                "email.required" => "メールアドレスは必須です。",
                "email.email" => "メールアドレスの形式が不正です。",
                "email.max" => "メールアドレスは255文字以内です。",
                "password.required" => "パスワードは必須です。",
                "password.min" => "パスワードが4文字以下です。",
                "password.regex" => "パスワードにアルファベット、数字、アンダーバー、ハイフン以外の文字があります。",
                "password.same" => "パスワードが確認と一致していません。",
            ]
        );

        if ($vali->fails()) {
            return redirect()->route("admin.admin_user.create")->withErrors($vali->errors())->withInput();
        }

        $create_admin_user = AdminUser::create([
            "name" => $request->input("name"),
            "email" => $request->input("email"),
            "password" => \Hash::make($request->input("password")),
            "is_owner" => $request->input("is_owner"),
        ]);

        return redirect()->route("admin.admin_user.show", $create_admin_user->id);
    }

    /**
     * @param Request $request
     * @param AdminUser $admin_user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, AdminUser $admin_user)
    {
        //オーナー権限ユーザーかログインユーザー本人でなければ利用不可
        return view('admin.users_edit', compact("admin_user"));
    }

    /**
     * @param Request $request
     * @param AdminUser $admin_user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, AdminUser $admin_user)
    {
        //オーナー権限ユーザーかログインユーザー本人でなければ利用不可
        $updateData = [
            "name" => $request->input("name"),
            "email" => $request->input("email"),
        ];
        $valiRole = [
            "name" => "required|string|max:255",
            "email" => [
                "required",
                "string",
                "email",
                "max:255",
                function ($attribute, $value, $fail) use ($admin_user) {
                    $au = AdminUser::select(["id"])
                        ->where("email", "=", $value)->where("id", "!=", $admin_user->id)
                        ->first();
                    if ($au) {
                        return $fail("既に登録されているメールアドレスです。");
                    }
                },
            ]
        ];
        if ($request->has("password") && strlen($request->input("password")) > 0) {
            $updateData["password"] = \Hash::make($request->input("password"));
            $valiRole["password"] = "min:4|regex:/^[0-9a-zA-Z\\-\\_]+$/|same:password_confirmation";
        }
        $vali = \Validator::make($request->all(),
            $valiRole,
            [
                "name.required" => "ログイン名は必須です。",
                "name.max" => "名前は255文字以内です。",
                "email.required" => "メールアドレスは必須です。",
                "email.email" => "メールアドレスの形式が不正です。",
                "email.max" => "メールアドレスは255文字以内です。",
                "password.min" => "パスワードが4文字以下です。",
                "password.regex" => "パスワードにアルファベット、数字、アンダーバー、ハイフン以外の文字があります。",
                "password.same" => "パスワードが確認と一致していません。",
            ]
        );

        if ($vali->fails()) {
            return redirect()->route("admin.admin_user.edit",
                $admin_user->id)->withErrors($vali->errors())->withInput();
        }

        AdminUser::where("id", "=", $admin_user->id)->update($updateData);
        return redirect()->route("admin.admin_user.show", $admin_user->id);
    }

    /**
     * @param Request $request
     * @param AdminUser $admin_user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Request $request, AdminUser $admin_user)
    {
        //オーナー権限ユーザーで、ログイン中のユーザー以外のユーザーのみ利用可
        $admin_user->delete();
        return redirect()->route("admin.admin_user.index");
    }
}
