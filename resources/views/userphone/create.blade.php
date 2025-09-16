@extends('layouts.app')
@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">User Phone / <span class="text-muted">Create</span></h4>

  <div class="card mb-4">
    <div class="card-body">
      <form action="{{ route('userphone.store') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label class="form-label">Number</label>
          <input type="number" name="number" class="form-control @error('number') is-invalid @enderror" placeholder="User Phone" >
           @error('number')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" >
           @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Select User</label>
          <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
            <option value="">-- Select User --</option>
            @foreach($user as $data)
              <option value="{{ $data->id }}">{{ $data->name }}</option>
            @endforeach
          </select>
           @error('user_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('userphone.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>
@endsection
