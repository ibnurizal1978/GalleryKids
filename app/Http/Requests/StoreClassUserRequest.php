<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassUserRequest extends FormRequest
{
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        
        'register_type' => 'required|alpha|in:class',
        'first_name' => 'required|string',
        'last_name' => 'required|alpha',
        'email' => 'required|email',
        'username' => 'required|string',
        'designation' => 'required|string',
        'password' => 'required|min:8|confirmed',
        'school' => 'required|string',
        'level' => 'required|string',
        'class' => 'required|string',
        'team' => 'required|string',
        'form' => 'required|file|mimes:csv,xlsx,xls|max:2000',

        ];
    }
}
