@extends('layouts.app')
@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">User Phones / <span class="text-muted">Detail</span></h4>

  <div class="card">
    <div class="card-body">
      <p><strong>ID:</strong> {{ $userphone->id }}</p>
      <p><strong>Number:</strong> {{ $userphone->number }}</p>
      <p><strong>Name:</strong> {{ $userphone->name }}</p>
      <p><strong>User ID:</strong> {{ $userphone->user->id }}</p>
      <p><strong>Created At:</strong> {{ $userphone->created_at }}</p>
      <p><strong>Updated At:</strong> {{ $userphone->updated_at }}</p>
    </div>
    <div class="card-footer">
      <a href="{{ route('userphone.index') }}" class="btn btn-secondary">Back</a>
      <a href="{{ route('userphone.edit', $userphone->id) }}" class="btn btn-warning">Edit</a>
    </div>
  </div>
</div>
@endsection
