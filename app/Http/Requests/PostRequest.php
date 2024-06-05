<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
        $allowedExtensions = ['png', 'jpg', 'svg', 'jpeg', 'gif', 'mp4', 'mov', 'avi', 'mkv', 'webm', 'flv'];

        $rules = [
            'body' => 'bail|required|string|min:2',
            'file.*' => [
                'bail',
                'nullable',
                'mimes:' . implode(',', $allowedExtensions),
            ],
        ];

        return $rules;
    }

}
