<?php

namespace App\Http\Requests\Admin;

use App\Rules\UniqueWithConditions;
use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
        $id=!is_null($this->id)?$this->id : null;
        $rules = [
            'title' => [
                'bail',
                'required',
                new UniqueWithConditions('news', 'title', $this->id, 'id', ['tenant_id' => getTenantId()])
            ],
            'category_id' => 'required',
//            'tag_ids.0' => 'required',
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
