@extends('layouts.app')
@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">List Users/ <span class="text-muted">Edit</span></h4>

  <div class="card">
    <div class="card-header">
      <h5 class="mb-0">Edit List Users</h5>
    </div>
    <div class="card-body">
      <form action="{{ route('listuser.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label for="nik" class="form-label">Name</label>
          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}">
          @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="mb-3">
          <label for="name" class="form-label">Email</label>
          <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}">
           @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        {{-- <div class="mb-3">
          <label for="user_id" class="form-label">User Email</label>
          <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
            <option value="">-- Pilih User --</option>
            @foreach($users as $user)
              <option value="{{ $user->id }}" {{ old('user_id', $userprofile->user_id) == $user->id ? 'selected' : '' }}>
                {{ $user->email }}
              </option>
            @endforeach
          </select>
           @error('user_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div> --}}

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('listuser.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>
@endsection
