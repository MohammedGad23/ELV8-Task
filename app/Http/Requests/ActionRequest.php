<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class ActionRequest extends FormRequest
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
            'action_type'=>['required','in:call, visit, follow_up'],
            'customer_id'=>['required','exists:customers,id'],
            'result'=>['nullable'],
        ];
    }

    public function messages()
    {
        return [
            'action_type.required' => 'action type is required.',
            'action_type.in'=>'action type must be call, visit, follow_up',
            'customer_id.required'=>'customer is required.',
            'customer_id.exists' => 'The customer has not existed.',
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
