<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobPostRequest extends FormRequest
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
            'title' => 'bail|required|string|min:3|max:100',
            'compensation_n_benefits' => 'required',
            'salary' => 'required',
            'location' => 'bail|required|string',
            'post_link' => 'bail|required|url',
            'application_deadline' => 'bail|required|date|after_or_equal:today',
            'job_context' => 'bail|required|string',
            'job_responsibility' => 'bail|required|string',
            'educational_requirements' => 'bail|required|string',
            'employee_status' => 'bail|required|numeric',
        ];
        if(isset($this['slug'])){
            $rules['company_logo'] = 'bail|nullable|mimes:jpg,jpeg,png';
        }
        else{
            $rules['company_logo'] = 'bail|required|mimes:jpg,jpeg,png';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'compensation_n_benefits' => 'Compensation & Benefits field is required.',
        ];
    }
}
