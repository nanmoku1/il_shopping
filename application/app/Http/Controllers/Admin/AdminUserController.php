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
        $this->authorizeResource(AdminUser::class, "adminUser");
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //オーナー権限ユーザーのみ利用可
        $para = $request->all();
        $pageUnit = isset($para["page_unit"]) && ctype_digit($para["page_unit"]) ? $para["page_unit"] : 10;
        $bldAdminUsers = AdminUser::select(["id", "name", "email", "is_owner"]);
        if (isset($para["name"])) {
            $bldAdminUsers->where("name", "like", "%{$para['name']}%");
        }
        if (isset($para["email"])) {
            $bldAdminUsers->where("email", "like", "{$para['email']}%");
        }
        if (isset($para["authority"])) {
            $bldAdminUsers->where("is_owner", "=", $para["authority"]);
        }
        $orderKey = null;
        if (isset($para["sort_column"])) {
            switch ($para["sort_column"]) {
                case "id":
                    $orderKey = "id";
                    break;
                case "name":
                    $orderKey = "name";
                    break;
                case "email":
                    $orderKey = "email";
                    break;
            }
        }
        if ($orderKey && isset($para["sort_direction"])) {
            $ad = null;
            switch ($para["sort_direction"]) {
                case "asc":
                    $ad = "ASC";
                    break;
                case "desc":
                    $ad = "DESC";
                    break;
            }

            if ($ad) {
                $bldAdminUsers->orderBy($orderKey, $ad);
            }
        }

        $adminUsers = $bldAdminUsers->paginate($pageUnit);
        return view('admin.users_index', compact("adminUsers", "para"));
    }

    /**
     * @param Request $request
     * @param AdminUser $adminUser
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, AdminUser $adminUser)
    {
        //オーナー権限ユーザーかログインユーザー本人でなければ利用不可
        return view('admin.users_show', compact("adminUser"));
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
                        $au = AdminUser::select(["id"])->where("email", "=", $value)->first();
                        if ($au) {
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
            return redirect()->route("admin.admin_users_create")->withErrors($vali->errors())->withInput();
        }

        $cAU = AdminUser::create([
            "name" => $request->input("name"),
            "email" => $request->input("email"),
            "password" => \Hash::make($request->input("password")),
            "is_owner" => $request->input("is_owner"),
        ]);

        return redirect()->route("admin.admin_users_show", $cAU->id);
    }

    /**
     * @param Request $request
     * @param AdminUser $adminUser
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, AdminUser $adminUser)
    {
        //オーナー権限ユーザーかログインユーザー本人でなければ利用不可
        return view('admin.users_edit', compact("adminUser"));
    }

    /**
     * @param Request $request
     * @param AdminUser $adminUser
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, AdminUser $adminUser)
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
                function ($attribute, $value, $fail) use ($adminUser) {
                    $au = AdminUser::select(["id"])
                        ->where("email", "=", $value)->where("id", "!=", $adminUser->id)
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
            return redirect()->route("admin.admin_users_edit",
                $adminUser->id)->withErrors($vali->errors())->withInput();
        }

        AdminUser::where("id", "=", $adminUser->id)->update($updateData);
        return redirect()->route("admin.admin_users_show", $adminUser->id);
    }

    /**
     * @param Request $request
     * @param AdminUser $adminUser
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Request $request, AdminUser $adminUser)
    {
        //オーナー権限ユーザーで、ログイン中のユーザー以外のユーザーのみ利用可
        $adminUser->delete();
        return redirect()->route("admin.admin_users_index");
    }
}
