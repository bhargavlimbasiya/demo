<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UpdatePasswordRequest;

use App\Interfaces\UserRepositoryInterface;

use App\Models\User;

class AuthController extends Controller
{
    protected $userRepository = "";
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('auth');
    }
    public function profileUpdate(ProfileUpdateRequest $request)
    {
        $user = Auth::user();
        try {
            $this->userRepository->updateUser($request, $user);
            return $this->sendResponse(true, ['data' => []], trans(
                'messages.custom.update_messages',
                ["attribute" => "Profile"]
            ));
        } catch (\Exception $e) {
            return $this->sendResponse(false, [], $e->getMessage());
        }
    }
    public function updatePassword(UpdatePasswordRequest $request)
    {
        try {
            if (!Hash::check($request->current_password, auth()->user()->password)) {
                return $this->sendResponse(false, [], trans(
                    'messages.custom.current_pass_messages',
                ));
            }

            User::userUpdate(['id' => auth()->user()->id], [
                'password' => Hash::make($request->new_password)
            ]);
            return $this->sendResponse(true, [], trans(
                'messages.custom.password_messages',
                ["attribute" => "Password"]
            ));
        } catch (\Exception $e) {
            return $this->sendResponse(false, [], $e->getMessage());
        }
    }
}
