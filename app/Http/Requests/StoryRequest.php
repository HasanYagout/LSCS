<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoryRequest extends FormRequest
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
            'title' => ['required','string', 'min:3', 'max:155'],
            'body' => 'required|string',
        ];

        if($this->slug){
            $rules['thumbnail'] = 'bail|nullable|mimes:jpg,jpeg,png';
        }
        else{
            $rules['thumbnail'] = 'bail|required|mimes:jpg,jpeg,png';
        }

        return $rules;
    }
}
