<?php

namespace App\Http\Requests\Admin\AdminUsers;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\AdminUser;

class AdminUserIndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "authority" => "nullable|in:owner,general,all",
            "sort_column" => "in:id,name,email",
            "sort_direction" => "in:asc,desc",
            "page_unit" => "integer",
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
     * @return bool
     */
    public function authority()
    {
        switch ($this->input('authority')) {
            case "owner":
                return true;
                break;
            case "general":
                return false;
                break;
            case "all":
            default:
                return null;
        }
        //null,空白→すべての権限
        return filled($this->input('authority')) ? !empty($this->input('authority')):null;
    }

    /**
     * @return mixed
     */
    public function sortColumn()
    {
        return $this->input('sort_column', 'id');
    }

    /**
     * @return mixed
     */
    public function sortDirection()
    {
        return $this->input('sort_direction', 'asc');
    }

    /**
     * @return mixed
     */
    public function pageUnit()
    {
        return $this->input('page_unit', 10);
    }
}
