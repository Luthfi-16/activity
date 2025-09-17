<?php
namespace App\Http\Controllers;

use App\Models\FieldworkCategory;
use Illuminate\Http\Request;

class FieldworkCategoryController extends Controller
{
    public function index()
    {
        $categories = FieldworkCategory::latest()->get();
        return view('fieldwork_category.index', compact('categories'));
    }

    public function create()
    {
        return view('fieldwork_category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category              = new FieldworkCategory();
        $category->name        = $request->name;
        $category->description = $request->description;

        $category->save();
        session()->flash('success', 'Data berhasil diedit');
        return redirect()->route('fieldwork_category.index');
    }

    public function show(string $id)
    {
        $category = FieldworkCategory::findOrFail($id);
        return view('fieldwork_category.show', compact('category'));
    }

    public function edit(string $id)
    {
        $category = FieldworkCategory::findOrFail($id);
        return view('fieldwork_category.edit', compact('category'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category              = FieldworkCategory::findOrFail($id);
        $category->name        = $request->name;
        $category->description = $request->description;

        $category->save();
        session()->flash('success', 'Data berhasil diedit');
        return redirect()->route('fieldwork_category.index');
    }

    public function destroy(string $id)
    {
        $category = FieldworkCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('fieldwork_category.index')->with('success', 'Data Berhasil Dihapus');
    }
}
