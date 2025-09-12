@extends('layouts.app')
@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">Fieldwork Statuses / <span class="text-muted">Detail</span></h4>

  <div class="card">
    <div class="card-header">
      <h5 class="mb-0">Detail Fieldwork Status</h5>
    </div>
    <div class="card-body">
      <p><strong>ID:</strong> {{ $fieldwork_status->id }}</p>
      <p><strong>Name:</strong> {{ $fieldwork_status->name }}</p>
      <p><strong>Description:</strong> {{ $fieldwork_status->description }}</p>
      <p><strong>Created At:</strong> {{ $fieldwork_status->created_at->format('Y-m-d H:i') }}</p>
      <p><strong>Updated At:</strong> {{ $fieldwork_status->updated_at->format('Y-m-d H:i') }}</p>

      <a href="{{ route('fieldwork_statuses.index') }}" class="btn btn-secondary">Back</a>
      <a href="{{ route('fieldwork_statuses.edit', $fieldwork_status->id) }}" class="btn btn-warning">Edit</a>
    </div>
  </div>
</div>
@endsection
