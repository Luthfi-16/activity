@extends('layouts.app')
@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">Branches / <span class="text-muted">List</span></h4>

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Branches</h5>
      <a href="{{ route('branch.create') }}" class="btn btn-primary">+ Add Branch</a>
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Region</th>
            <th>Created At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @foreach($branches as $branch)
          <tr>
            <td>{{ $branch->id }}</td>
            <td>{{ $branch->name }}</td>
            <td>{{ $branch->address }}</td>
            <td>{{ $branch->region->name ?? '-' }}</td>
            <td>{{ $branch->created_at->format('Y-m-d') }}</td>
            <td>
              <a href="{{ route('branch.show', $branch->id) }}" class="btn btn-sm btn-info">Show</a>
              <a href="{{ route('branch.edit', $branch->id) }}" class="btn btn-sm btn-warning">Edit</a>
              <form action="{{ route('branch.destroy', $branch->id) }}" method="POST" class="d-inline">
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
