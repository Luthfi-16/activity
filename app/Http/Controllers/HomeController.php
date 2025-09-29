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
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
{
    $totalUsers     = User::count();
    $totalBranches  = Branch::count();
    $totalFieldwork = Fieldwork::count();
    $totalRegions   = Region::count();

    // Hitung fieldwork per bulan (tahun berjalan)
    $fieldworkPerMonth = Fieldwork::select(
            DB::raw('MONTH(start_date) as month'),
            DB::raw('COUNT(*) as total')
        )
        ->whereYear('start_date', date('Y'))
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total','month')
        ->toArray();

    // Buat array 12 bulan (Jan–Dec)
    $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    $chartData = [];
    foreach (range(1,12) as $m) {
        $chartData[] = $fieldworkPerMonth[$m] ?? 0; // kalau ga ada, isi 0
    }

    return view('home', compact(
        'totalUsers',
        'totalBranches',
        'totalFieldwork',
        'totalRegions',
        'months',
        'chartData'
    ));
}
}
