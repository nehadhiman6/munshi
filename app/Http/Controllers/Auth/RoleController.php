<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auth\Role;
use App\Models\Auth\Permission;
use App\Models\Auth\RolePermission;
use Gate;
use App\Models\Auth\PermissionGroup;

class RoleController extends Controller
{

    public function index()
    {
        if (Gate::denies('roles')) {
            return deny();
        }
        $roles = Role::orderBy('name')->get();
        return view('auth.roles.index', compact('roles'));
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        if (Gate::denies('role-modify')) {
            return deny();
        }
        $this->validate($request, [
            'name' => 'required|regex:/(^[A-Za-z0-9 ]+$)+/|unique:roles',
        ]);
        Role::create($request->only(['name', 'label']));
        return redirect('roles');
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        if (Gate::denies('role-modify')) {
            return deny();
        }
        $role = Role::findOrFail($id);
        $roles = Role::orderBy('name')->get();
        return view('auth.roles.index', compact('roles', 'role'));
    }


    public function update(Request $request, $id)
    {
        if (Gate::denies('role-modify')) {
            return deny();
        }
        $this->validate($request, [
            'name' => 'required|regex:/(^[A-Za-z0-9 ]+$)+/|unique:roles,name,' . $id,
        ]);
        $role = Role::findOrFail($id);
        $role->fill($request->all());
        $role->save();
        return redirect('roles');
    }


    public function destroy($id)
    {
        //
    }

    public function showPermissions($role_id)
    {
        $permissions = Permission::orderBy('name')->get();
        $role = Role::find($role_id);
        $role->load(['permissions']);
        $opt_groups = PermissionGroup::orderBy('order_no')
            ->with(['permissions'])
            ->get();
        // dd($role->permissions->pluck('id')->toArray());

        return view('auth.roles.permissions_to_role', compact('role', 'opt_groups'));
    }

    public function savePermissions(Request $request, $role_id)
    {
        $this->validate($request, [
            'permissions' => 'array|min:1',
        ], [
            'permissions.size' => 'Select atleast one permission to save!!'
        ]);

        $role = Role::findOrFail($role_id);
        $role->permissions()->sync($request->permissions);
        return reply('OK');

        $role_permission_ids = RolePermission::where('role_id', $role_id)->pluck('permission_id')->toArray();
        if ($request->permission == null) {
            $request->permission = [];
        }



        $diff = array_diff($role_permission_ids, $request->permission);
        // dd($role_permission_ids);

        foreach ($request->input('permission', []) as $permis) {
            $role_permission = RolePermission::where('role_id', $role_id)->where('permission_id', $permis)->get();
            if ($role_permission == '[]') {
                $permission = new RolePermission();
                $permission->create(['role_id' => $role_id, 'permission_id' => $permis]);
            }
        }
        RolePermission::where('role_id', $role_id)->whereIn('permission_id', $diff)->delete();
        session()->flash('message', 'Permission Info Saved!');
        return redirect('roles');
        return redirect()->back();
    }
}
