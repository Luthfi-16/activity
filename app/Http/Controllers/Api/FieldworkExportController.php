<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fieldwork;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class FieldworkExportController extends Controller
{
    // 🧩 GET: /api/fieldwork/export
    // Ambil data fieldwork dengan optional filter tanggal
    public function index(Request $request)
    {
        $awal  = $request->awal;
        $akhir = $request->akhir;

        $query = Fieldwork::with(['branch', 'category', 'users']);

        if ($awal && $akhir) {
            $query->whereBetween('start_date', [$awal, $akhir]);
        }

        $fieldworks = $query->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Data fieldwork berhasil diambil',
            'data'    => $fieldworks,
        ], 200);
    }

    // 📊 GET: /api/fieldwork/export/excel
    public function exportExcel(Request $request)
    {
        $awal  = $request->awal;
        $akhir = $request->akhir;

        $query = Fieldwork::with(['branch', 'category', 'users']);

        if ($awal && $akhir) {
            $query->whereBetween('start_date', [$awal, $akhir]);
        }

        $fieldworks = $query->get();

        // buat konten HTML untuk Excel
        $html = view('export.excel', compact('fieldworks'))->render();

        $filename = 'laporan_fieldwork_' . now()->format('Ymd_His') . '.xls';

        return Response::make($html, 200, [
            'Content-Type'        => 'application/vnd.ms-excel',
            'Content-Disposition' => "attachment; filename=$filename",
        ]);
    }

    // 📄 GET: /api/fieldwork/export/pdf
    public function exportPdf(Request $request)
    {
        $awal  = $request->awal;
        $akhir = $request->akhir;

        $query = Fieldwork::with(['branch', 'category', 'users']);

        if ($awal && $akhir) {
            $query->whereBetween('start_date', [$awal, $akhir]);
        }

        $fieldworks = $query->get();

        $pdf = Pdf::loadView('export.pdf', compact('fieldworks', 'awal', 'akhir'))
            ->setPaper('a4', 'landscape');

        $filename = 'laporan_fieldwork_' . now()->format('Ymd_His') . '.pdf';

        return $pdf->download($filename);
    }
}
