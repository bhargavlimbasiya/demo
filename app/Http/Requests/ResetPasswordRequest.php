<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ResetPasswordRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'password' => 'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'password_confirmation' => 'required_with:password|same:password',
        ];
    }
    public function messages()
    {
        $messages = array(
            'password.required' => trans(
                'validation.custom.password_required',
                ["attribute" => "Password"]
            ),
            'password_confirmation.required' => trans(
                'validation.custom.password_required',
                ["attribute" => "Confirm Password"]
            ),
            'password.max' => trans(
                'validation.custom.max_8_validation',
                ["attribute" => "Password"]
            ),
            'password.regex' => trans(
                'validation.custom.regex_validation',
                ["attribute" => "Password"]
            ),
        );

        return $messages;
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => $validator->errors()->all()[0],
                'status' => false
            ], 422)
        );
    }
}
