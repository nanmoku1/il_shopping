<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\UserCreateRequest;
use App\Http\Requests\Admin\Users\UserEditRequest;
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
        logger(\App\DebugFunc::dumpStr(\Storage::disk()->exists('user_images/kS4Lb4tBgkiH60pXh8enxVZ834cEBwYvstpNWgP0.png')));
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
    public function store(UserCreateRequest $request)
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
    public function update(UserEditRequest $request, User $user)
    {
        $old_image_path = $user->image_path;
        $update_data = $request->validated();
        if ($request->imageDel()) {
            $update_data["image_path"] = null;
        }
        if ($user->update($update_data) && $old_image_path !== $user->image_path
            && filled($old_image_path) && \Storage::exists($old_image_path)) {
            \Storage::delete($old_image_path);
        }
        return redirect()->route("admin.users.show", $user->id);
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $old_image_path = $user->image_path;
        if ($user->delete() && filled($old_image_path) && \Storage::exists($old_image_path)) {
            \Storage::delete($old_image_path);
        }
        return redirect()->route("admin.users.index");
    }
}
