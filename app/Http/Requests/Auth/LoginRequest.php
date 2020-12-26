<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
   

class LoginRequest extends FormRequest
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
            'password' => 'required|string',
            'username' => 'required|string',
        ];
    }
   
    /**
     * Get the custom validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => 'Email or Username field cannot be empty',
            // 'username.exists' => 'What you inputed does not exist in our record',
            'password.required' => 'Password cannot be empty',
        ];
    }
}
