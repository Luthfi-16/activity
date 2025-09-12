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
          <input type="text" name="name" class="form-control" placeholder="Branch Name" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Address</label>
          <input type="text" name="address" class="form-control" placeholder="Branch Address" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Region</label>
          <select name="region_id" class="form-control" required>
            <option value="">-- Select Region --</option>
            @foreach($regions as $region)
              <option value="{{ $region->id }}">{{ $region->name }}</option>
            @endforeach
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('branch.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>
@endsection
