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
          <label for="nik" class="form-label">NIK</label>
          <input type="text" name="nik" class="form-control" value="{{ old('nik') }}">
          @error('nik') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
          <label for="name" class="form-label">Nama</label>
          <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
          @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
          <label for="gender" class="form-label">Gender</label>
          <select name="gender" class="form-control" required>
            <option value="">-- Pilih Gender --</option>
            <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
          </select>
          @error('gender') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
          <label for="birthplace" class="form-label">Tempat Lahir</label>
          <input type="text" name="birthplace" class="form-control" value="{{ old('birthplace') }}">
          @error('birthplace') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
          <label for="birthday" class="form-label">Tanggal Lahir</label>
          <input type="date" name="birthday" class="form-control" value="{{ old('birthday') }}">
          @error('birthday') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
          <label for="user_id" class="form-label">User Email</label>
          <select name="user_id" class="form-control">
            <option value="">-- Pilih User --</option>
            @foreach($users as $user)
              <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                {{ $user->email }}
              </option>
            @endforeach
          </select>
          @error('user_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('userprofile.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>
@endsection
