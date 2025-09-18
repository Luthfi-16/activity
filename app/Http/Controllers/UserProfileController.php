<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class UserProfileController extends Controller
{
    public function index()
    {
        $userprofile = UserProfile::with('user')->latest()->get();
        return view('userprofile.index', compact('userprofile'));
    }

    public function create()
    {
        $users = User::all();
        return view('userprofile.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik'        => 'required|string|max:20|unique:user_profiles,nik',
            'name'       => 'required|string|max:255',
            'gender'     => 'required|in:L,P',
            'birthplace' => 'required|string|max:255',
            'birthday'   => 'required|date',
            'user_id'    => 'required|exists:users,id',
        ]);

        $userprofile             = new UserProfile();
        $userprofile->nik        = $request->nik;
        $userprofile->name       = $request->name;
        $userprofile->gender     = $request->gender;
        $userprofile->birthplace = $request->birthplace;
        $userprofile->birthday   = $request->birthday;
        $userprofile->user_id    = $request->user_id;
        $userprofile->save();

        Alert::success('Success', 'Profile created.');
        return redirect()->route('userprofile.index');
    }

    public function show(string $id)
    {
        $userprofile = UserProfile::with('user')->findOrFail($id);
        return view('userprofile.show', compact('userprofile'));
    }

    public function edit(string $id)
    {
        $userprofile = UserProfile::findOrFail($id);
        $users       = User::all();
        return view('userprofile.edit', compact('userprofile', 'users'));
    }

    public function update(Request $request, string $id)
    {
        $userprofile = UserProfile::findOrFail($id);

        $request->validate([
            'nik'        => 'required|string|max:20|unique:user_profiles,nik,' . $userprofile->id,
            'name'       => 'required|string|max:255',
            'gender'     => 'required|in:L,P',
            'birthplace' => 'required|string|max:255',
            'birthday'   => 'required|date',
            'user_id'    => 'required|exists:users,id',
        ]);

        $userprofile->nik        = $request->nik;
        $userprofile->name       = $request->name;
        $userprofile->gender     = $request->gender;
        $userprofile->birthplace = $request->birthplace;
        $userprofile->birthday   = $request->birthday;
        $userprofile->user_id    = $request->user_id;
        $userprofile->save();

        Alert::success('Success', 'Profile updated.');
        return redirect()->route('userprofile.index');
    }

    public function destroy(string $id)
    {
        $userprofile = UserProfile::findOrFail($id);
        $userprofile->delete();

        Alert::warning('Deleted', 'Profile deleted.');
        return redirect()->route('userprofile.index');
    }
}
