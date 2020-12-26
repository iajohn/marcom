<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
   

class UserImageUploadRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
       throw new HttpResponseException(response()->json($validator->errors(), 422));
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => 'required|mimes:png,jpeg|max:2048',
            // 'file' => 'required|mimes:png,jpeg,psd,pdf,epub,csv,xlsx,doc,docx|max:2048',
        ];
    }
   
    
}
