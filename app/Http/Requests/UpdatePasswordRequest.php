<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePasswordRequest extends FormRequest
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
            'current_password' => 'required',
            'new_password' => 'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
            'confirm_password' => 'required_with:new_password|same:new_password',
        ];
    }
    public function messages()
    {
        $messages = array(
            'current_password.required' => trans(
                'validation.custom.password_required',
                ["attribute" => "Current Password"]
            ),
            'new_password.required' => trans(
                'validation.custom.password_required',
                ["attribute" => "New Password"]
            ),
            'confirm_password.required' => trans(
                'validation.custom.password_required',
                ["attribute" => "Confirm Password"]
            ),
            'new_password.max' => trans(
                'validation.custom.max_8_validation',
                ["attribute" => "New Password"]
            ),
            'new_password.regex' => trans(
                'validation.custom.regex_validation',
                ["attribute" => "New Password"]
            ),
        );

        return $messages;
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'errors' => $validator->errors()->all()[0],
                'status' => false
            ], 422)
        );
    }
}
