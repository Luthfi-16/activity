<?php
namespace App\Http\Controllers;

use App\Models\FieldworkStatus;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class FieldworkStatusController extends Controller
{
    public function index()
    {
        $statuses = FieldworkStatus::latest()->get();
        return view('fieldwork_statuses.index', compact('statuses'));
    }

    public function create()
    {
        return view('fieldwork_statuses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $status              = new FieldworkStatus();
        $status->name        = $request->name;
        $status->description = $request->description;
        $status->save();

        Alert::success('Success', 'Status added successfully');
        return redirect()->route('fieldwork_statuses.index');
    }

    public function show(string $id)
    {
        $status = FieldworkStatus::findOrFail($id);
        return view('fieldwork_statuses.show', compact('status'));
    }

    public function edit(string $id)
    {
        $status = FieldworkStatus::findOrFail($id);
        return view('fieldwork_statuses.edit', compact('status'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $status              = FieldworkStatus::findOrFail($id);
        $status->name        = $request->name;
        $status->description = $request->description;
        $status->save();

        Alert::success('Success', 'Status updated successfully');
        return redirect()->route('fieldwork_statuses.index');
    }

    public function destroy(string $id)
    {
        $status = FieldworkStatus::findOrFail($id);
        $status->delete();

        Alert::warning('Deleted', 'Status deleted successfully');
        return redirect()->route('fieldwork_statuses.index');
    }
}
