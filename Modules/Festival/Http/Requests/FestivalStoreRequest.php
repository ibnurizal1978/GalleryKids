<?php

namespace Modules\Festival\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FestivalStoreRequest extends FormRequest
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
        'content_expiry_date' => 'nullable|date',
        'members_only' => 'nullable|in:Yes',
        'targeted_age_group' => 'required|in:Younger than 10,10 to 15,Older than 15',
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
