<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPhone;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class UserPhoneController extends Controller
{
    public function index()
    {
        $userphone = UserPhone::with('user')->latest()->get();
        return view('userphone.index', compact('userphone'));
    }

    public function create()
    {
        $user = User::all();
        return view('userphone.create', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'number'  => 'required|string|max:255',
            'name'    => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $userphone          = new UserPhone();
        $userphone->number  = $request->number;
        $userphone->name    = $request->name;
        $userphone->user_id = $request->user_id;

        $userphone->save();

        Alert::success('Success', 'Data added successfully');
        return redirect()->route('userphone.index');
    }

    public function show(string $id)
    {
        $userphone = UserPhone::with('user')->findOrFail($id);
        return view('userphone.show', compact('userphone'));
    }

    public function edit(string $id)
    {
        $userphone = UserPhone::findOrFail($id);
        $user      = User::all();
        return view('userphone.edit', compact('userphone', 'user'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'number'  => 'required|string|max:255',
            'name'    => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $userphone          = UserPhone::findOrFail($id);
        $userphone->number  = $request->number;
        $userphone->name    = $request->name;
        $userphone->user_id = $request->user_id;

        $userphone->save();

        Alert::success('Success', 'Data edited successfully');
        return redirect()->route('userphone.index');
    }

    public function destroy(string $id)
    {
        $userphone = UserPhone::findOrFail($id);
        $userphone->delete();

        Alert::warning('Deleted', 'Data deleted successfully');
        return redirect()->route('userphone.index');
    }
}
