@extends('layouts.app')
@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
@endsection
@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">Fieldwork category / <span class="text-muted">List</span></h4>

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Fieldwork category</h5>
      <a href="{{ route('fieldwork_category.create') }}" class="btn btn-primary">+ Add Fieldwork Category</a>
    </div>
    <div class="table-responsive text-nowrap">
      <table id="dataCategory" class="table">
        <thead class="table-light">
          <tr>
            <th>No</th>
            <th>Category</th>
            <th>Description</th>
            <th>Created At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
           @php
            $no = 1;
          @endphp
          @foreach($category as $data)
          <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $data->name }}</td>
            <td>{{ $data->description ?? '-' }}</td>
            <td>{{ $data->created_at->format('Y-m-d') }}</td>
            <td>
              <a href="{{ route('fieldwork_category.show', $data->id) }}" class="btn btn-sm btn-info">Show</a>
              <a href="{{ route('fieldwork_category.edit', $data->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('fieldwork_category.destroy', $data->id) }}" method="POST" class="d-inline delete-form">
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
    new DataTable('#dataCategory');
    </script>
@endpush