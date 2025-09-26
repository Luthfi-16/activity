@extends('layouts.app')
@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">List Users / <span class="text-muted">Create</span></h4>

  <div class="card">
    <div class="card-header">
      <h5 class="mb-0">Add New User</h5>
    </div>
    <div class="card-body">
      <form action="{{ route('listuser.store') }}" method="POST">
        @csrf

        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" 
                 name="name" 
                 class="form-control @error('name') is-invalid @enderror" 
                 value="{{ old('name') }}">
          @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="text" 
                 name="email" 
                 class="form-control @error('email') is-invalid @enderror" 
                 value="{{ old('email') }}">
          @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="mb-3 form-password-toggle">
          <div class="d-flex justify-content-between">
            <label class="form-label" for="password">Password</label>
          </div>
          <div class="input-group input-group-merge">
            <input
              type="password"
              id="password"
              class="form-control @error('password') is-invalid @enderror"
              name="password"
              placeholder="********"
              aria-describedby="password"
            />
            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
          </div>
          @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="mb-3">
          <label for="password_confirmation" class="form-label">Confirm Password</label>
          <input type="password" 
                 name="password_confirmation" 
                 class="form-control" 
                 placeholder="Re-type your password" />
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('listuser.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>
@endsection
