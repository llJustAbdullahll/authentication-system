<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Roles\CreateRoleController;
use App\Http\Requests\Admin\Roles\UpdateRoleController;
use App\Models\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function index() {
      $roles = Role::all();
      return view('admin.roles.index', compact('roles'));
    }

    public function store(CreateRoleController $request){

      Role::create($request->validated());

      return back()->with('success', 'Role Created Successfully');
    }

    public function update(UpdateRoleController $request, Role $role){      

      $role->update(['name' => $request->name]);

      return back()->with('success', 'Role Updated Successfully');
    }

    public function destroy(Role $role) {
      $role->delete();
      return back()->with('success', 'Role Deleted Successfully');
    }
}
