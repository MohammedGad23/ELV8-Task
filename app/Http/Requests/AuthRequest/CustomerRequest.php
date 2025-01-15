<?php

namespace App\Http\Requests\AuthRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class CustomerRequest extends FormRequest
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
            'phone'=>['required','unique:customers','regex:/^(\+?\d{1,4}[\s\-]?)?(\(?\d{1,4}\)?[\s\-]?)?[\d\s\-]{7,15}$/'],
            'email'=>['required','email','unique:customers'],
            'gender'=>['required','in:male,female'],
        ];
    }

    public function messages()
    {
        return [
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'The email has already been existed.',
            'phone.unique' => 'The phone has already been existed.',
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
