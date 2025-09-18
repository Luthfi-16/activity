@extends('layouts.app')
@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
@endsection
@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">User Phones / <span class="text-muted">List</span></h4>

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">User Phones</h5>
      <a href="{{ route('userphone.create') }}" class="btn btn-primary">+ Add User Phone</a>
    </div>
    <div class="table-responsive text-nowrap">
      <table id="dataPhone" class="table">
        <thead class="table-light">
          <tr>
            <th>Number</th>
            <th>Name</th>
            <th>User Name</th>
            <th>Created At</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
             @php
            $no = 1;
          @endphp
          @foreach($userphone as $data)

          <tr>
            <td>{{ $data->number }}</td>
            <td>{{ $data->name }}</td>
            <td>{{ $data->user->name }}</td>
            <td>{{ $data->created_at->format('Y-m-d') }}</td>
            <td>
              <a href="{{ route('userphone.show', $data->id) }}" class="btn btn-sm btn-info">Show</a>
              <a href="{{ route('userphone.edit', $data->id) }}" class="btn btn-sm btn-warning">Edit</a>
              <form action="{{ route('userphone.destroy', $data->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger"
                  onclick="return confirm('Yakin mau hapus?')">Delete</button>
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
    new DataTable('#dataPhone');
    </script>
@endpush