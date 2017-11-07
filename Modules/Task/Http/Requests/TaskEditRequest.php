<?php

namespace Modules\Task\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskEditRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
           'receiver_id' => 'required',
           'priority' => 'required',
           'is_public' => 'required'
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
