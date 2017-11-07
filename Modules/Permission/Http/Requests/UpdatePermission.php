<?php

namespace Modules\Permission\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermission extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('permission')->id;
        return [
            'name' => [
                'required',
                Rule::unique('permissions')->where('id', '<>', $id),
            ],
            'display_name' => 'required',
            'description' => 'required',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
