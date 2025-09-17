@extends('layouts.app')
@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">User Profiles / <span class="text-muted">Create</span></h4>

  <div class="card">
    <div class="card-header">
      <h5 class="mb-0">Add New User Profile</h5>
    </div>
    <div class="card-body">
      <form action="{{ route('userprofile.store') }}" method="POST">
        @csrf

        <div class="mb-3">
          <label for="nik" class="form-label">NIN</label>
          <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}">
           @error('nik')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
           @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="mb-3">
          <label for="gender" class="form-label">Gender</label>
          <select name="gender" class="form-control @error('gender') is-invalid @enderror">
            <option value="">-- Chooose Gender --</option>
            <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
          </select>
           @error('gender')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="mb-3">
          <label for="birthplace" class="form-label">Birth Place</label>
          <input type="text" name="birthplace" class="form-control @error('birthplace') is-invalid @enderror" value="{{ old('birthplace') }}">
           @error('birthplace')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="mb-3">
          <label for="birthday" class="form-label">Birthday</label>
          <input type="date" name="birthday" class="form-control @error('birthday') is-invalid @enderror" value="{{ old('birthday') }}">
           @error('birthday')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="mb-3">
          <label for="user_id" class="form-label">User Email</label>
          <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
            <option value="">-- Pilih User --</option>
            @foreach($users as $user)
              <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                {{ $user->email }}
              </option>
            @endforeach
          </select>
           @error('user_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('userprofile.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>
@endsection
