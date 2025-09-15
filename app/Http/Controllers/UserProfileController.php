<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userprofile = UserProfile::with('user')->get();
        return view('userprofile.index', compact('userprofile'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all(); // buat pilihan user
        return view('userprofile.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
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

        UserProfile::create($request->all());

        return redirect()->route('userprofile.index')
            ->with('success', 'User profile created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $userprofile = UserProfile::with('user')->findOrFail($id);
        return view('userprofile.show', compact('userprofile'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $userprofile = UserProfile::findOrFail($id);
        $users       = User::all();
        return view('userprofile.edit', compact('userprofile', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
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

        $userprofile->update($request->all());

        return redirect()->route('userprofile.index')
            ->with('success', 'User profile updated successfully.');
    }

   
}
