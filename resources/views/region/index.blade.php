@extends('layouts.app')
@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
@endsection
@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">Regions / <span class="text-muted">List</span></h4>

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Regions</h5>
      <a href="{{ route('region.create') }}" class="btn btn-primary">+ Add Region</a>
    </div>
    <div class="table-responsive text-nowrap">
      <table id="dataRegion" class="table">
        <thead class="table-light">
          <tr>
            <th>Number</th>
            <th>Region</th>
            <th>Code</th>
            <th>Created At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
             @php
            $no = 1;
          @endphp
          @foreach($region as $data)

          <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $data->name }}</td>
            <td>{{ $data->code }}</td>
            <td>{{ $data->created_at->format('Y-m-d') }}</td>
            <td>
              <a href="{{ route('region.show', $data->id) }}" class="btn btn-sm btn-info">Show</a>
              <a href="{{ route('region.edit', $data->id) }}" class="btn btn-sm btn-warning">Edit</a>

              <form action="{{ route('region.destroy', $data->id) }}" method="POST" class="delete-form d-inline">
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
    new DataTable('#dataRegion');

    
    </script>

    
@endpush
