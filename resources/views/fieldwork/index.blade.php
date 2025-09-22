@extends('layouts.app')
@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
@endsection
@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">Fieldwork / <span class="text-muted">List</span></h4>

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Fieldwork</h5>
      <div class="d-flex align-items-center gap-2">
        <a href="{{ route('fieldwork.create') }}" class="btn btn-primary">+ Add Fieldwork</a>
        <a href="{{ route('fieldwork.export') }}" class="btn btn-secondary">Export Fieldwork</a>
      </div>
    </div>

    <div class="table-responsive text-nowrap">
      <table id="dataFieldwork" class="table">
        <thead class="table-light">
          <tr>
            <th>No</th>
            <th>Branch</th>
            <th>Category</th>
            <th>Description</th>
            <th>Note</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @php $no = 1; @endphp
          @foreach($fieldwork as $fw)
          <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $fw->branch?->name ?? '-' }}</td>
            <td>{{ $fw->category?->name ?? '-' }}</td>
            <td>{{ Str::limit($fw->description, 20)}}</td>
            <td>{{ $fw->note ?? '-' }}</td>
            @if($fw->status == "pending")
              <td><span class="badge bg-secondary">Pending</span></td>
            @elseif($fw->status == "on_progres")
              <td><span class="badge bg-warning">On Progres</span></td>
            @elseif($fw->status == "done")
              <td><span class="badge bg-success">Done</span></td>
            @elseif($fw->status == "cancel")
              <td><span class="badge bg-danger">Cancel</span></td>
              
            @endif
            <td>{{ $fw->created_at->format('Y-m-d') }}</td>
            <td>
              <a href="{{ route('fieldwork.show', $fw->id) }}" class="btn btn-sm btn-info">Show</a>
              <a href="{{ route('fieldwork.edit', $fw->id) }}" class="btn btn-sm btn-warning">Edit</a>
              <form action="{{ route('fieldwork.destroy', $fw->id) }}" method="POST" class="delete-form d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>    
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>
<script>
  new DataTable('#dataFieldwork');
</script>
@endpush
