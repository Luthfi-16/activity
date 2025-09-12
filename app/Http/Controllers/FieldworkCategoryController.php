<?php
namespace App\Http\Controllers;

use App\Models\FieldworkCategory;
use Illuminate\Http\Request;

class FieldworkCategoryController extends Controller
{
    public function index()
    {
        $category = FieldworkCategory::all();
        return view('fieldwork_category.index', compact('category'));
    }

    public function create()
    {
        return view('fieldwork_category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required',
            'description' => 'nullable',
        ]);

        FieldworkCategory::create($request->all());
        return redirect()->route('fieldwork_category.index')
            ->with('success', 'Category berhasil ditambahkan!');
    }

    public function show(FieldworkCategory $category)
    {
        return view('fieldwork_category.show', compact('category'));
    }

    public function edit(FieldworkCategory $category)
    {
        return view('fieldwork_category.edit', compact('category'));
    }

    public function update(Request $request, FieldworkCategory $category)
    {
        $request->validate([
            'name'        => 'required',
            'description' => 'nullable',
        ]);

        $category->update($request->all());
        return redirect()->route('fieldwork_category.index')
            ->with('success', 'Category berhasil diperbarui!');
    }

    public function destroy(FieldworkCategory $fieldwork_category)
    {
        $fieldwork_category->delete();
        return redirect()->route('fieldwork_category.index')
            ->with('success', 'Category berhasil dihapus!');
    }
}
