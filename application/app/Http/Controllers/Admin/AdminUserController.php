<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\AdminUsers\AdminUserIndexRequest;
use App\Http\Requests\Admin\AdminUsers\AdminUserCreateRequest;
use App\Http\Requests\Admin\AdminUsers\AdminUserEditRequest;
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
        $page_unit = $request->pageUnit() !== null && ctype_digit($request->pageUnit()) ? $request->pageUnit() : 10;
        $admin_users = AdminUser::listSearch([
            "name" => $request->name(),
            "email" => $request->email(),
            "is_owner" => $request->authority(),
            "order_key" => $request->sortColumn(),
            "asc_desc" => $request->sortDirection(),
        ])
            ->select([
                "id",
                "name",
                "email",
                "is_owner",
            ])
            ->paginate($page_unit);

        return view('admin.admin_users.index', compact("admin_users", "request"));
    }

    /**
     * @param AdminUser $admin_user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(AdminUser $admin_user)
    {
        return view('admin.admin_users.show', compact("admin_user"));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.admin_users.create');
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

        return redirect()->route("admin.admin_users.show", $create_admin_user->id);
    }

    /**
     * @param AdminUser $admin_user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(AdminUser $admin_user)
    {
        return view('admin.admin_users.edit', compact("admin_user"));
    }

    /**
     * @param AdminUserEditRequest $request
     * @param AdminUser $admin_user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AdminUserEditRequest $request, AdminUser $admin_user)
    {
        $updateData = [
            "name" => $request->name(),
            "email" => $request->email(),
        ];

        if ($request->has("password")) {
            $updateData["password"] = \Hash::make($request->password());
        }

        $admin_user->update($updateData);
        return redirect()->route("admin.admin_users.show", $admin_user->id);
    }

    /**
     * @param AdminUser $admin_user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(AdminUser $admin_user)
    {
        $admin_user->delete();
        return redirect()->route("admin.admin_users.index");
    }
}
