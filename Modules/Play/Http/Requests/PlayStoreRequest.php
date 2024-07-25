<?php

namespace Modules\Play\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlayStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'title' => 'required|string',
            'synopsis' => 'required|string',
            'url' => 'required|url',
            'age_groups' => 'required|array',
            'age_groups.*' => 'required|numeric',
            'thumbnail' => 'required|file|mimes:jpg,jpeg,png,bmp|max:2000',
                 
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
