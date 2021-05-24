<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index() {

        $users = User::all();

        return view('admin.users.index', ['users' => $users]);
    }

    public function show(User $user) {

        
        return view('admin.users.profile', [
            'user' => $user,
            'roles' => Role::all(),
        ]);
    }

    public function update(User $user) {

        $inputs = request()->validate([
            'username' => 'required|string|max:255|alpha_dash',
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'avatar' => 'mimes:jpeg,png'
        ]);
        
        if (request('avatar')) {
            $inputs['avatar'] = request('avatar')->store('images');
        }

        $user->update($inputs);

        return back();

    }

    public function destroy(User $user) {

        $user->delete();

        session()->flash('user-deleted', 'User has been deleted');

        return back();

    }

    public function attach(User $user) {

        $user->roles()->attach(request('roleId'));

        return back();

    }


    public function detach(User $user) {

        $user->roles()->detach(request('roleId'));

        return back();

    }

}
