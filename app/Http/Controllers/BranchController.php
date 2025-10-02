<?php
namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Region;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::with('region')->latest()->get();
        return view('branch.index', compact('branches'));
    }

    public function create()
    {
        $regions = Region::all();
        return view('branch.create', compact('regions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'address'   => 'required|string|max:255',
            'region_id' => 'required|exists:regions,id',
        ]);

        $branch            = new Branch();
        $branch->name      = $request->name;
        $branch->address   = $request->address;
        $branch->region_id = $request->region_id;
        
        $branch->save();
        Alert::success('Success', 'Data added successfully');
        return redirect()->route('branch.index');
    }

    public function show(string $id)
    {
        $branch = Branch::with('region')->findOrFail($id);
        return view('branch.show', compact('branch'));
    }

    public function edit(string $id)
    {
        $branch  = Branch::findOrFail($id);
        $regions = Region::all();
        return view('branch.edit', compact('branch', 'regions'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'address'   => 'required|string|max:255',
            'region_id' => 'required|exists:regions,id',
        ]);

        $branch            = Branch::findOrFail($id);
        $branch->name      = $request->name;
        $branch->address   = $request->address;
        $branch->region_id = $request->region_id;

        $branch->save();
        Alert::success('Success', 'Data edited successfully');
        return redirect()->route('branch.index');
    }

    public function destroy(string $id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();
        Alert::success('Deleted', 'Data deleted successfully');
        return redirect()->route('branch.index');
    }


     public function getByRegion($region_id)
    {
        $branches = Branch::where('region_id', $region_id)->get();
        return response()->json($branches);
    }
}
