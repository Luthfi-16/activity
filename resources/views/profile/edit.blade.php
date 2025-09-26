@extends('layouts.app')

@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">Profile / <span class="text-muted">Edit</span></h4>

  <div class="card">
    <div class="card-header">
      <h5 class="mb-0">Edit Profile</h5>
    </div>
    <div class="card-body">
      <form action="{{ route('profile.update', $profile->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label for="nik" class="form-label">NIK</label>
          <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik', $profile->nik) }}" >
          @error('nik') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
          <label for="name" class="form-label">Nama</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $profile->name) }}" >
          @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Jenis Kelamin</label>
          <select class="form-control @error('gender') is-invalid @enderror" name="gender" >
            <option value="">-- Pilih --</option>
            <option value="L" {{ old('gender', $profile->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ old('gender', $profile->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
          </select>
          @error('gender') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
          <label for="birthplace" class="form-label">Tempat Lahir</label>
          <input type="text" class="form-control @error('birthplace') is-invalid @enderror" id="birthplace" name="birthplace" value="{{ old('birthplace', $profile->birthplace) }}" >
          @error('birthplace') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
          <label for="birthday" class="form-label">Tanggal Lahir</label>
          <input type="date" class="form-control @error('birthday') is-invalid @enderror" id="birthday" name="birthday" value="{{ old('birthday', $profile->birthday) }}" >
          @error('birthday') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- user_id otomatis dari Auth --}}
        <input type="hidden" name="user_id" value="{{ Auth::id() }}">

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('profile') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>
@endsection
