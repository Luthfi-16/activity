@extends('layouts.app')
@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">Branches / <span class="text-muted">Detail</span></h4>

  <div class="card">
    <div class="card-body">
      <p><strong>ID:</strong> {{ $branch->id }}</p>
      <p><strong>Name:</strong> {{ $branch->name }}</p>
      <p><strong>Address:</strong> {{ $branch->address }}</p>
      <p><strong>Region:</strong> {{ $branch->region->name ?? '-' }}</p>
      <p><strong>Created At:</strong> {{ $branch->created_at }}</p>
      <p><strong>Updated At:</strong> {{ $branch->updated_at }}</p>
    </div>
    <div class="card-footer">
      <a href="{{ route('branch.index') }}" class="btn btn-secondary">Back</a>
      <a href="{{ route('branch.edit', $branch->id) }}" class="btn btn-warning">Edit</a>
    </div>
  </div>
</div>
@endsection
