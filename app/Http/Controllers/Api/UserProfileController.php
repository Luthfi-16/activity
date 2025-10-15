<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends Controller
{
    // 🧩 Tampilkan profile user yang login
    public function myProfile()
    {
        $user = Auth::user();
        $profile = $user->profile;

        return response()->json([
            'success' => true,
            'message' => 'My Profile',
            'data'    => [
                'user'    => $user,
                'profile' => $profile,
            ],
        ], 200);
    }

    // 🧩 Simpan profile baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik'        => 'required|string|max:20|unique:user_profiles,nik',
            'name'       => 'required|string|max:255',
            'gender'     => 'required|in:L,P',
            'birthplace' => 'required|string|max:255',
            'birthday'   => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $profile = UserProfile::create([
            'nik'        => $request->nik,
            'name'       => $request->name,
            'gender'     => $request->gender,
            'birthplace' => $request->birthplace,
            'birthday'   => $request->birthday,
            'user_id'    => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Profile created successfully',
            'data'    => $profile,
        ], 201);
    }

    // 🧩 Update profile user login
    public function update(Request $request)
    {
        $profile = Auth::user()->profile;

        if (!$profile) {
            return response()->json([
                'success' => false,
                'message' => 'Profile not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nik'        => 'required|string|max:20|unique:user_profiles,nik,' . $profile->id,
            'name'       => 'required|string|max:255',
            'gender'     => 'required|in:L,P',
            'birthplace' => 'required|string|max:255',
            'birthday'   => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $profile->update([
            'nik'        => $request->nik,
            'name'       => $request->name,
            'gender'     => $request->gender,
            'birthplace' => $request->birthplace,
            'birthday'   => $request->birthday,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data'    => $profile,
        ], 200);
    }
}
