<?php

namespace Modules\Share\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class ShareStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if(Auth::check())
        {

        $rules = [

            'name' => 'required|string',
          //  'Inspired_by' => 'required|string',
            'description' => 'required|string',
            'thumbnails' => 'required|array',
            'thumbnails.*' => 'required|file|mimes:jpg,jpeg,png,bmp|max:2000',
            
            ];
        }
        else
        {
        
        $rules = [
          //  'Inspired_by' => 'required|string',
            'name' => 'required|string',
            'description' => 'required|string',
            'thumbnails' => 'required|array',
            'thumbnails.*' => 'required|file|mimes:jpg,jpeg,png,bmp|max:2000',
            'non_member_name' => 'required|string',
            'age' => 'required|numeric|min:1|max:100',
            
            ];
        
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
