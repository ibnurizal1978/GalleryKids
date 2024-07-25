<?php

namespace App\Http\Requests\Admin;

use App\Models\KcaeSpacesCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KCAESpacesCategoryStoreRequest extends FormRequest
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
            'name'   => [ 'required', Rule::unique( ( new KcaeSpacesCategory() )->getTable() ) ],
            'serial' => [ 'required', 'int', 'min:1' ],
            'status' => [ 'required', Rule::in( [ 'enabled', 'disabled' ] ) ],
        ];
    }
}
