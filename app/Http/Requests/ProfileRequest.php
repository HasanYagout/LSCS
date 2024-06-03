<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            "name" => ['required', 'string', 'max:255'],
            "mobile" => 'bail|required|min:6|unique:users,mobile,'.auth()->id(),
            "date_of_birth" => 'required|date|before:today',
            "nick_name" =>  'bail|required',
            "blood_group" =>  'bail|nullable',
            "about_me" =>  'bail|nullable',
            "linkedin_url" =>  'bail|nullable|url',
            "facebook_url" =>  'bail|nullable|url',
            "twitter_url" =>  'bail|nullable|url',
            "instagram_url" =>  'bail|nullable|url',
            "company" =>  'bail|nullable',
            "company_designation" =>  'bail|nullable',
            "company_address" =>  'bail|nullable',
            "city" =>  'bail|required|max:195',
            "state" =>  'bail|required|max:195',
            "country" =>  'bail|required|max:195',
            "zip" =>  'bail|required|max:195',
            "address" =>  'bail|required|max:195',
            'image' => 'bail|nullable|mimes:jpg,jpeg,png',
        ];
        return $rules;
    }

}
