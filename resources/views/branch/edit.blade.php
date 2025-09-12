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
          <input type="text" name="name" class="form-control" value="{{ $branch->name }}" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Address</label>
          <input type="text" name="address" class="form-control" value="{{ $branch->address }}" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Region</label>
          <select name="region_id" class="form-control" required>
            @foreach($regions as $region)
              <option value="{{ $region->id }}" {{ $region->id == $branch->region_id ? 'selected' : '' }}>
                {{ $region->name }}
              </option>
            @endforeach
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('branch.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>
@endsection
