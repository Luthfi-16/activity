@extends('layouts.app')
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
          <input type="number" name="number" class="form-control" value="{{ $userphone->number }}" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-control" value="{{ $userphone->name }}" required>
        </div>
         <div class="mb-3">
          <label class="form-label">Select User</label>
          <select name="user_id" class="form-control" required>
            @foreach($user as $data)
              <option value="{{ $data->id }}" {{ $data->id == $userphone->user_id ? 'selected' : '' }}>
                {{ $data->name }}
              </option>
            @endforeach
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('userphone.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>
@endsection
