<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KCAESpaceSlideStoreRequest extends FormRequest
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
            'name'        => [ 'required', 'max:256' ],
            'description' => [ 'required' ],
            'image'       => [ 'required', 'image' ],
            'space_id'    => [ 'required', Rule::exists( 'kcae_spaces', 'id' ) ],
        ];
    }
}
