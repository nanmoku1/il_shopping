<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminUser;

class AdminUsersController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $loginUser = Auth::guard('admin')->user();
        if(!$loginUser->is_owner) return \App::abort(403);

        $para = $request->all();
        $pageUnit = isset($para["page_unit"]) && ctype_digit($para["page_unit"]) ? $para["page_unit"]:10;
        $bldAdminUsers = AdminUser::select(["id", "name", "email", "is_owner"]);
        if(isset($para["name"])) $bldAdminUsers->where("name", "like", "%{$para['name']}%");
        if(isset($para["email"])) $bldAdminUsers->where("email", "like", "{$para['email']}%");
        if(isset($para["authority"])) $bldAdminUsers->where("is_owner", "=", $para["authority"]);
        $orderKey = null;
        if(isset($para["sort_column"])){
            switch($para["sort_column"]){
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
        if($orderKey && isset($para["sort_direction"])){
            $ad = null;
            switch($para["sort_direction"]){
                case "asc":
                    $ad = "ASC";
                    break;
                case "desc":
                    $ad = "DESC";
                    break;
            }

            if($ad) $bldAdminUsers->orderBy($orderKey, $ad);
        }

        $adminUsers = $bldAdminUsers->paginate($pageUnit);
        return view('admin.users_list', compact("adminUsers", "para"));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request, $id)
    {
        $loginUser = Auth::guard('admin')->user();
        $adminUser = AdminUser::select(["id", "name", "email", "is_owner"])->where("id", "=", $id)->first();

        //オーナーかログインユーザー本人でなければ閲覧不可
        if( !$loginUser->is_owner
            && (!$adminUser || $loginUser->id !== $adminUser->id) )
        {
            return \App::abort(403);
        }

        return view('admin.users_detail', compact("adminUser"));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, $id)
    {
        $loginUser = Auth::guard('admin')->user();
        $adminUser = AdminUser::select(["id", "name", "email", "is_owner"])->where("id", "=", $id)->first();

        if(!$loginUser->is_owner || !$adminUser || $loginUser->id === $adminUser->id)
        {
            return \App::abort(403);
        }

        AdminUser::where("id", "=", $id)->delete();
        return redirect()->route("admin.admin_users_list");
    }
}
