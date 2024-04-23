<?php

namespace App\Repositories;

use App\Interfaces\ForgotPasswordRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ForgotPasswordRepository implements ForgotPasswordRepositoryInterface
{

    public function getForgotPasswordDataByEmail($email)
    {
        return User::where('email', $email)->orwhere('phone_number', $email)->whereNull('deleted_at')->first();
    }

    public function updateOtpDataById($id,$data)
    {
        return User::where('id', $id)->update($data);
    }

}
