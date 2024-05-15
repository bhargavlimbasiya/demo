<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Helpers\FileUploadHelper;

use App\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function updateUser($request, $user)
    {
        $reqData = $request->all();

        if (!empty($reqData['profile_photo_path'])) {
            if ($user->profile_photo_path != null) {
                FileUploadHelper::imageDelete($user->profile_photo_path, 'users');
            }
            $reqData['profile_photo_path'] = FileUploadHelper::imageUpload($request->profile_photo_path, 'users');
        }
        $userData = $user->update($reqData);
        return $userData;
    }

    public function getUserData()
    {
        return User::where('id', '!=', auth()->id())->paginate(5);
    }

    public function storeUserData($userDetails)
    {

        $insertData = array(
            'name' => $userDetails['name'],
            'email' => $userDetails['email'],
            'phone_number' => $userDetails['phone_number'],
            'password' => Hash::make($userDetails['password']),
        );

        $user = User::create($insertData);
        $user->assignRole($userDetails['role']);
        return $user;
    }

    public function changeUserStatus($userId, $status)
    {
        return User::where('id', $userId)->update(['status' => $status]);
    }

    public function getUserDataById($id)
    {
        return User::findOrfail($id);
    }

    public function updateUserData($userDetails)
    {
       
        
        $user = Auth::user();
        $updateData = array(
            'name' => $userDetails['name'],
            'email' => $userDetails['email'],
            'phone_number' => $userDetails['phone_number'],
            'country' => $userDetails['country'],
        );
        
        $updateUser = User::find($user->id);
        $updateUser->update($updateData);

        // DB::table('model_has_roles')->where('model_id', $userDetails['id'])->delete();
        // $updateUser->assignRole($userDetails['role']);

        return $updateUser;
    }
    public function deleteUser($userId)
    {
        return User::where('id', $userId)->delete();
    }

    public function getUserDetailsAjax($request)
    {
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 100);
        $order = $request->query('order', array(1, 'desc'));
        $sortColumns = array(
            0 => 'users.id',
        );
        $query =  User::select('*')->where('id', '!=', auth()->id());
        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);
        $json = array(
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        );
        $no = $start + 1;
        $userData = $query->get();

        foreach ($userData as $user) {
            $status = $user->status;
            $edit = route("admin-users.edit", $user['id']);
            $getId = $user['id'];
            $action = ' ';
            $statusToggle = "";
            $date = $user->joining_date;
            $joiningDate = "";

            if ($date != "") {
                $joiningDate = date("m/d/Y", strtotime($date));
            }
            
            if ($user->status == '1' ? 'checked' : '') {
                $statusToggle = $user->status == '1' ? 'checked' : '';
            }

          

            $action = '';
            $status = '<div class="col-lg-8 d-flex align-items-center">
            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                <input type="checkbox" name="select" class="form-check-input status_'.$getId.' w-45px h-30px  status_check" data-id="' . $getId . '" id="status" data-on="Active" data-off="InActive" disabled   ' . $statusToggle . '>
               </div>
               </div>';

            if (auth()->user()->can('user-edit')) {
                
                $status = '<div class="col-lg-8 d-flex align-items-center">
                <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                    <input type="checkbox" name="select" class="form-check-input status_'.$getId.' w-45px h-30px toggle-class status_check" data-id="' . $getId . '" id="status" data-on="Active" data-off="InActive" onchange="statusToggle();"' . $statusToggle . '>
                   </div>
                   </div>';

                $action .= '<div style="float:right;"><a href="' . $edit . '" title="Edit" class="navi-link" style="margin-right: 7px;">
                                       <span class="navi-icon">
                                           <i class="fa fa-edit text-primary" style="font-size:1.5rem;"></i>
                                       </span>
                                   </a>';
            }

            if (auth()->user()->can('user-delete')) {
                $action .= ' <a href="javascript:void(0);" data-id="' . $getId . '" class="navi-link delToolType deleteUser" title="Delete">
                                   <span class="navi-icon">
                                       <i class="fa fa-trash text-danger" style="font-size:1.5rem;"></i>
                                   </span>

                               </a> </div>';
            }

            $json['data'][] = [
                $no,
                $user['name'],
                $user['email'],
                $user['phone_number'],
                $joiningDate,
                $status,
                $action
            ];
            $no++;
        }
        return $json;
    }



    public function createUser($request)
    {
        $user = User::create($request);
        $user['access_token'] = $user->createToken('MyAuthApp')->plainTextToken;
        $this->updateUserWithId($user->id, ["access_token" => $user['access_token']]);
        // $user->assignRole(['User']);
        return $user;
    }


    public function login($request)
    {
        $response = ['status' => false, 'data' => []];
        $field = $request->input('email_or_phone');
        $identifier = filter_var($field, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_number';
        $request->merge([$identifier => $field]);
        if (Auth::attempt($request->only($identifier, 'password'))) {
            $user = Auth::user();
            // $roles = $user->roles->pluck('name')->toArray();
            // if (in_array('User', $roles)) {
                $user['access_token'] = $user->createToken('MyAuthApp')->plainTextToken;
                $this->updateUserWithId($user->id, ["access_token" => $user['access_token']]);
                $response['status'] = true;
                $response['data'] = $user;
                $response['msg'] = trans('messages.custom.login_messages');
            // } else {
            //     $response['msg'] = trans('messages.custom.invalid_role');
            // }
        } else {
            $response['msg'] = trans('messages.custom.invalid_user');
        }
        return $response;
    }


    public function getSingalUserData($column, $value)
    {
        return User::where($column, $value)->first();
    }


    public function updateUserWithId($id, $data)
    {
        $userData = User::find($id)->update($data);
        return $userData;
    }

    public function changeUserPassword($request){
        $data = array('password'=> Hash::make($request['new_password']),);
        return $this->updateUserWithId(Auth()->user()->id,$data);
    }

    
}
