<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Region;
use App\Models\Branch;
use App\Models\Fieldwork;


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

        return view('home', compact('totalUsers', 'totalBranches', 'totalFieldwork', 'totalRegions'));
    }
}
