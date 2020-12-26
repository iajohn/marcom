<?php

namespace App\Http\Requests\Auth;

// use App\Models\User;
use App\Rules\NoSpaceContain;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    /**
     * Prevent request from redirecting to welcome page.
     */
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

    protected function prepareForValidation()
    {
        $this->sanitize();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'     => [
                'required', 
                'string', 
                'min:2', 
                'max:100'
            ],
            'email'    => [
                'required', 
                'regex:/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/', 
                'string', 
                'email', 
                'max:255', 
                'unique:users'
            ],
            'password' => [
                'required',
                'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
                'string',
                'min:6',
                'max:30',
                'confirmed',
                new NoSpaceContain()
            ],
            'username' => [
                'required', 
                'string', 
                'min:6', 
                'max:15', 
                'unique:users', 
                new NoSpaceContain()
            ],
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
            // 'email.regex'     => 'Enter correct email regex',
            'password.regex'  => 'Password must contain at least one Uppercase letter (A-Z), one lowercase letter (a-z), one digit (0-9) and a special character (#?!@$%^&*-)',
        ];
    }

    // public function messages()
    // {
    //     return User::$messages;
    // }

    public function sanitize()
    {
        $input = $this->all();

        $input['name'] = htmlspecialchars($input['name']);

        $this->replace($input);
    }
}
