<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class EventRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'event_category_id' =>  'required|exists:event_categories,id',
            'title' => 'bail|required|string|min:3|max:155',
            'date' => 'bail|required|date|after_or_equal:today',
            'description' => 'bail|required|string|min:11',
            'thumbnail' => 'image',
            ];
    }
}
