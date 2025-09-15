<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPhone;
use Illuminate\Http\Request;

class UserPhoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userphone = UserPhone::all();
        return view('userphone.index', compact('userphone'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::all();
        return view('userphone.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'number'  => 'required|string|max:255',
            'name'    => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        UserPhone::create($validated);

        return redirect()->route('userphone.index')->with('success', 'User Phone berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $userphone = UserPhone::findOrFail($id);
        return view('userphone.show', compact('userphone'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserPhone $userphone)
    {
        $user = User::all();
        return view('userphone.edit', compact('userphone', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserPhone $userphone)
    {
        $validated = $request->validate([
            'number'  => 'required|string|max:255',
            'name'    => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $userphone->update($validated);

        return redirect()->route('userphone.index')->with('success', 'User Phone berhasil ditambahkan');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserPhone $userphone)
    {
        $userphone->delete();

        return redirect()->route('userphone.index')
            ->with('success', 'Region berhasil dihapus.');

    }
}
