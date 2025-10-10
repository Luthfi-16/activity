<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FieldworkCategory;
use Illuminate\Http\Request;

class FieldworkCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = FieldworkCategory::latest()->get();

        return response()->json([
            'success' => true,
            'data'    => $categories,
            'message' => 'List Fieldwork Categories',
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

        $category = FieldworkCategory::create([
            'name'        => $request->name,
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'data'    => $category,
            'message' => 'Fieldwork Category Created Successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = FieldworkCategory::find($id);

        if (! $category) {
            return response()->json([
                'success' => false,
                'message' => 'Data Not Found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $category,
            'message' => 'Show Fieldwork Category',
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

        $category = FieldworkCategory::find($id);

        if (! $category) {
            return response()->json([
                'success' => false,
                'message' => 'Data Not Found',
            ], 404);
        }

        $category->update([
            'name'        => $request->name,
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'data'    => $category,
            'message' => 'Fieldwork Category Updated Successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = FieldworkCategory::find($id);

        if (! $category) {
            return response()->json([
                'success' => false,
                'message' => 'Data Not Found',
            ], 404);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Fieldwork Category Deleted Successfully',
        ], 200);
    }
}
