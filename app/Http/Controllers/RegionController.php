<?php
namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $region = Region::latest()->get();
        return view('region.index', compact('region'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('region.create');
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

        $region       = new Region();
        $region->name = $request->name;
        $region->code = $request->code;

        $region->save();
        session()->flash('success', 'Data berhasil diedit');
        return redirect()->route('region.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $region = Region::findOrFail($id);
        return view('region.show', compact('region'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $region = Region::findOrFail($id);
        return view('region.edit', compact('region'));
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

        $region       = Region::findOrFail($id);
        $region->name = $request->name;
        $region->code = $request->code;

        $region->save();
        session()->flash('success', 'Data berhasil diedit');
        return redirect()->route('region.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $region = Region::findOrFail($id);
        $region->delete();
        return redirect()->route('region.index')->with('success', 'Data Berhasil Dihapus');
    }
}
