<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\AdminUserIndexRequest;
use App\Http\Requests\Admin\AdminUserCreateRequest;
use App\Http\Requests\Admin\AdminUserEditRequest;
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
     * @param AdminUserIndexRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(AdminUserIndexRequest $request)
    {
        //オーナー権限ユーザーのみ利用可
        $page_unit = $request->pageUnit() !== null && ctype_digit($request->pageUnit()) ? $request->pageUnit() : 10;
        $builder_admin_users = AdminUser::select(["id", "name", "email", "is_owner"]);
        if ($request->name() !== null) {
            $builder_admin_users->where("name", "like", "%{$request->name()}%");
        }
        if ($request->email() !== null) {
            $builder_admin_users->where("email", "like", "{$request->email()}%");
        }
        if ($request->authority() !== null) {
            $builder_admin_users->where("is_owner", "=", $request->authority());
        }
        $order_key = null;
        if ($request->sortColumn() !== null) {
            switch ($request->sortColumn()) {
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
        if ($order_key && $request->sortDirection() !== null) {
            $asc_desc = null;
            switch ($request->sortDirection()) {
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
        return view('admin.users_index', compact("admin_users", "request"));
    }

    /**
     * @param AdminUser $admin_user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(AdminUser $admin_user)
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
     * @param AdminUserCreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AdminUserCreateRequest $request)
    {
        $create_admin_user = AdminUser::create([
            "name" => $request->name(),
            "email" => $request->email(),
            "password" => \Hash::make($request->password()),
            "is_owner" => $request->isOwner(),
        ]);

        return redirect()->route("admin.admin_user.show", $create_admin_user->id);
    }

    /**
     * @param AdminUser $admin_user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(AdminUser $admin_user)
    {
        //オーナー権限ユーザーかログインユーザー本人でなければ利用不可
        return view('admin.users_edit', compact("admin_user"));
    }

    /**
     * @param AdminUserEditRequest $request
     * @param AdminUser $admin_user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AdminUserEditRequest $request, AdminUser $admin_user)
    {
        //オーナー権限ユーザーかログインユーザー本人でなければ利用不可
        $updateData = [
            "name" => $request->name(),
            "email" => $request->email(),
        ];

        if ($request->has("password")) {
            $updateData["password"] = \Hash::make($request->password());
        }

        $admin_user->update($updateData);
        return redirect()->route("admin.admin_user.show", $admin_user->id);
    }

    /**
     * @param AdminUser $admin_user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(AdminUser $admin_user)
    {
        //オーナー権限ユーザーで、ログイン中のユーザー以外のユーザーのみ利用可
        $admin_user->delete();
        return redirect()->route("admin.admin_user.index");
    }
}
