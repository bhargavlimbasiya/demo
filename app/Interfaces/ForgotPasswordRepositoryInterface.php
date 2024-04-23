<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface ForgotPasswordRepositoryInterface
{

    public function getForgotPasswordDataByEmail($email);
    public function updateOtpDataById($id,$data);

}
