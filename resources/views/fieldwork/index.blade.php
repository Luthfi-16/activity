@extends('layouts.app')
@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">Fieldwork / <span class="text-muted">List</span></h4>

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Fieldwork</h5>
      <a href="{{ route('fieldwork.create') }}" class="btn btn-primary">+ Add Fieldwork</a>
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead class="table-light">
          <tr>
            <th>No</th>
            <th>Description</th>
            <th>Note</th>
            <th>Branch</th>
            <th>Category</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @php $no = 1; @endphp
          @foreach($fieldwork as $fieldwork)
          <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $fieldwork->description }}</td>
            <td>{{ $fieldwork->note ?? '-' }}</td>
            <td>{{ $fieldwork->branch?->name ?? '-' }}</td>
            <td>{{ $fieldwork->category?->name ?? '-' }}</td>
            <td>{{ $fieldwork->status?->name ?? '-' }}</td>
            <td>{{ $fieldwork->created_at->format('Y-m-d') }}</td>
            <td>
              <a href="{{ route('fieldwork.show', $fieldwork->id) }}" class="btn btn-sm btn-info">Show</a>
              <a href="{{ route('fieldwork.edit', $fieldwork->id) }}" class="btn btn-sm btn-warning">Edit</a>
              <form action="{{ route('fieldwork.destroy', $fieldwork->id) }}" method="POST" class="d-inline">
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
