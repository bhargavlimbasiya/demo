<?php

namespace App\Http\Controllers;

use App\Interfaces\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Spatie\Permission\Models\Role;

use Illuminate\Http\Request;
use App\Http\Requests\UserFormRequest;


class UserController extends Controller
{
    protected $userRepository = "";
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('auth');
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $users = $this->userRepository->getUserData();
        $titles = [
            'title' => 'Users List',
            'breadcrumb_item' => [
                ['title' => 'Dashboard', 'link' => true, 'route' => route('dashboard')],
                ['title' => 'Users', 'link' => false, 'route' => ''],
            ],
        ];

        return view('users.index', compact('titles', 'users'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
        $titles = [
            'title' => 'Users List'
        ];
    }

    public function userAjaxList(Request $request){
        return $this->userRepository->getUserDetailsAjax($request);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $roles = Role::get();
        $titles = [
            'title' => 'Add User',
            'breadcrumb_item' => [
                ['title' => 'Dashboard', 'link' => true, 'route' => route('dashboard')],
                ['title' => 'Users', 'link' => true, 'route' => route('admin-users.index')],
                ['title' => 'Create', 'link' => false, 'route' => ''],
            ],
        ];
        return view('users.create', compact('titles','roles'));
    }

    // User create and update both with this function
    public function store(UserFormRequest $request)
    {
        $userDetails = $request->all();
        try {
             if(isset($request->id) && $request->id != null) {
                $user = $this->userRepository->updateUserData($userDetails);
                $message = 'messages.custom.update_messages';
             }else{
                $this->userRepository->storeUserData($userDetails);
                $message = 'messages.custom.create_messages';
             }

            return $this->sendResponse(true, ['data' => []], trans(
                $message,
                ["attribute" => "Sub Admin"]
            ));
        } catch (\Exception $e) {
            return $this->sendResponse(false, [], 'Something went wrong. Try again please..!!');
        }
    }



    public function show(string $id)
    {

    }


    public function edit(string $id)
    {
        $user = $this->userRepository->getUserDataById($id);
        $roles = Role::get();
        $userRole = $user->roles->pluck('name','name')->all();

        $titles = [
            'title' => 'Edit User',
            'breadcrumb_item' => [
                ['title' => 'Dashboard', 'link' => true, 'route' => route('dashboard')],
                ['title' => 'Users', 'link' => true, 'route' => route('admin-users.index')],
                ['title' => 'Edit', 'link' => false, 'route' => ''],
            ],
        ];
        return view('users.edit', compact('titles', 'user','roles','userRole'));
    }


    public function destroy($id)
    {
        try {
            $this->userRepository->deleteUser($id);
            return $this->sendResponse(true, ['data' => []], trans(
                'messages.custom.delete_messages',
                ["attribute" => "User"]
            ));
        } catch (\Exception $e) {
            return $this->sendResponse(false, [], 'Something went wrong. Try again please..!!');
        }
    }

    public function changeUserStatus(Request $request){
        try {
            $this->userRepository->changeUserStatus($request->user_id, $request->status);
            return $this->sendResponse(true, ['data' => []], trans(
                'messages.custom.update_messages',
                ["attribute" => "User Status"]
            ));
        } catch (\Exception $e) {
            return $this->sendResponse(false, [], 'Something went wrong. Try again please..!!');
        }
    }
}
