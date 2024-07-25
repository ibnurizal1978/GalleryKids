<?php

namespace Modules\Event\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventStoreRequest extends FormRequest
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
            'date' => 'required|date',
            'type' => 'required|string|in:Physical,Digital',
            'location' => 'required|string',
            'thumbnail' => 'required|file|mimes:jpg,jpeg,png,bmp|max:2000',
                 
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
