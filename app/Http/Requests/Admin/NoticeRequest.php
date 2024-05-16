<?php

namespace App\Http\Requests\Admin;

use App\Rules\UniqueWithConditions;
use Illuminate\Foundation\Http\FormRequest;

class NoticeRequest extends FormRequest
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
            'title' => [
                'bail',
                'required',
                new UniqueWithConditions('notices', 'title', $this->id, 'id', ['tenant_id' => getTenantId()])
            ],
            'category_id' => 'required',
            'details' => 'required',
        ];

        if($this->id){
            $rules['image'] = 'bail|nullable|mimes:jpg,jpeg,png';
        }
        else{
            $rules['image'] = 'bail|required|mimes:jpg,jpeg,png';
        }
        return $rules;
    }
}
