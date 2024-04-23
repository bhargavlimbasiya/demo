<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Interfaces\ForgotPasswordRepositoryInterface;

use App\Http\Requests\EmailRequest;

use Illuminate\Support\Facades\Session;

use App\Notifications\ResetPassword;


class ForgotPasswordController extends Controller
{
    protected $forgotPasswordRepository = "";
    public function __construct(ForgotPasswordRepositoryInterface $forgotPasswordRepository)
    {
        $this->forgotPasswordRepository = $forgotPasswordRepository;
    }

    public function sendForgotPasswordEmailResetPassword(EmailRequest $request)
    {

        $checkEmail = $this->forgotPasswordRepository->getForgotPasswordDataByEmail($request->email);

        if ($checkEmail) {

            $data['name'] = $checkEmail->name;
            $otp = mt_rand(100000, 999999);
            try {
                $checkEmail->notify(new ResetPassword(encrypt($checkEmail->id), $otp));
            } catch (\Exception $e) {
                Session::flash('error', trans('messages.custom.emailnotSend'));
                return redirect()->back();
            }
            $this->forgotPasswordRepository->updateOtpDataById($checkEmail->id, array('otp' => $otp));
            Session::flash('success', trans('passwords.sent'));
            $id = encrypt($checkEmail->id);
            return redirect()->route('password.reset', ['token' => $id]);
        }
            else {
            Session::flash('error', trans('passwords.user'));
            return redirect()->back();
        }
    }
}
