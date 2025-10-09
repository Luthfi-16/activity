@extends('layouts.app')
@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">User Phones / <span class="text-muted">Edit</span></h4>

  <div class="card mb-4">
    <div class="card-body">
      <form action="{{ route('userphone.update', $userphone->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
          <label class="form-label">Number</label>
          <input type="number" name="number" class="form-control @error('number') is-invalid @enderror" value="{{ $userphone->number }}">
           @error('number')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $userphone->name }}">
           @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
         <div class="mb-3">
          <label class="form-label">Select User</label>
          <select id="user" name="user_id" class="form-control select2 @error('user_id') is-invalid @enderror">
            @foreach($user as $data)
              <option value="{{ $data->id }}" {{ $data->id == $userphone->user_id ? 'selected' : '' }}>
                {{ $data->name }}
              </option>
            @endforeach
          </select>
           @error('user_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('userphone.index') }}" class="btn btn-secondary">Cancel</a>
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
		$('#user').select2();
	});
</script>
@endpush