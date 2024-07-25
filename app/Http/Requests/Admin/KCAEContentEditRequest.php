<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class KCAEContentEditRequest extends FormRequest
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
            'title'               => [ 'required', 'string' ],
            'description'         => [ 'nullable' ],
            'hero_slider_title'   => [ 'nullable' ],
            'mid-section'         => [ 'nullable' ],
            'last-section-top'    => [ 'nullable' ],
            'last-section-box1'   => [ 'nullable' ],
            'last-section-box2'   => [ 'nullable' ],
            'last-section-box3'   => [ 'nullable' ],
            'last-section-bottom' => [ 'nullable' ],
        ];
    }
}
