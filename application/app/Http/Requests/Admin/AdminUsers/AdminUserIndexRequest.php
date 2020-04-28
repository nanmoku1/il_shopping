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
     * @return mixed
     */
    public function authority()
    {
        return $this->input('authority');
    }

    /**
     * @return mixed
     */
    public function sortColumn()
    {
        return $this->input('sort_column');
    }

    /**
     * @return mixed
     */
    public function sortDirection()
    {
        return $this->input('sort_direction');
    }

    /**
     * @return mixed
     */
    public function pageUnit()
    {
        return $this->input('page_unit');
    }
}
