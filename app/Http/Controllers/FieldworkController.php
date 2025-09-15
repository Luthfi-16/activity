<?php
namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Fieldwork;
use App\Models\FieldworkCategory;
use App\Models\FieldworkStatus;
use Illuminate\Http\Request;

class FieldworkController extends Controller
{
    /**
     * Tampilkan semua data fieldwork
     */
    public function index()
    {
        $fieldwork = Fieldwork::with(['branch', 'category', 'status'])->latest()->get();
        return view('fieldwork.index', compact('fieldwork'));
    }

    /**
     * Form tambah data
     */
    public function create()
    {
        $branches   = Branch::all();
        $categories = FieldworkCategory::all();
        $statuses   = FieldworkStatus::all();

        return view('fieldwork.create', compact('branches', 'categories', 'statuses'));
    }

    /**
     * Simpan data baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'note'        => 'nullable|string',
            'branch_id'   => 'required|exists:branches,id',
            'category_id' => 'required|exists:fieldwork_categories,id',
            'status_id'   => 'required|exists:fieldwork_statuses,id',
        ]);

        Fieldwork::create($validated);

        return redirect()->route('fieldwork.index')
            ->with('success', 'Fieldwork berhasil ditambahkan');
    }

    /**
     * Detail satu data
     */
    public function show(Fieldwork $fieldwork)
    {
        $fieldwork->load(['branch', 'category', 'status']);
        return view('fieldwork.show', compact('fieldwork'));
    }

    /**
     * Form edit data
     */
    public function edit(Fieldwork $fieldwork)
    {
        $branches   = Branch::all();
        $categories = FieldworkCategory::all();
        $statuses   = FieldworkStatus::all();

        return view('fieldwork.edit', compact('fieldwork', 'branches', 'categories', 'statuses'));
    }

    /**
     * Update data
     */
    public function update(Request $request, Fieldwork $fieldwork)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'note'        => 'nullable|string',
            'branch_id'   => 'required|exists:branches,id',
            'category_id' => 'required|exists:fieldwork_categories,id',
            'status_id'   => 'required|exists:fieldwork_statuses,id',
        ]);

        $fieldwork->update($validated);

        return redirect()->route('fieldwork.index')
            ->with('success', 'Fieldwork berhasil diupdate');
    }

    /**
     * Hapus data
     */
    public function destroy(Fieldwork $fieldwork)
    {
        $fieldwork->delete();

        return redirect()->route('fieldwork.index')
            ->with('success', 'Fieldwork berhasil dihapus');
    }
}
