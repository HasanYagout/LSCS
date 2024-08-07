<?php

namespace App\Http\Requests\company;

use Illuminate\Foundation\Http\FormRequest;

class CreateJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'employee_status' => 'required',
            'location' => 'required',
            'application_deadline' => 'bail|required|date|after_or_equal:today',
            'post_link' => 'required',
            'job_context' => 'required',
            'job_responsibility' => 'required',
            'educational_requirements' => 'required',
        ];
    }
}
