<?php

namespace Modules\Share\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShareUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

        'name' => 'required|string',
        'description' => 'required|string',
//        'hashtags' => 'required|string',
        'thumbnails' => 'nullable|array',
        'thumbnails.*' => 'nullable|file|mimes:jpg,jpeg,png,bmp',
            
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
