<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\UserStoreRequest;
use App\Http\Requests\Admin\Users\UserUpdateRequest;
use App\Http\Requests\Admin\Users\UserIndexRequest;
use App\Models\User;

class UserController extends Controller
{
    /**
     * @param UserIndexRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(UserIndexRequest $request)
    {
        $builder_user = User::select([
            "id",
            "name",
            "email",
        ]);
        if (filled($request->name())) {
            $builder_user->fuzzyName($request->name());
        }
        if (filled($request->email())) {
            $builder_user->fuzzyEmail($request->email());
        }

        $builder_user->sort($request->sortColumn(), $request->sortDirection());
        $users = $builder_user->paginate($request->pageUnit());
        return view('admin.users.index', compact("users", "request"));
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact("user"));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * @param UserCreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserStoreRequest $request)
    {
        $create_user = User::create($request->validated());
        return redirect()->route("admin.users.show", $create_user->id);
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact("user"));
    }

    /**
     * @param UserEditRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $update_data = $request->validated();
        if ($request->imageDelete()) {
            $update_data["image_path"] = null;
        }
        $user->update($update_data);
        return redirect()->route("admin.users.show", $user->id);
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $user->productReviews()->delete();
        $user->wishProducts()->detach();

        \Storage::delete($user->image_path);
        $user->delete();
        return redirect()->route("admin.users.index");
    }
}
