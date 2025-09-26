<?php
namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class UserProfileController extends Controller
{
    // Halaman utama profile user yang login
    public function myProfile()
    {
        $user    = auth()->user();
        $profile = $user->profile; // relasi hasOne di model User

        return view('profile.index', compact('user', 'profile'));
    }

    // Form create (kalau belum punya profile)
    public function create()
    {
        return view('profile.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik'        => 'required|string|max:20|unique:user_profiles,nik',
            'name'       => 'required|string|max:255',
            'gender'     => 'required|in:L,P',
            'birthplace' => 'required|string|max:255',
            'birthday'   => 'required|date',
        ]);

        $profile             = new UserProfile();
        $profile->nik        = $request->nik;
        $profile->name       = $request->name;
        $profile->gender     = $request->gender;
        $profile->birthplace = $request->birthplace;
        $profile->birthday   = $request->birthday;
        $profile->user_id    = auth()->id(); // otomatis dari user login
        $profile->save();

        Alert::success('Success', 'Profile created.');
        return redirect()->route('profile'); // balik ke halaman profile
    }

    public function edit()
    {
        $profile = auth()->user()->profile;
        return view('profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = auth()->user()->profile;

        $request->validate([
            'nik'        => 'required|string|max:20|unique:user_profiles,nik,' . $profile->id,
            'name'       => 'required|string|max:255',
            'gender'     => 'required|in:L,P',
            'birthplace' => 'required|string|max:255',
            'birthday'   => 'required|date',
        ]);

        $profile->nik        = $request->nik;
        $profile->name       = $request->name;
        $profile->gender     = $request->gender;
        $profile->birthplace = $request->birthplace;
        $profile->birthday   = $request->birthday;
        $profile->save();

        Alert::success('Success', 'Profile updated.');
        return redirect()->route('profile');
    }
}
