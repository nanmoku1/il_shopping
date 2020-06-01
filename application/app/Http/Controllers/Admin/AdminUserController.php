<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminUsers\AdminUserIndexRequest;
use App\Http\Requests\Admin\AdminUsers\AdminUserStoreRequest;
use App\Http\Requests\Admin\AdminUsers\AdminUserUpdateRequest;
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
        $admin_user = AdminUser::select([
            "id",
            "name",
            "email",
            "is_owner",
        ]);
        if (filled($request->name())) {
            $admin_user->fuzzyName($request->name());
        }
        if (filled($request->email())) {
            $admin_user->forwardMatchEmail($request->email());
        }
        if (filled($request->authority())) {
            $admin_user->whereIsOwner($request->authority());
        }
        $admin_user->sort($request->sortColumn(), $request->sortDirection());
        $admin_users = $admin_user->paginate($request->pageUnit());
        return view('admin.admin_users.index', compact("admin_users"));
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
     * @param AdminUserStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AdminUserStoreRequest $request)
    {
        $admin_user = AdminUser::create($request->validated());
        return redirect()->route("admin.admin_users.show", $admin_user->id);
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
     * @param AdminUserUpdateRequest $request
     * @param AdminUser $admin_user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AdminUserUpdateRequest $request, AdminUser $admin_user)
    {
        $admin_user->update($request->validated());
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
