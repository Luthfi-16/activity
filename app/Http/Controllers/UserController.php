<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('listuser.index', compact('users'));
    }

    // form edit user
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('ulistuser.edit', compact('users'));
    }

    // update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'is_admin' => 'required|boolean',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->is_admin = $request->is_admin;
        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }
}
