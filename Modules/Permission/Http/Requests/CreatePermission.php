<?php namespace Modules\Permission\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePermission extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /*
          return [
          'name' => 'required|unique:permissions',
          'display_name' => 'required',
          'description' => 'required',
          ];

         */

        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                    return [];
                }
            case 'POST': {
                    return [
                        'name' => 'required|unique:permissions'
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'name' => 'required|unique:permissions,name,'.$this->get('id')
                    ];
                }
            default:break;
        }
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
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
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
