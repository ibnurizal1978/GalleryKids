<?php

namespace Modules\Question\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class QuestionStoreRequest extends FormRequest
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

            'question' => 'required|string',
//            'file' => 'required|file|mimes:jpg,jpeg,png,bmp|max:2000',
            
            ];
        }
        else
        {
        
        $rules = [

            'question' => 'required|string',
//            'file' => 'required|file|mimes:jpg,jpeg,png,bmp|max:2000',
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
