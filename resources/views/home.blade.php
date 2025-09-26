@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row g-3">
    <!-- Total Users -->
    <div class="col-md-3">
      <div class="card shadow-sm d-flex align-items-center justify-content-center" 
           style="height: 150px; border-radius: 20px; background-color:#6366f1;">
        <div class="card-body text-center d-flex flex-column justify-content-center">
          <i class="bi bi-people-fill text-white" style="font-size: 2.2rem;"></i>
          <h6 class="mt-2 text-white">Total Users</h6>
          <h2 class="fw-bold text-white">{{ $totalUsers ?? 0 }}</h2>
        </div>
      </div>
    </div>

    <!-- Total Branches -->
    <div class="col-md-3">
      <div class="card shadow-sm d-flex align-items-center justify-content-center" 
           style="height: 150px; border-radius: 20px; background-color:#f59e0b;">
        <div class="card-body text-center d-flex flex-column justify-content-center">
          <i class="bi bi-diagram-3-fill text-white" style="font-size: 2.2rem;"></i>
          <h6 class="mt-2 text-white">Total Branches</h6>
          <h2 class="fw-bold text-white">{{ $totalBranches ?? 0 }}</h2>
        </div>
      </div>
    </div>

    <!-- Total Fieldwork -->
    <div class="col-md-3">
      <div class="card shadow-sm d-flex align-items-center justify-content-center" 
           style="height: 150px; border-radius: 20px; background-color:#10b981;">
        <div class="card-body text-center d-flex flex-column justify-content-center">
          <i class="bi bi-clipboard-check-fill text-white" style="font-size: 2.2rem;"></i>
          <h6 class="mt-2 text-white">Total Fieldwork</h6>
          <h2 class="fw-bold text-white">{{ $totalFieldwork ?? 0 }}</h2>
        </div>
      </div>
    </div>

    <!-- Total Regions -->
    <div class="col-md-3">
      <div class="card shadow-sm d-flex align-items-center justify-content-center" 
           style="height: 150px; border-radius: 20px; background-color:#ef4444;">
        <div class="card-body text-center d-flex flex-column justify-content-center">
          <i class="bi bi-globe2 text-white" style="font-size: 2.2rem;"></i>
          <h6 class="mt-2 text-white">Total Regions</h6>
          <h2 class="fw-bold text-white">{{ $totalRegions ?? 0 }}</h2>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
