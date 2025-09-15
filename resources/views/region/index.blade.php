@extends('layouts.app') 
@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">Regions / <span class="text-muted">List</span></h4>

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Regions</h5>
      <a href="{{ route('region.create') }}" class="btn btn-primary">+ Add Region</a>
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead class="table-light">
          <tr>
            <th>Number</th>
            <th>Name</th>
            <th>Code</th>
            <th>Created At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
             @php
            $no = 1;
          @endphp
          @foreach($regions as $region)
       
          <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $region->name }}</td>
            <td>{{ $region->code }}</td>
            <td>{{ $region->created_at->format('Y-m-d') }}</td>
            <td>
              <a href="{{ route('region.show', $region->id) }}" class="btn btn-sm btn-info">Show</a>
              <a href="{{ route('region.edit', $region->id) }}" class="btn btn-sm btn-warning">Edit</a>
              <form action="{{ route('region.destroy', $region->id) }}" method="POST" class="d-inline">
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
