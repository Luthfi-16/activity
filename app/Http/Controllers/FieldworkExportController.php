<?php
namespace App\Http\Controllers;

use App\Models\Fieldwork;
use Illuminate\Http\Request;

class FieldworkExportController extends Controller
{
    // Halaman Export
    public function index(Request $request)
    {
        $awal  = $request->awal;
        $akhir = $request->akhir;

        $fieldworks = collect();

        if ($awal && $akhir) {
            $fieldworks = Fieldwork::with(['branch', 'category', 'status', 'users'])
                ->whereBetween('start_date', [$awal, $akhir])
                ->get();
        }

        return view('export.index', compact('fieldworks', 'awal', 'akhir'));
    }

    // Export Excel
    public function excel(Request $request)
    {
        $awal  = $request->awal;
        $akhir = $request->akhir;

        $query = Fieldwork::with(['branch', 'category', 'status', 'users']);

        if ($awal && $akhir) {
            $query->whereBetween('start_date', [$awal, $akhir]);
        }

        $fieldworks = $query->get();

        $filename = 'laporan_fieldwork_' . now()->format('Ymd_His') . '.xls';

        return response()->view('export.excel', compact('fieldworks'))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', "attachment; filename=$filename");
    }
}
