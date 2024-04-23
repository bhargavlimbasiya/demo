<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProfileUpdateRequest extends FormRequest
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
        $id = Auth::user()->id;
        return [
            'name' => 'required|max:25|regex:/^[a-zA-Z ]*$/',
            'email' => 'required|email|unique:users,email,' . $id . ',id,deleted_at,NULL',
        ];
    }
    public function messages()
    {
        $messages = array(
            'name.required' => trans(
                'validation.custom.common_required',
                ["attribute" => "Name"]
            ),
            'name.max' => trans(
                'validation.custom.max_25_validation',
                ["attribute" => "Name"]
            ),
            'email.required' => trans(
                'validation.custom.email_required',
                ["attribute" => "Email"]
            ),
            'email.exists' => trans(
                'validation.custom.common_exists',
                ["attribute" => "Email"]
            ),
            'email.max' => trans(
                'validation.custom.max_validation',
                ["attribute" => "Email"]
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
