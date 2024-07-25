<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFamilyUserRequest extends FormRequest
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

            'register_type' => 'required|in:family',
            'terms_and_conditions' => 'required|in:accepted',
            'privacy_policy' => 'required|alpha|in:accepted',
            'parent.*.first_name' => 'required|string',
            'parent.*.last_name' => 'required|string',
            'parent.0.email' => 'required|email|unique:users,email',
            'parent.*.username' => 'required|unique:users,username',
            'parent.*.password' => 'required|min:8', 
            'children.*.first_name' => 'required|string',
            'children.*.last_name' => 'required|string', 
            'children.*.year_of_birth' => 'required|numeric|min:1900|max:'.(date('Y') - 1),
            'children.*.username' => 'required|unique:users,username',
            'children.*.password' => 'required|min:8',
         
        ];
    }
}
