<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $region = Region::latest()->get();

        return response()->json([
            'success' => true,
            'data'    => $region,
            'message' => 'List Region',
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:regions,code',
        ]);

        $region = Region::create([
            'name' => $request->name,
            'code' => $request->code,
        ]);

        return response()->json([
            'success' => true,
            'data'    => $region,
            'message' => 'Region Created Successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $region = Region::find($id);

        if (! $region) {
            return response()->json([
                'success' => false,
                'message' => 'Data Not Found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $region,
            'message' => 'Show Region',
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:regions,code,' . $id,
        ]);

        $region = Region::find($id);
        if (! $region) {
            return response()->json([
                'success' => false,
                'message' => 'Data Not Found',
            ], 404);
        }

        $region->update([
            'name' => $request->name,
            'code' => $request->code,
        ]);

        return response()->json([
            'success' => true,
            'data'    => $region,
            'message' => 'Region Updated Successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $region = Region::find($id);

        if (! $region) {
            return response()->json([
                'success' => false,
                'message' => 'Data Not Found',
            ], 404);
        }

        $region->delete();

        return response()->json([
            'success' => true,
            'message' => 'Region Deleted Successfully',
        ], 200);
    }
}
