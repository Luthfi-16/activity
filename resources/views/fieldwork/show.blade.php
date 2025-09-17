@extends('layouts.app')
@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">Fieldwork / <span class="text-muted">Detail</span></h4>

  <div class="card">
    <div class="card-body">
      <p><strong>ID:</strong> {{ $fieldwork->id }}</p>
      <p><strong>Description:</strong> {{ $fieldwork->description }}</p>
      <p><strong>Note:</strong> {{ $fieldwork->note ?? '-' }}</p>
      <p><strong>Branch:</strong> {{ $fieldwork->branch?->name ?? '-' }}</p>
      <p><strong>Category:</strong> {{ $fieldwork->category?->name ?? '-' }}</p>
      <p><strong>Status:</strong> {{ $fieldwork->status?->name ?? '-' }}</p>
      <p><strong>Start Date:</strong> {{ $fieldwork->start_date->format('d M Y') ?? '-' }}</p>
      <p><strong>End Date:</strong> {{ $fieldwork->end_date->format('d M Y') ?? '-' }}</p>

      {{-- tampilkan semua users --}}
      <p><strong>Personil:</strong>
        @if($fieldwork->users->count())
          <ul class="mb-0">
            @foreach($fieldwork->users as $user)
              <li>{{ $user->name }} ({{ $user->email }})</li>
            @endforeach
          </ul>
        @else
          -
        @endif
      </p>

      <p><strong>Created At:</strong> {{ $fieldwork->created_at->format('d M Y H:i') }}</p>
      <p><strong>Updated At:</strong> {{ $fieldwork->updated_at->format('d M Y H:i') }}</p>
    </div>
    <div class="card-footer">
      <a href="{{ route('fieldwork.index') }}" class="btn btn-secondary">Back</a>
      <a href="{{ route('fieldwork.edit', $fieldwork->id) }}" class="btn btn-warning">Edit</a>
    </div>
  </div>
</div>
@endsection
