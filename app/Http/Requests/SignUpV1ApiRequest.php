<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


use Illuminate\Validation\Rule;

class SignUpV1ApiRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */



    public function rules(): array
    {
        $authenticatedUser = auth()->user();

        return [
            'name' => 'required|max:25|regex:/^[a-zA-Z ]*$/',
            'country' => 'required|max:25|regex:/^[a-zA-Z ]*$/',
            'email' => [
            'required',
            'email',
            Rule::unique('users', 'email')->ignore($authenticatedUser ? $authenticatedUser->id : null),
        ],
        'phone_number' => [
            'required',
            'numeric',
            'digits:10',
            Rule::unique('users')->whereNull('deleted_at')->ignore($authenticatedUser ? $authenticatedUser->id : null),
        ],
        'password' => [
        $authenticatedUser ? 'nullable' : 'required',
        'min:6',
        'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,32}$/',
        ],
        ];
    }

    public function messages()
    {
        $messages = array(
            'name.required' => trans(
                'messages.custom.common_required',
                ["attribute" => "Name"]
            ),
            'name.max' => trans(
                'messages.custom.common_pattern_message',
                ["attribute" => "Name"]
            ),
            'email.required' => trans(
                'messages.custom.common_required',
                ["attribute" => "Email"]
            ),
            'email.exists' => trans(
                'messages.custom.common_exists',
                ["attribute" => "Email"]
            ),
            'email.email' => trans(
                'messages.custom.email_type_messages',
                ["attribute" => "Email"]
            ),
            'phone_number.required' => trans(
                'messages.custom.common_required',
                ["attribute" => "Phone Number"]
            ),
            'phone_number.exists' => trans(
                'messages.custom.common_exists',
                ["attribute" => "Phone Number"]
            ),
            'password.required' => trans(
                'messages.custom.common_required',
                ["attribute" => "Password"]
            ),
            'password.min' => trans(
                'messages.custom.password_length_messages',
                ["attribute" => "Password"]
            ),
            'password.regex' => trans(
                'messages.custom.password_pattern_messages',
                ["attribute" => "Password"]
            ),
            'password.confirmed' => trans(
                'validation.confirmed',
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
                'success' => false
            ], 422)
        );
    }
}
