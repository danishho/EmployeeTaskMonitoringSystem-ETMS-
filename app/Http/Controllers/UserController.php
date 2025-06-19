<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(request $request){

        $validateAttributes= request()->validate([
            'name'=>'required',
            'email'=> ['required', 'email','max:255', 'unique:users, email'],
            'password'=>['required', 'min:4'],
            'phone'=> ['required'] ,
            'role'=>'required',
            'department_id'=>'required',
        ]);

        User::create($validateAttributes);

        return redirect('/user/add')->with('success', 'User registered successfully!');
    }

    public function list(Request $request)
    {
        $search = $request->input('search');
        $query = User::with('department');

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $users = $query->get();

        // Pass users and search term to the view
        return view('admin.list-user', compact('users', 'search'));
    }

    public function destroy(User $user){
        $user->delete();
        return redirect('/user/list')->with('success', 'User deleted successfully!');
    }

    public function updatePassword(User $user, Request $request){
        $validateAttributes= request()->validate([
            'password'=>['required', 'min:4'],

        ]);
        $user->update($validateAttributes);
        return redirect('/user/list')->with('success', 'Password updated successfully!');
    }

    public function edit(User $user){
        return view('admin.edit-user', compact('user'));
    }

    public function editStore(User $user, Request $request){
        $validateAttributes= request()->validate([
            'name'=>'required',
            'email'=> ['required', 'email','max:255', 'unique:users, email'],
            'phone'=> ['required'],
            'role'=>'required',
            'department_id'=>'required',
        ]);
        $user->update($validateAttributes);
        return redirect('/user/list')->with('success', 'User updated successfully!');
    }


}
