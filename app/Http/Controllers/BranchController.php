<?php
namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Region;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::with('region')->get();
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
            'name'      => 'required|string|max:255',
            'address'   => 'required|string|max:255',
            'region_id' => 'required|exists:regions,id',
        ]);

        Branch::create($request->all());

        return redirect()->route('branch.index')
            ->with('success', 'Branch berhasil ditambahkan.');
    }

    public function show(Branch $branch)
    {
        return view('branch.show', compact('branch'));
    }

    public function edit(Branch $branch)
    {
        $regions = Region::all();
        return view('branch.edit', compact('branch', 'regions'));
    }

    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'address'   => 'required|string|max:255',
            'region_id' => 'required|exists:regions,id',
        ]);

        $branch->update($request->all());

        return redirect()->route('branch.index')
            ->with('success', 'Branch berhasil diperbarui.');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();
        return redirect()->route('branch.index')
            ->with('success', 'Branch berhasil dihapus.');
    }
}
