@extends('layouts.app')
@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">branches / <span class="text-muted">Edit</span></h4>

  <div class="card mb-4">
    <div class="card-body">
      <form action="{{ route('branch.update', $branch->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $branch->name }}">
          @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Address</label>
          <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ $branch->address }}">
          @error('address')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Region</label>
          <select name="region_id" class="form-control @error('region_id') is-invalid @enderror">
            @foreach($regions as $region)
              <option value="{{ $region->id }}" {{ $region->id == $branch->region_id ? 'selected' : '' }}>
                {{ $region->name }}
              </option>
            @endforeach
          </select>
          @error('region_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('branch.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>
@endsection
