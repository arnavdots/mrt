<?php

namespace Modules\User\Http\Requests;

use Illuminate\Http\Request;
use Modules\User\Http\Requests\UserRequest as UserRequest;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|min:2|max:50',
            'last_name' => 'min:1|max:50',
            'email' => 'required|min:5|max:50|unique:users,email,'. $this->id,
            'mobile' => 'mobile'
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
    
    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
