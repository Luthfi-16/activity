@extends('layouts.app')
@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">Fieldwork category / <span class="text-muted">List</span></h4>

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Fieldwork category</h5>
      <a href="{{ route('fieldwork_category.create') }}" class="btn btn-primary">+ Add Fieldwork kategori</a>
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
          @foreach($category as $kategori)
          <tr>
            <td>{{ $kategori->id }}</td>
            <td>{{ $kategori->name }}</td>
            <td>{{ $kategori->description ?? '-' }}</td>
            <td>{{ $kategori->created_at->format('Y-m-d') }}</td>
            <td>
              <a href="{{ route('fieldwork_category.show', $kategori->id) }}" class="btn btn-sm btn-info">Show</a>
              <a href="{{ route('fieldwork_category.edit', $kategori->id) }}" class="btn btn-sm btn-warning">Edit</a>
              <form action="{{ route('fieldwork_category.destroy', $kategori->id) }}" method="POST" class="d-inline">
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