<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;


class CategoryFormRequest extends FormRequest
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
       
            return [
                'name' => 'required|max:25|regex:/^[a-zA-Z ]*$/|string',
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
            'description.required' => trans(
                'validation.custom.common_required',
                ["attribute" => "Description"]
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
