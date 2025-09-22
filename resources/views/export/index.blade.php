@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
@endsection

@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">Fieldwork / <span class="text-muted">Export</span></h4>

  <!-- Filter & Tombol Export -->
  <div class="card mb-3">
    <div class="card-body">
      <form method="GET" action="{{ route('fieldwork.export') }}" class="row g-2 align-items-end">
        <div class="col-md-3">
          <label for="awal" class="form-label">Tanggal Awal</label>
          <input type="date" name="awal" id="awal" class="form-control" value="{{ request('awal') }}">
        </div>
        <div class="col-md-3">
          <label for="akhir" class="form-label">Tanggal Akhir</label>
          <input type="date" name="akhir" id="akhir" class="form-control" value="{{ request('akhir') }}">
        </div>
        <div class="col-md-6 d-flex gap-2">
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-search"></i> Cari
          </button>
          <a href="{{ route('fieldwork.export') }}" class="btn btn-secondary">Reset</a>

          @if(request('awal') && request('akhir'))
            <a href="{{ route('fieldwork.export.excel', ['awal' => request('awal'), 'akhir' => request('akhir')]) }}" 
               class="btn btn-success">
              <i class="bi bi-file-earmark-excel"></i> Export Excel
            </a>

            <a href="{{ route('fieldwork.export.pdf', ['awal' => request('awal'), 'akhir' => request('akhir')]) }}" 
               class="btn btn-danger">
              <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </a>
          @endif
        </div>
      </form>
    </div>
  </div>

  <!-- Hasil Data -->
  @if(isset($fieldworks) && count($fieldworks) > 0)
  <div class="card">
    <div class="card-header">
      <h5 class="mb-0">Result</h5>
    </div>

    <div class="table-responsive text-nowrap">
      <table id="dataFieldwork" class="table table-bordered">
        <thead class="table-light">
          <tr>
            <th>No</th>
            <th>Branch</th>
            <th>Category</th>
            <th>Description</th>
            <th>Note</th>
            <th>Status</th>
            <th>Created At</th>
          </tr>
        </thead>
        <tbody>
          @php $no = 1; @endphp
          @foreach($fieldworks as $fw)
          <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $fw->branch?->name ?? '-' }}</td>
            <td>{{ $fw->category?->name ?? '-' }}</td>
            <td>{{ Str::limit($fw->description, 20) }}</td>
            <td>{{ $fw->note ?? '-' }}</td>
            <td>{{ $fw->status ?? '-' }}</td>
            <td>{{ $fw->created_at->format('Y-m-d') }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>
<script>
  new DataTable('#dataFieldwork');
</script>
@endpush
