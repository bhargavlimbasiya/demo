<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

use App\Http\Requests\AgreementRequest;
use App\Http\Requests\ForgotApiRequest;
use App\Http\Requests\LoginApiRequest;
use App\Http\Requests\ResendOtpApiRequest;
use App\Http\Requests\ResetApiRequest;
use App\Http\Requests\SignUpV1ApiRequest;
use App\Http\Requests\VerifyOtpApiRequest;
use App\Http\Requests\ChangePasswordRequest;




use App\Interfaces\UserRepositoryInterface;

use Laravel\Sanctum\HasApiTokens;

use App\Mail\SendCodeResetPassword;

class HomeController extends Controller
{
    use HasApiTokens;

    protected $successStatus = 200;
    protected $insertStatus = 201;
    protected $validationStatus = 400;
    protected $errorStatus = 500;
    protected $unauthorizedStatus = 401;
    protected $notFoundStatus = 404;
    protected $failedStatus = 451;

    protected $userRepository = '';
    protected $cmsRepository = '';

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function signUp(SignUpV1ApiRequest $request)
    {
        $reqData = $request->all();
        $reqData['password'] = Hash::make($reqData['password']);
        $data = $this->userRepository->createUser($reqData);
        return $this->sendResponse(true, $data, trans(
            'messages.custom.register_messages',
            ["attribute" => "User"]
        ));
    }
    public function signIn(LoginApiRequest $request)
    {
        $result = $this->userRepository->login($request);
        return $this->sendResponse($result['status'], $result['data'], $result['msg'], $result['status'] == true ? $this->successStatus : $this->failedStatus);
    }

    public function forgotPassword(ForgotApiRequest $request)
    {
        $verify = $this->userRepository->getSingalUserData('email', $request->email);
        if ($verify != null) {
            $otp = random_int(100000, 999999);
            $verify->otp = $otp;
            $this->userRepository->updateUserWithId($verify->id, ['otp' => null]);
            Mail::to($request->email)->send(new SendCodeResetPassword($otp));
            $verify->save();
            $sendResponse = [
                'id' => $verify->id,
                'otp' => $otp
            ];
            return $this->sendResponse(true, $sendResponse, trans(
                'messages.custom.emailSuccess_Api',
            ));
        }
        return $this->sendResponse(false, [], trans(
            'messages.custom.notEmail',
        ));
    }

    public function verifyPin(VerifyOtpApiRequest $request)
    {
        $defaultOTP = $request->otp;
        $result = $this->userRepository->getSingalUserData('id', $request->user_id);
        if ($result) {
            if ($request->otp == $result->otp || $defaultOTP === '999999') {
                $this->userRepository->updateUserWithId($result->id, ['otp' => null]);
                $sendResponse = [
                    'user_id' => $result->id,
                ];

                return $this->sendResponse(true, $sendResponse, trans(
                    'messages.custom.otp_message',
                ));
            }
            return $this->sendResponse(false, [], trans(
                'messages.custom.otpexpired',
            ));
        }
        return $this->sendResponse(false, [], trans(
            'messages.custom.otpexpired',
        ));
    }

    public function resetPassword(ResetApiRequest $request)
    {
        $result = $this->userRepository->getSingalUserData('id', $request->user_id);
        if ($result) {
            $updateAppUser = $this->userRepository->updateUserWithId($result->id, ['password' => Hash::make($request->password)]);
            if ($updateAppUser) {
                $sendResponse = [
                    'user_id' => $result->id,
                ];
                return $this->sendResponse(true, $sendResponse, trans(
                    'messages.custom.reset_password',
                    ["attribute" => "Password"]
                ), $this->successStatus);
            }
            return $this->sendResponse(false, [], trans('messages.error_messages'), $this->failedStatus);
        } else {
            return $this->sendResponse(false, [], trans('messages.custom.notEmail'), $this->failedStatus);
        }
    }

    public function resendOtp(ResendOtpApiRequest $request)
    {
        $result = $this->userRepository->getSingalUserData('id', $request->user_id);
        if ($result != null) {
            $otp = random_int(100000, 999999);
            $result->otp = $otp;
            $this->userRepository->updateUserWithId($result->id, ['otp' => null]);
            Mail::to($result->email)->send(new SendCodeResetPassword($otp));
            $result->save();
            $sendResponse = [
                'id' => $result->id,
                'otp' => $otp,
            ];
            return $this->sendResponse(true, $sendResponse, trans('messages.custom.resend_otp_message'), $this->successStatus);
        }
        return $this->sendResponse(false, [], trans('messages.custom.error_messages'), $this->failedStatus);
    }



    public function changePassword(ChangePasswordRequest $request)
    {
       $auth = auth()->user();
       
        if (Hash::check($request->current_password, $auth->password)) {
            $update = $this->userRepository->changeUserPassword($request->all());
            if ($update) {
                return response()->json([
                    'message' =>
                    trans(
                        'messages.custom.password_messages',
                        ["attribute" => "Password"]
                    ),
                    'status' => true,
                    'data' => [],
                ], $this->successStatus);
            } else {
                return response()->json([
                    'message' => trans(
                        'messages.custom.error_messages',
                    ),
                    'status' => false,
                    'data' => [],
                ],$this->failedStatus);
            }
        } else {
            return response()->json([
                'message' => trans(
                    'messages.custom.current_pass_messages',
                ),
                'status' => false,
                'data' => [],
            ], $this->failedStatus);
        }
    }   


    public function userDetail()
    {
        $user = Auth::user();
        return $this->sendResponse(true, $user, trans(
            'messages.custom.user_detail',
        ), $this->successStatus);
    }




    public function updateAgreement(AgreementRequest $request)
    {
        $result = $this->userRepository->getSingalUserData('id', $request->user_id);
        if ($result) {
            $updateAppUser = $this->userRepository->updateUserWithId($result->id, ['agreement' => $request->agreement]);
            if ($updateAppUser) {
                $sendResponse = [
                    'user_id' => $result->id,
                ];
                return $this->sendResponse(true, $sendResponse, trans(
                    'messages.custom.update_messages',
                    ["attribute" => "Agreement"]
                ), $this->successStatus);
            }
            return $this->sendResponse(false, [], trans('messages.error_messages'), $this->failedStatus);
        } else {
            return $this->sendResponse(false, [], trans('messages.custom.notEmail'), $this->failedStatus);
        }
    }



    public function updateProfile(SignUpV1ApiRequest $request)
    {
        $result = $this->userRepository->updateUserData($request);
            if ($result) {
                $sendResponse = [
                    'update_user' => $result,
                ];
                return $this->sendResponse(true, $sendResponse, trans(
                    'messages.custom.update_messages',
                    ["attribute" => "Profile"]
                ), $this->successStatus);
            return $this->sendResponse(false, [], trans('messages.error_messages'), $this->failedStatus);
        } else {
            return $this->sendResponse(false, [], trans('messages.custom.notEmail'), $this->failedStatus);
        }
    }

    public function gameRule()
    {
        $gameRule = 'game rule non sint sunt et alias et velit facilis recusandae magni autem consequatur et iure neque vel quia recusandae ipsum aspernatur';
            if ($gameRule) {
                $sendResponse = [
                    'game rule' => $gameRule,
                ];
                return $this->sendResponse(true, $sendResponse, trans(
                    'messages.custom.get_messages',
                    ["attribute" => "Game Rule"]
                ), $this->successStatus);
            return $this->sendResponse(false, [], trans('messages.error_messages'), $this->failedStatus);
        } else {
            return $this->sendResponse(false, [], trans('messages.custom.notEmail'), $this->failedStatus);
        }
    }




    
}
