<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\UserUpdateRequest;
use App\Models\User;

class UserController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(User::class, "user");
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * @param UserUpdateRequest $request
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
        return redirect()->route("home");
    }
}
