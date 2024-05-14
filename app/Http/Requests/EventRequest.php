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
        $rules = [
            'event_category_id' =>  ['required', Rule::exists('event_categories', 'id')],
            'title' => 'bail|required|string|min:3|max:155',
            'date' => 'bail|required|date|after_or_equal:today',
            'type' => 'required',
            'location' => 'required',
            'number_of_ticket' => 'bail|required|numeric',
            'description' => 'bail|required|string|min:11',
        ];

        if($this->input('type') == EVENT_TYPE_PAID){
            $rules['price'] = 'bail|required|numeric|min:1';
        }

        if($this->slug){
            $rules['thumbnail'] = 'bail|nullable|mimes:jpg,jpeg,png';
            $rules['ticket_image'] = 'bail|nullable|mimes:jpg,jpeg,png';
        }
        else{
            $rules['thumbnail'] = 'bail|required|mimes:jpg,jpeg,png';
            $rules['ticket_image'] = 'bail|required|mimes:jpg,jpeg,png';
        }

        return $rules;
    }
}
