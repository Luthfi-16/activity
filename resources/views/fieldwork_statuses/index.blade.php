@extends('layouts.app')
@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">Fieldwork Statuses / <span class="text-muted">List</span></h4>

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Fieldwork Statuses</h5>
      <a href="{{ route('fieldwork_statuses.create') }}" class="btn btn-primary">+ Add Fieldwork Status</a>
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Created At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @foreach($statuses as $status)
          <tr>
            <td>{{ $status->id }}</td>
            <td>{{ $status->name }}</td>
            <td>{{ $status->description ?? '-' }}</td>
            <td>{{ $status->created_at->format('Y-m-d') }}</td>
            <td>
              <a href="{{ route('fieldwork_statuses.show', $status->id) }}" class="btn btn-sm btn-info">Show</a>
              <a href="{{ route('fieldwork_statuses.edit', $status->id) }}" class="btn btn-sm btn-warning">Edit</a>
              <form action="{{ route('fieldwork_statuses.destroy', $status->id) }}" method="POST" class="d-inline">
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
