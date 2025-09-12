<?php
namespace App\Http\Controllers;

use App\Models\FieldworkStatus;
use Illuminate\Http\Request;

class FieldworkStatusController extends Controller
{
    public function index()
    {
        $statuses = FieldworkStatus::all();
        return view('fieldwork_statuses.index', compact('statuses'));
    }

    public function create()
    {
        return view('fieldwork_statuses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required',
            'description' => 'nullable',
        ]);

        FieldworkStatus::create($request->all());
        return redirect()->route('fieldwork_statuses.index')->with('success', 'Status berhasil ditambahkan!');
    }

    public function show(FieldworkStatus $fieldwork_status)
    {
        return view('fieldwork_statuses.show', compact('fieldwork_status'));
    }

    public function edit(FieldworkStatus $fieldwork_status)
    {
        return view('fieldwork_statuses.edit', compact('fieldwork_status'));
    }

    public function update(Request $request, FieldworkStatus $fieldwork_status)
    {
        $request->validate([
            'name'        => 'required',
            'description' => 'nullable',
        ]);

        $fieldwork_status->update($request->all());
        return redirect()->route('fieldwork_statuses.index')->with('success', 'Status berhasil diperbarui!');
    }

    public function destroy(FieldworkStatus $fieldwork_status)
    {
        $fieldwork_status->delete();
        return redirect()->route('fieldwork_statuses.index')->with('success', 'Status berhasil dihapus!');
    }
}
