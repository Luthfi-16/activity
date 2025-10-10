<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserPhone;
use App\Models\User;
use Illuminate\Http\Request;

class UserPhoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $phones = UserPhone::with('user')->latest()->get();

        return response()->json([
            'success' => true,
            'data'    => $phones,
            'message' => 'List of User Phones retrieved successfully',
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'number'  => 'required|string|max:255',
            'name'    => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $phone = UserPhone::create([
            'number'  => $request->number,
            'name'    => $request->name,
            'user_id' => $request->user_id,
        ]);

        return response()->json([
            'success' => true,
            'data'    => $phone,
            'message' => 'User Phone created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $phone = UserPhone::with('user')->find($id);

        if (! $phone) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $phone,
            'message' => 'User Phone retrieved successfully',
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'number'  => 'required|string|max:255',
            'name'    => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $phone = UserPhone::find($id);

        if (! $phone) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found',
            ], 404);
        }

        $phone->update([
            'number'  => $request->number,
            'name'    => $request->name,
            'user_id' => $request->user_id,
        ]);

        return response()->json([
            'success' => true,
            'data'    => $phone,
            'message' => 'User Phone updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $phone = UserPhone::find($id);

        if (! $phone) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found',
            ], 404);
        }

        $phone->delete();

        return response()->json([
            'success' => true,
            'message' => 'User Phone deleted successfully',
        ], 200);
    }
}
