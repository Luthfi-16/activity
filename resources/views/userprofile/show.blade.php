@extends('layouts.app')
@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">User Profiles / <span class="text-muted">Detail</span></h4>

  <div class="card shadow-sm">
    <div class="card-header">
      <h5 class="mb-0">Detail User Profile</h5>
    </div>
    <div class="card-body">
      <div class="mb-2">
        <strong>NIK:</strong> {{ $userprofile->nik }}
      </div>
      <div class="mb-2">
        <strong>Nama:</strong> {{ $userprofile->name }}
      </div>
      <div class="mb-2">
        <strong>Gender:</strong> {{ $userprofile->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
      </div>
      <div class="mb-2">
        <strong>Tempat Lahir:</strong> {{ $userprofile->birthplace }}
      </div>
      <div class="mb-2">
        <strong>Tanggal Lahir:</strong> {{ $userprofile->birthday }}
      </div>
      <div class="mb-2">
        <strong>User Email:</strong> {{ $userprofile->user->email ?? '-' }}
      </div>
      <div class="mt-4 d-flex gap-2">
        <a href="{{ route('userprofile.index') }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('userprofile.edit', $userprofile->id) }}" class="btn btn-warning">Edit</a>
      </div>
    </div>
  </div>
</div>
@endsection
