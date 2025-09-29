<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Region;
use App\Models\Branch;
use App\Models\Fieldwork;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $totalUsers     = User::count();
        $totalBranches  = Branch::count();
        $totalFieldwork = Fieldwork::count();
        $totalRegions   = Region::count();

        // ==================================
        // Fieldwork per Bulan (tahun berjalan)
        // ==================================
        $fieldworkPerMonth = Fieldwork::select(
                DB::raw('MONTH(start_date) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('start_date', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total','month')
            ->toArray();

        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        $chartData = [];
        foreach (range(1,12) as $m) {
            $chartData[] = $fieldworkPerMonth[$m] ?? 0;
        }

        // ==================================
        // Branches per Region
        // ==================================
        $regions = Region::pluck('name');
        $branchesData = Region::withCount('branches')->pluck('branches_count');

        // ==================================
        // Fieldwork by Status
        // ==================================
        $fieldworkByStatus = Fieldwork::join('fieldwork_statuses', 'fieldworks.status_id', '=', 'fieldwork_statuses.id')
        ->select('fieldwork_statuses.name as status', DB::raw('COUNT(*) as total'))
        ->groupBy('fieldwork_statuses.name')
        ->pluck('total', 'status')
        ->toArray();

        $statusLabels = array_keys($fieldworkByStatus);
        $statusData   = array_values($fieldworkByStatus);



        return view('home', compact(
            'totalUsers',
            'totalBranches',
            'totalFieldwork',
            'totalRegions',
            'months',
            'chartData',
            'regions',
            'branchesData',
            'statusLabels',
            'statusData',
        ));
    }
}
