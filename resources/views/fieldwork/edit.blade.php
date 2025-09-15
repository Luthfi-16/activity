@extends('layouts.app')
@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">Fieldwork / <span class="text-muted">Edit</span></h4>

  <div class="card">
    <div class="card-header">
      <h5 class="mb-0">Edit Fieldwork</h5>
    </div>
    <div class="card-body">
      <form action="{{ route('fieldwork.update', $fieldwork->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label class="form-label">Description</label>
          <input type="text" name="description" class="form-control" 
                 value="{{ old('description', $fieldwork->description) }}" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Note</label>
          <textarea name="note" class="form-control">{{ old('note', $fieldwork->note) }}</textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Branch</label>
          <select name="branch_id" class="form-select" required>
            <option value="">-- Pilih Branch --</option>
            @foreach($branches as $branch)
              <option value="{{ $branch->id }}" 
                {{ old('branch_id', $fieldwork->branch_id) == $branch->id ? 'selected' : '' }}>
                {{ $branch->name }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Category</label>
          <select name="category_id" class="form-select" required>
            <option value="">-- Pilih Category --</option>
            @foreach($categories as $category)
              <option value="{{ $category->id }}" 
                {{ old('category_id', $fieldwork->category_id) == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Status</label>
          <select name="status_id" class="form-select" required>
            <option value="">-- Pilih Status --</option>
            @foreach($statuses as $status)
              <option value="{{ $status->id }}" 
                {{ old('status_id', $fieldwork->status_id) == $status->id ? 'selected' : '' }}>
                {{ $status->name }}
              </option>
            @endforeach
          </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('fieldwork.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>
@endsection
