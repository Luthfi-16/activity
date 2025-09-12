@extends('layouts.app')

@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">Fieldwork category / <span class="text-muted">Detail</span></h4>

  <div class="card">
    <div class="card-header">
      <h5 class="mb-0">Detail Fieldwork Category</h5>
    </div>
    <div class="card-body">
      <p><strong>ID:</strong> {{ $fieldwork_category->id }}</p>
      <p><strong>Name:</strong> {{ $fieldwork_category->name }}</p>
      <p><strong>Description:</strong> {{ $fieldwork_category->description }}</p>
      <p><strong>Created At:</strong> {{ $fieldwork_category->created_at->format('Y-m-d H:i') }}</p>
      <p><strong>Updated At:</strong> {{ $fieldwork_category->updated_at->format('Y-m-d H:i') }}</p>

      <a href="{{ route('fieldwork_category.index') }}" class="btn btn-secondary">Back</a>
      <a href="{{ route('fieldwork_category.edit', $fieldwork_category->id) }}" class="btn btn-warning">Edit</a>
    </div>
  </div>
</div>
@endsection
