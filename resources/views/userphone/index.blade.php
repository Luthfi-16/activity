@extends('layouts.app')
@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">User Phones / <span class="text-muted">List</span></h4>

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">User Phones</h5>
      <a href="{{ route('userphone.create') }}" class="btn btn-primary">+ Add User Phone</a>
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead class="table-light">
          <tr>
            <th>Number</th>
            <th>Name</th>
            <th>User Name</th>
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
