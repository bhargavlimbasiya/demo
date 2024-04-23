<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\RoleHasPermission;

use App\Http\Requests\RoleRequest;


class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-show|role-edit|role-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-show', ['only' => ['show']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $roles = Role::orderBy('id', 'DESC')->paginate(5);
        $titles = [
            'title' => 'Role List',
            'breadcrumb_item' => [
                ['title' => 'Dashboard', 'link' => true, 'route' => route('dashboard')],
                ['title' => 'Role', 'link' => false, 'route' => ''],
            ],
        ];

        return view('roles.index', compact('roles', 'titles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $permission = Permission::get();
        $titles = [
            'title' => 'Add New Role',
            'breadcrumb_item' => [
                ['title' => 'Dashboard', 'link' => true, 'route' => route('dashboard')],
                ['title' => 'Role', 'link' => true, 'route' => route('roles.index')],
                ['title' => 'Create', 'link' => false, 'route' => ''],
            ],
        ];
        return view('roles.create', compact('permission', 'titles'));
    }

    public function store(RoleRequest $request)
    {
        try {
            $role = isset($request->id) && $request->id != null ? Role::find($request->id) : new Role();
            $role->name = $request->input('name');
            $role->save();
            $role->syncPermissions($request->input('permission'));
            $msg = isset($request->id) && $request->id != null ? 'messages.custom.update_messages' : 'messages.custom.create_messages';
            return $this->sendResponse(true, ['data' => []], trans(
                $msg,
                ["attribute" => "Role"]
            ));
        } catch (\Exception $e) {
            return $this->sendResponse(false, [], $e->getMessage());
        }
    }

    public function show($id)
    {
        $role = Role::find($id);
        $titles = [
            'title' => 'Show Role',
            'breadcrumb_item' => [
                ['title' => 'Dashboard', 'link' => true, 'route' => route('dashboard')],
                ['title' => 'Role', 'link' => true, 'route' => route('roles.index')],
                ['title' => 'Show', 'link' => false, 'route' => ''],
            ],
        ];

        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('roles.show', compact('role', 'rolePermissions', 'titles'));
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $title = 'Edit Role';
        $titles = [
            'title' => 'Edit Role',
            'breadcrumb_item' => [
                ['title' => 'Dashboard', 'link' => true, 'route' => route('dashboard')],
                ['title' => 'Role', 'link' => true, 'route' => route('roles.index')],
                ['title' => 'Edit', 'link' => false, 'route' => ''],
            ],
        ];

        $permission = Permission::get();
        $rolePermissions = RoleHasPermission::where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('roles.edit', compact('role', 'permission', 'rolePermissions', 'titles'));
    }

    public function destroy($id)
    {
        try {
            Role::where('id', $id)->delete();

            return $this->sendResponse(true, ['data' => []], trans(
                'messages.custom.delete_messages',
                ["attribute" => "Role"]
            ));
        } catch (\Exception $e) {
            return $this->sendResponse(false, [], $e->getMessage());
        }
    }
}
