@extends('layouts.app')

@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">My Profile</h4>

  {{-- Portrait Card --}}
  <div class="card shadow-lg border-0 rounded-3 mx-auto overflow-hidden" style="max-width: 420px;">
    
    {{-- Background Header --}}
    <div class="profile-header text-center text-white py-4">
      <img src="https://ui-avatars.com/api/?name={{ urlencode($profile->name ?? '?') }}&background=ffffff&color=6C63FF&size=120" 
     alt="Avatar" 
     class="rounded-circle border border-3 border-white shadow-sm mb-3">


      {{-- Nama --}}
      <h4 class="fw-bold mb-1">{{ $profile->name ?? '-' }}</h4>

      {{-- Email --}}
      <p class="mb-0 fs-6">{{ $user->email ?? '-' }}</p>
    </div>

    <div class="card-body">
      @if($profile)
        {{-- Data Profile --}}
        <div class="list-group list-group-flush">
          <div class="list-group-item d-flex justify-content-between">
            <span class="fw-semibold">NIK</span>
            <span>{{ $profile->nik }}</span>
          </div>
          <div class="list-group-item d-flex justify-content-between">
            <span class="fw-semibold">Gender</span>
            <span>
              @if($profile->gender == 'L')
                <span class="badge bg-info">Laki-laki</span>
              @else
                <span class="badge bg-pink">Perempuan</span>
              @endif
            </span>
          </div>
          <div class="list-group-item d-flex justify-content-between">
            <span class="fw-semibold">Birthplace</span>
            <span>{{ $profile->birthplace }}</span>
          </div>
          <div class="list-group-item d-flex justify-content-between">
            <span class="fw-semibold">Birthday</span>
            <span>{{ $profile->birthday }}</span>
          </div>
        </div>

        {{-- Tombol Edit --}}
        <div class="text-center mt-4">
          <a href="{{ route('profile.edit') }}" class="btn btn-warning w-100">
            <i class="bi bi-pencil-square"></i> Edit Profile
          </a>
        </div>
      @else
        <div class="alert alert-info d-flex align-items-center" role="alert">
          <i class="bi bi-info-circle-fill me-2"></i>
          <div>Kamu belum mengisi profile. Silakan lengkapi sekarang.</div>
        </div>
        <div class="text-center">
          <a href="{{ route('profile.create') }}" class="btn btn-primary w-100">
            <i class="bi bi-plus-circle"></i> Isi Profile
          </a>
        </div>
      @endif
    </div>
  </div>
</div>

{{-- Tambahan style --}}
<style>
  .profile-header {
  background-color: #6C63FF; /* warna ungu violet muda */
}


  .bg-pink {
    background-color: #ff69b4 !important;
    color: #fff !important;
  }
  .profile-header h4 {
    font-size: 1.5rem; 
    color: #fff;
  }
  .profile-header p {
    font-size: 1rem;  
  }
</style>
@endsection
