<?php

namespace Modules\Gallery\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'product_code' => 'required|min:2'
        ];
        $photos = count($this->input('image'));
        foreach(range(0, $photos) as $index) {
            $rules['image.' . $index] = 'required|image|mimes:jpeg,jpg,bmp,png|max:2000';
        }
 
        return $rules;
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
