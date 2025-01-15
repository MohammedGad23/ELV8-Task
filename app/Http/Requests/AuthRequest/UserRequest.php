<?php

namespace App\Http\Requests\AuthRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class UserRequest extends FormRequest
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
        // Note that you can add admin or employee
        return [
            'name'=>['required', 'string'],
            'username'=>['required', 'string', 'max:100','unique:users'],
            'phone'=>['nullable','unique:users','regex:/^(\+?\d{1,4}[\s\-]?)?(\(?\d{1,4}\)?[\s\-]?)?[\d\s\-]{7,15}$/'],
            'email'=>['nullable','email','unique:users'],
            'type'=>['required','in:admin,employee'],
            'gender'=>['required','in:male,female'],
            'password' => ['required', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/','regex:/[@$!%*?&]/',],
        ];
    }

    public function messages()
    {
        return [
            'username.unique'=>'username is used, please select another.',
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'type.required' => 'Type is required.',
            'type.in'=>'Type must be admin or employee',
            'phone.unique' => 'The phone has already been taken.',
            'gender.required' => 'Gender is required.',
            'gender.in'=>'gender must be male or female',
        ];
    }



    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();

        $response = response()->json([
            'errors' => $errors
        ], 422);

        throw new HttpResponseException($response);
    }
}
