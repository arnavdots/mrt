<?php

namespace Modules\Branch\Http\Requests;

use Illuminate\Http\Request;
use Modules\Branch\Http\Requests\BranchRequest as BranchRequest;
use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:50',
            'branch_code' => 'required|unique:branches,branch_code,'. $this->id,
            'address_line_1' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'suburb_id' => 'required',
            'postcode' => 'required',
            'branch_ip' => 'required|unique:branches,branch_ip,'. $this->id
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
