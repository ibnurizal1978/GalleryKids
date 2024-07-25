<?php

namespace Modules\Create\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

        'title' => 'required|string',
        'synopsis' => 'required|string',
        'url' => 'required|url',
        'content_start_date' => 'nullable|date',
        'content_expiry_date' => 'nullable|date|after:content_start_date',
        'members_only' => 'nullable|in:Yes',
        'age_groups' => 'required|array',
        'age_groups.*' => 'required|numeric',
        'category_id' => 'required|numeric|exists:categories,id',
        'thumbnails' => 'required|array',
        'thumbnails.*' => 'required|file|mimes:jpg,jpeg,png,bmp|max:2000',
            
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
