<?php
namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Fieldwork;
use App\Models\FieldworkCategory;
use App\Models\FieldworkStatus;
use App\Models\User;
use Illuminate\Http\Request;

class FieldworkController extends Controller
{
    public function index()
    {
        $fieldwork = Fieldwork::with(['branch', 'category', 'status', 'users'])
            ->latest()
            ->get();

        return view('fieldwork.index', compact('fieldwork'));
    }

    public function create()
    {
        $branches   = Branch::all();
        $categories = FieldworkCategory::all();
        $statuses   = FieldworkStatus::all();
        $users      = User::all(); // staff yang bisa dipilih

        return view('fieldwork.create', compact('branches', 'categories', 'statuses', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'note'        => 'nullable|string',
            'branch_id'   => 'required|exists:branches,id',
            'category_id' => 'required|exists:fieldwork_categories,id',
            'status_id'   => 'required|exists:fieldwork_statuses,id',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'users'       => 'required|array', // staff wajib diisi
            'users.*'     => 'exists:users,id',
        ]);

        // simpan fieldwork
        $fieldwork = Fieldwork::create([
            'description' => $request->description,
            'note'        => $request->note,
            'branch_id'   => $request->branch_id,
            'category_id' => $request->category_id,
            'status_id'   => $request->status_id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
        ]);

        // simpan ke pivot user_fieldworks
        $fieldwork->users()->sync($request->users);
        session()->flash('success', 'Fieldwork berhasil ditambahkan');
        return redirect()->route('fieldwork.index');
    }

    public function show(string $id)
    {
        $fieldwork = Fieldwork::with(['branch', 'category', 'status', 'users'])->findOrFail($id);
        return view('fieldwork.show', compact('fieldwork'));
    }

    public function edit(string $id)
    {
        $fieldwork  = Fieldwork::with('users')->findOrFail($id);
        $branches   = Branch::all();
        $categories = FieldworkCategory::all();
        $statuses   = FieldworkStatus::all();
        $users      = User::all();

        return view('fieldwork.edit', compact('fieldwork', 'branches', 'categories', 'statuses', 'users'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'note'        => 'nullable|string',
            'branch_id'   => 'required|exists:branches,id',
            'category_id' => 'required|exists:fieldwork_categories,id',
            'status_id'   => 'required|exists:fieldwork_statuses,id',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'users'       => 'required|array',
            'users.*'     => 'exists:users,id',
        ]);

        $fieldwork = Fieldwork::findOrFail($id);
        $fieldwork->update([
            'description' => $request->description,
            'note'        => $request->note,
            'branch_id'   => $request->branch_id,
            'category_id' => $request->category_id,
            'status_id'   => $request->status_id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
        ]);

        // update pivot user_fieldworks
        $fieldwork->users()->sync($request->users);
        session()->flash('success', 'Fieldwork berhasil diupdate');
        return redirect()->route('fieldwork.index');
    }

    public function destroy(string $id)
    {
        $fieldwork = Fieldwork::findOrFail($id);
        $fieldwork->delete();

        session()->flash('success', 'Fieldwork berhasil dihapus');
        return redirect()->route('fieldwork.index');
    }
}
