<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $users = User::with('roles')->paginate(15);
    
        $users->getCollection()->transform(function ($user) {
            $user->roles_name = $user->roles->pluck('name')->toArray();
            return $user;
        });
    
        $roles = Role::all();
    
        return view('user.users', [
            'users' => $users,
            'roles' => $roles
        ]);
    }
    
    

    public function changeUserRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:show,delete,edit,create,admin',
        ]);
    
        $user = User::findOrFail($id);
        $user->update([
            'role' => $request->role,
        ]);
    
        return redirect()->back()->with('success', 'User role updated successfully.');
    }

    public function edit(User $user){
        $roles = Role::all();
        return view('user.user_edit',['user'=>$user,'roles'=>$roles]);
    }

    public function store(StoreUserRequest $request)
    {
        // dd($request->roles);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->roles()->sync($request->roles);

        return redirect('/users')->with('success', 'User created successfully.');
    
    }
    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->roles()->sync($request->roles);

        $user->save();

        return redirect('/users')->with('success', 'User updated successfully!');
    }


    public function destroy(User $user){

        if($user){
            $user->delete();
            return redirect()->route('user.index')->with('success', 'User  deleted successfully.');
        }
        return redirect()->route('user.index')->with('error', 'Error While Deleting User');
    }
    
    

}
