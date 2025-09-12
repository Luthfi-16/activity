@extends('layouts.app')
@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">Regions / <span class="text-muted">Detail</span></h4>

  <div class="card">
    <div class="card-body">
      <p><strong>ID:</strong> {{ $region->id }}</p>
      <p><strong>Name:</strong> {{ $region->name }}</p>
      <p><strong>Code:</strong> {{ $region->code }}</p>
      <p><strong>Created At:</strong> {{ $region->created_at }}</p>
      <p><strong>Updated At:</strong> {{ $region->updated_at }}</p>
    </div>
    <div class="card-footer">
      <a href="{{ route('region.index') }}" class="btn btn-secondary">Back</a>
      <a href="{{ route('region.edit', $region->id) }}" class="btn btn-warning">Edit</a>
    </div>
  </div>
</div>
@endsection
