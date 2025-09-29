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

  <!-- Grafik Fieldwork -->
  <div class="row mt-4">
    <div class="col-md-12">
      <div class="card shadow-sm p-3">
        <h5 class="mb-3">Total Fieldwork per Bulan ({{ date('Y') }})</h5>
        <canvas id="fieldworkChart" height="100"></canvas>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('fieldworkChart').getContext('2d');

    // Gradient hijau dari atas ke bawah
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(16,185,129,0.4)');
    gradient.addColorStop(1, 'rgba(16,185,129,0)');

    const chartData = @json($chartData);

    // Plugin buat garis crosshair
    const crosshairPlugin = {
      id: 'crosshair',
      afterDraw: (chart) => {
        if (chart.tooltip._active && chart.tooltip._active.length) {
          const ctx = chart.ctx;
          ctx.save();
          const activePoint = chart.tooltip._active[0].element;
          ctx.beginPath();
          ctx.moveTo(activePoint.x, chart.chartArea.top);
          ctx.lineTo(activePoint.x, chart.chartArea.bottom);
          ctx.lineWidth = 1;
          ctx.strokeStyle = '#9ca3af';
          ctx.setLineDash([4, 4]);
          ctx.stroke();
          ctx.restore();
        }
      }
    };

    new Chart(ctx, {
      type: 'line',
      data: {
        labels: @json($months),
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
          pointRadius: 0,               // default ga ada bulatan
          pointHoverRadius: 7,          // muncul kalau di-hover
          clip: false                   // biar buletan ga kepotong atas/bawah
        }]
      },
      options: {
        responsive: true,
        interaction: {
          mode: 'nearest',
          intersect: false
        },
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: '#fff',
            titleColor: '#111827',
            bodyColor: '#10b981',
            borderColor: '#e5e7eb',
            borderWidth: 1,
            padding: 10,
            displayColors: false,
            callbacks: {
              label: function(context) {
                return context.parsed.y;
              }
            }
          }
        },
        scales: {
          x: {
            grid: { display: false },
            ticks: { color: '#6b7280' }
          },
          y: {
            beginAtZero: true,
            suggestedMin: 0,                          // ruang bawah
            suggestedMax: Math.max(...chartData), // ruang atas
            ticks: { precision: 0, color: '#6b7280' },
            grid: { color: '#f3f4f6' }
          }
        },
        // Cursor crosshair
        onHover: (event, chartElement) => {
          event.native.target.style.cursor = chartElement.length ? 'crosshair' : 'default';
        }
      },
      plugins: [crosshairPlugin]
    });
  });
</script>
@endpush
