<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = User::paginate(15);
        return view('user.users',['users'=>$users]);
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
    
    

}
