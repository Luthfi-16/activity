@extends('layouts.app')
@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">Branches / <span class="text-muted">Create</span></h4>

  <div class="card mb-4">
    <div class="card-body">
      <form action="{{ route('branch.store') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Branch Name">
           @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Address</label>
          <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" placeholder="Branch Address">
          @error('address')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Region</label>
          <select name="region_id" class="form-control @error('region_id') is-invalid @enderror">
            <option value="">-- Select Region --</option>
            @foreach($regions as $region)
              <option value="{{ $region->id }}">{{ $region->name }}</option>
            @endforeach
          </select>
          @error('region_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('branch.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>
@endsection
