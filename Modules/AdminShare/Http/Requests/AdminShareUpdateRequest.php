<?php


namespace Modules\AdminShare\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminShareUpdateRequest extends FormRequest
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
            'title'          => [ 'required', 'string', 'max:255' ],
            'image'          => [ 'nullable', 'image', 'max:20480' ], // max:20mb
            'artist'         => [ 'nullable', 'string', 'max:255' ],
            'created'        => [ 'nullable', 'string', 'max:255' ],
            'classification' => [ 'nullable', 'string', 'max:255' ],
            'dimension'      => [ 'nullable', 'string', 'max:255' ],
            'creditline'     => [ 'nullable', 'string', 'max:255' ],
            'category_id'    => [ 'nullable', 'numeric', Rule::exists( 'categories', 'id' ) ]
        ];
    }
}
