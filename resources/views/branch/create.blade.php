@extends('layouts.app')
@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
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
          <select id="region" name="region_id" class="form-control select2 @error('region_id') is-invalid @enderror">
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
@push('scripts')
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">	
	$(document).ready(function() {
		$('#region').select2();
	});
</script>


@endpush
