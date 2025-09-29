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

  <!-- Fieldwork per Bulan + Fieldwork by Status -->
  <div class="row mt-4">
    <!-- Fieldwork per Bulan -->
    <div class="col-md-8">
      <div class="card shadow-sm p-3" style="height: 380px;">
        <h5 class="mb-3">Total Fieldwork per Bulan ({{ date('Y') }})</h5>
        <canvas id="fieldworkChart" style="height: 280px !important;"></canvas>
      </div>
    </div>

    <!-- Fieldwork by Status -->
    <div class="col-md-4">
      <div class="card shadow-sm p-3 d-flex align-items-center justify-content-center" style="height: 380px;">
        <h5 class="mb-3">Fieldwork by Status</h5>
        <canvas id="statusChart" style="height: 280px !important; width:100%"></canvas>
      </div>
    </div>
  </div>

  <!-- Branches per Region -->
  <div class="row mt-4">
    <div class="col-md-12">
      <div class="card shadow-sm p-3">
        <h5 class="mb-3">Branches per Region</h5>
        <canvas id="branchesChart" height="200"></canvas>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@2.0.0"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    // ================================
    // Fieldwork per Bulan (Line Chart)
    // ================================
    const ctx = document.getElementById('fieldworkChart').getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(16,185,129,0.4)');
    gradient.addColorStop(1, 'rgba(16,185,129,0)');

    const chartData = @json($chartData);
    const months = @json($months);

    // Tentukan range default (semester)
    const currentMonth = new Date().getMonth() + 1; // Jan=1
    let minIndex = 0;
    let maxIndex = 5;

    if (currentMonth > 6) {
      minIndex = 6; // Jul
      maxIndex = 11; // Dec
    }

    const fieldworkChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: months,
        datasets: [{
          label: 'Fieldwork',
          data: chartData,
          borderColor: '#10b981',
          backgroundColor: gradient,
          borderWidth: 2.5,
          tension: 0.4,
          fill: true,
          pointBackgroundColor: '#10b981',
          pointBorderColor: '#10b981',
          pointBorderWidth: 2,
          pointRadius: 0,
          pointHoverRadius: 7,
          clip: {left: 0, right: 0, top: 10, bottom: 10}
        }]
      },
      options: {
        responsive: true,
        interaction: { mode: 'nearest', intersect: false },
        plugins: { 
          legend: { display: false },
          zoom: {
            pan: { enabled: true, mode: 'x' },
            zoom: { wheel: { enabled: true }, pinch: { enabled: true }, mode: 'x' },
          }
        },
        scales: {
          x: {
            grid: { display: false },
            ticks: { color: '#6b7280' },
            min: minIndex,   // default semester
            max: maxIndex    // default semester
          },
          y: {
            beginAtZero: true,
            suggestedMin: 0,
            suggestedMax: Math.max(...chartData),
            ticks: { precision: 0, color: '#6b7280' },
            grid: { color: '#f3f4f6' }
          }
        }
      }
    });

    // Reset ke 6 bulan default saat double click
    ctx.canvas.addEventListener('dblclick', function() {
      fieldworkChart.resetZoom();
      fieldworkChart.options.scales.x.min = minIndex;
      fieldworkChart.options.scales.x.max = maxIndex;
      fieldworkChart.update();
    });

    // ================================
    // Fieldwork by Status (Doughnut)
    // ================================
    const statusLabels = @json($statusLabels);
    const statusData   = @json($statusData);

    const baseColors = [
      '#f59e0b', '#3b82f6', '#10b981', '#ef4444', '#8b5cf6',
      '#ec4899', '#14b8a6', '#a855f7', '#eab308', '#64748b'
    ];

    const statusColors = statusLabels.map((_, i) => baseColors[i % baseColors.length]);

    new Chart(document.getElementById('statusChart').getContext('2d'), {
      type: 'doughnut',
      data: {
        labels: statusLabels,
        datasets: [{
          data: statusData,
          backgroundColor: statusColors,
          borderWidth: 2,
          borderColor: '#fff'
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { position: 'bottom', labels: { color: '#374151' } },
          tooltip: {
            callbacks: {
              label: function(context) {
                let label = context.label || '';
                let value = context.raw || 0;
                return `${label}: ${value}`;
              }
            }
          }
        }
      }
    });

    // ================================
    // Branches per Region (Bar Chart)
    // ================================
    const regions = @json($regions);
    const branchesData = @json($branchesData);

    new Chart(document.getElementById('branchesChart').getContext('2d'), {
      type: 'bar',
      data: {
        labels: regions,
        datasets: [{
          label: 'Branches',
          data: branchesData,
          backgroundColor: '#6366f1',
          borderRadius: 8
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
          x: { grid: { display: false }, ticks: { color: '#6b7280' } },
          y: {
            beginAtZero: true,
            ticks: { precision: 0, color: '#6b7280' },
            grid: { color: '#f3f4f6' }
          }
        }
      }
    });
  });
</script>
@endpush
