@extends('layouts.app')
@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">Regions / <span class="text-muted">Edit</span></h4>

  <div class="card mb-4">
    <div class="card-body">
      <form action="{{ route('region.update', $region->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $region->name }}" >
           @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Code</label>
          <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ $region->code }}" >
           @error('code')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('region.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>
@endsection
