<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Routing\Controller as BaseController;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\User;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function sendResponse($success, $result, $message)
    {
        $response = [
            'success' => $success,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }

    public function createAdminUser($user){

        $validator = Validator::make($user,[
            'name' => 'required|max:25|regex:/^[a-zA-Z ]*$/|string',
            'email' => ['required', 'string', 'email', Rule::unique('users')->whereNull('deleted_at')],
            'phone_number' => ['required', 'min:10', 'max:10', Rule::unique('users')->whereNull('deleted_at')],
            'password' => ['required', 'string', 'min:6', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'],
        ]);

        if ($validator->fails()) {
            return ['message' => $validator->errors()->all(),'status' => 0];
        }

        $userData = User::firstOrNew(['email' =>  request('email')]);
        $userData->name = $user['name'];
        $userData->email = $user['email'];
        $userData->password = Hash::make($user['password']);
        $userData->save();
        $userData->assignRole(['Admin']);

        return ['message' =>  [trans('messages.custom.super_admin_messages')], 'status' => 1];

    }

}
