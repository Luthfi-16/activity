<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = Branch::with('region')->latest()->get();

        return response()->json([
            'success' => true,
            'data'    => $branches,
            'message' => 'List Branches',
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'address'   => 'required|string|max:255',
            'region_id' => 'required|exists:regions,id',
        ]);

        $branch = Branch::create([
            'name'      => $request->name,
            'address'   => $request->address,
            'region_id' => $request->region_id,
        ]);

        return response()->json([
            'success' => true,
            'data'    => $branch,
            'message' => 'Branch Created Successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $branch = Branch::with('region')->find($id);

        if (! $branch) {
            return response()->json([
                'success' => false,
                'message' => 'Data Not Found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $branch,
            'message' => 'Show Branch',
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'address'   => 'required|string|max:255',
            'region_id' => 'required|exists:regions,id',
        ]);

        $branch = Branch::find($id);

        if (! $branch) {
            return response()->json([
                'success' => false,
                'message' => 'Data Not Found',
            ], 404);
        }

        $branch->update([
            'name'      => $request->name,
            'address'   => $request->address,
            'region_id' => $request->region_id,
        ]);

        return response()->json([
            'success' => true,
            'data'    => $branch,
            'message' => 'Branch Updated Successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $branch = Branch::find($id);

        if (! $branch) {
            return response()->json([
                'success' => false,
                'message' => 'Data Not Found',
            ], 404);
        }

        $branch->delete();

        return response()->json([
            'success' => true,
            'message' => 'Branch Deleted Successfully',
        ], 200);
    }

    /**
     * Get branches by region id
     */
    public function getByRegion($region_id)
    {
        $branches = Branch::where('region_id', $region_id)->get();

        return response()->json([
            'success' => true,
            'data'    => $branches,
            'message' => 'Branches by Region',
        ], 200);
    }
}
