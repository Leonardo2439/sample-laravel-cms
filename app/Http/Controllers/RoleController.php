<?php

namespace App\Http\Controllers;

use App\Role;
use App\Permission;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index() {

        return view('admin.roles.index', [
            'roles' => Role::all()
        ]);
    }

    public function store() {

        request()->validate([
            'name' => 'required'
        ]);

        Role::create([
            'name' => Str::ucfirst(request('name')),
            'slug' => Str::of(Str::lower(request('name')))->slug('-')
        ]);

        return back();
    }

    public function edit(Role $role) {

        // dd($role->permissions);

        return view('admin.roles.edit', [
            'role' => $role,
            'permissions'=> Permission::all()
        ]);

    }

    public function update(Role $role) {

        $role->name = Str::ucfirst(request('name'));
        $role->slug = Str::of(request('name'))->slug('-');

        if ($role->isDirty('name')) {

            session()->flash('role-updated', 'Role Updated: '.request('name'));
            $role->save();

        } else {

            session()->flash('role-updated', 'Nothing has been update');

        }

        return back();
    }


    public function attach_permission(Role $role){

        $role->permissions()->attach(request('permissionId'));

        return back();
    }

    public function detach_permission(Role $role){

        $role->permissions()->detach(request('permissionId'));

        return back();
    }

    public function destroy(Role $role) {

        $role->delete();

        session()->flash('role-deleted', 'Deleted Role '. $role->name);

        return back();

    }

}
