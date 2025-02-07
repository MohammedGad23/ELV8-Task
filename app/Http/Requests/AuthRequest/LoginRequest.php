<?php

namespace App\Http\Requests\AuthRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class LoginRequest extends FormRequest
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
        // can login by username or email
        $loginField = $this->getLoginField();

        $rules = [

        ];

        if ($loginField === 'email') {
            $rules = [
                'username' =>['required','string','exists:users,email'],
                'password' => 'required|string',
            ];
        } else {
            $rules = [
                'username' =>['required','string','exists:users,username'],
                'password' => 'required|string',
            ];
        }

        return $rules;
    }

    private function getLoginField()
    {
        $login = $this->input('username');

        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            return 'email';
        }

        return 'username';
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
