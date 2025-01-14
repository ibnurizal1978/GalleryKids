<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GEMembershipUpgradeRequest extends FormRequest
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
            'gender'           => [ 'required', Rule::in( [ 'M', 'F' ] ) ],
            'mobile'           => [ 'required' ],
            'country'          => [ 'required' ],
            'dob'              => [ 'required' ],
            'kids'             => [ 'array', 'required' ],
            'kids.*.firstname' => [ 'required' ],
            'kids.*.lastname'  => [ 'required' ],
            'kids.*.dob'       => [ 'required' ],
        ];
    }
}
