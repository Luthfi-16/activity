@extends('layouts.app')
@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">Fieldwork / <span class="text-muted">Detail</span></h4>

  <div class="card">
    <div class="card-header">
      <h5 class="mb-0">Detail Fieldwork</h5>
    </div>
    <div class="card-body">
      <dl class="row mb-0">
        
        <dt class="col-sm-3">Id</dt>
        <dd class="col-sm-9">{{ $fieldwork->id }}</dd>

        <dt class="col-sm-3">Description</dt>
        <dd class="col-sm-9">{{ $fieldwork->description }}</dd>

        <dt class="col-sm-3">Note</dt>
        <dd class="col-sm-9">{{ $fieldwork->note ?? '-' }}</dd>

        <dt class="col-sm-3">Branch</dt>
        <dd class="col-sm-9">{{ $fieldwork->branch?->name ?? '-' }}</dd>

        <dt class="col-sm-3">Category</dt>
        <dd class="col-sm-9">{{ $fieldwork->category?->name ?? '-' }}</dd>

        <dt class="col-sm-3">Status</dt>
        <dd class="col-sm-9">{{ $fieldwork->status?->name ?? '-' }}</dd>

        <dt class="col-sm-3">Created At</dt>
        <dd class="col-sm-9">{{ $fieldwork->created_at->format('d M Y H:i') }}</dd>

        <dt class="col-sm-3">Updated At</dt>
        <dd class="col-sm-9">{{ $fieldwork->updated_at->format('d M Y H:i') }}</dd>
      </dl>
    </div>
    <div class="card-footer">
      <a href="{{ route('fieldwork.index') }}" class="btn btn-secondary">Back</a>
      <a href="{{ route('fieldwork.edit', $fieldwork->id) }}" class="btn btn-warning">Edit</a>
    </div>
  </div>
</div>
@endsection
