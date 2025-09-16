@extends('layouts.app')
@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">Regions / <span class="text-muted">Create</span></h4>

  <div class="card mb-4">
    <div class="card-body">
      <form action="{{ route('region.store') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Region Name">
           @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Code</label>
          <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" placeholder="Region Code">
           @error('code')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('region.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>
@endsection
