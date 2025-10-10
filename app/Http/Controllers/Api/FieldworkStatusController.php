<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FieldworkStatus;
use Illuminate\Http\Request;

class FieldworkStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = FieldworkStatus::latest()->get();

        return response()->json([
            'success' => true,
            'data'    => $statuses,
            'message' => 'List Fieldwork Statuses',
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $status = FieldworkStatus::create([
            'name'        => $request->name,
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'data'    => $status,
            'message' => 'Fieldwork Status Created Successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $status = FieldworkStatus::find($id);

        if (! $status) {
            return response()->json([
                'success' => false,
                'message' => 'Data Not Found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $status,
            'message' => 'Show Fieldwork Status',
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $status = FieldworkStatus::find($id);

        if (! $status) {
            return response()->json([
                'success' => false,
                'message' => 'Data Not Found',
            ], 404);
        }

        $status->update([
            'name'        => $request->name,
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'data'    => $status,
            'message' => 'Fieldwork Status Updated Successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $status = FieldworkStatus::find($id);

        if (! $status) {
            return response()->json([
                'success' => false,
                'message' => 'Data Not Found',
            ], 404);
        }

        $status->delete();

        return response()->json([
            'success' => true,
            'message' => 'Fieldwork Status Deleted Successfully',
        ], 200);
    }
}
