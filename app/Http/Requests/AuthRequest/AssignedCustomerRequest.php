<?php

namespace App\Http\Requests\AuthRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class AssignedCustomerRequest extends FormRequest
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
            'employee_id'=>['required','exists:users,id'],
            'customer_id'=>['required','exists:customers,id'],
        ];
    }

    public function messages()
    {
        return [
            'employee_id.required' => 'Employee is required.',
            'employee_id.exists' => 'The employee has already not existed.',
            'customer_id.required' => 'Customer is required.',
            'customer_id.exists' => 'The customer has already not existed.',
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
