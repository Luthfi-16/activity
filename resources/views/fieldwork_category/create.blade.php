@extends('layouts.app')
@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">Fieldwork category / <span class="text-muted">Create</span></h4>

  <div class="card">
    <div class="card-header">
      <h5 class="mb-0">Add Fieldwork Category</h5>
    </div>
    <div class="card-body">
      <form action="{{ route('fieldwork_category.store') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name Category">
           @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Description</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" placeholder="Description"> 
              
            </textarea>
              @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('fieldwork_category.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>
@endsection
