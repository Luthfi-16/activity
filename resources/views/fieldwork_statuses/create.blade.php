@extends('layouts.app')
@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">Fieldwork Statuses / <span class="text-muted">Create</span></h4>

  <div class="card">
    <div class="card-header">
      <h5 class="mb-0">Add Fieldwork Status</h5>
    </div>
    <div class="card-body">
      <form action="{{ route('fieldwork_statuses.store') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-control">
        </div>
        <div class="mb-3">
          <label class="form-label">Description</label>
          <textarea name="description" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('fieldwork_statuses.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>
@endsection
