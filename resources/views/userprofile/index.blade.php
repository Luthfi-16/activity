@extends('layouts.app') 
@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">User Profiles / <span class="text-muted">List</span></h4>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">User Profiles</h5>
      <a href="{{ route('userprofile.create') }}" class="btn btn-primary">+ Add User Profile</a>
    </div>
    <div class="table-responsive">
      <table class="table">
        <thead class="table-light">
          <tr>
            <th>Number</th>
            <th>NIK</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Birthplace</th>
            <th>Birthday</th>
            <th>User Email</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @php $no = 1; @endphp
          @foreach($userprofile as $data)
          <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $data->nik }}</td>
            <td>{{ $data->name }}</td>
            @if($data->gender == "L")
                <td>Laki-Laki</td>
            @elseif($data->gender == "P")
                <td>Perempuan</td>
            @endif
            <td>{{ $data->birthplace }}</td>
            <td>{{ $data->birthday }}</td>
            <td>{{ $data->user->email ?? '-' }}</td>
            <td>
              <a href="{{ route('userprofile.show', $data->id) }}" class="btn btn-sm btn-info">Show</a>
              <a href="{{ route('userprofile.edit', $data->id) }}" class="btn btn-sm btn-warning">Edit</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- CSS tambahan buat sembunyiin scrollbar horizontal --}}
<style>
  .table-responsive {
      overflow-x: hidden !important;
  }
</style>
@endsection
