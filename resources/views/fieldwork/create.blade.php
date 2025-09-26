@extends('layouts.app')
@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<div class="container">
  <h4 class="fw-bold py-3 mb-4">Fieldwork / <span class="text-muted">Create</span></h4>

  <div class="card">
    <div class="card-header">
      <h5 class="mb-0">Add Fieldwork</h5>
    </div>
    <div class="card-body">
      <form action="{{ route('fieldwork.store') }}" method="POST">
        @csrf
        {{-- Description --}}
        <div class="mb-3">
          <label class="form-label">Description</label>
          <input type="text" name="description"
                 class="form-control @error('description') is-invalid @enderror"
                 value="{{ old('description') }}">
          @error('description')
            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
          @enderror
        </div>

        {{-- Note --}}
        <div class="mb-3">
          <label class="form-label">Note</label>
          <textarea name="note"
                    class="form-control @error('note') is-invalid @enderror">{{ old('note') }}</textarea>
          @error('note')
            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
          @enderror
        </div>

        {{-- Start Date --}}
        <div class="mb-3">
          <label class="form-label">Start Date</label>
          <input type="date" name="start_date"
                 class="form-control @error('start_date') is-invalid @enderror"
                 value="{{ old('start_date') }}">
          @error('start_date')
            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
          @enderror
        </div>

        {{-- End Date --}}
        <div class="mb-3">
          <label class="form-label">End Date</label>
          <input type="date" name="end_date"
                 class="form-control @error('end_date') is-invalid @enderror"
                 value="{{ old('end_date') }}">
          @error('end_date')
            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
          @enderror
        </div>

                {{-- Region --}}
        <div class="mb-3">
          <label class="form-label">Region</label>
          <select id="region" class="form-select select2">
            <option value="">-- Choose Region --</option>
            @foreach($regions as $region)
              <option value="{{ $region->id }}">{{ $region->name }}</option>
            @endforeach
          </select>
        </div>

        {{-- Branch --}}
        <div class="mb-3">
          <label class="form-label">Branch</label>
          <select id="branch" name="branch_id" class="form-select select2 @error('branch_id') is-invalid @enderror">
            <option value="">-- Choose Branch --</option>
          </select>
          @error('branch_id')
            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
          @enderror
        </div>

        {{-- Category --}}
        <div class="mb-3">
          <label class="form-label">Category</label>
          <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
            <option value="">-- Choose Category --</option>
            @foreach($category as $kategori)
              <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                {{ $kategori->name }}
              </option>
            @endforeach
          </select>
          @error('category_id')
            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
          @enderror
        </div>

        {{-- Status --}}
        <div class="mb-3">
          <label class="form-label">Status</label>
          <select name="status_id" class="form-select @error('status_id') is-invalid @enderror">
          <option value="">-- Choose Status --</option>
            @foreach($status as $st)
              <option value="{{ $st->id }}" {{ old('st_id') == $st->id ? 'selected' : '' }}>
                {{ $st->name }}
              </option>
            @endforeach
          </select>
          @error('status_id')
            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
          @enderror
        </div>

        {{-- Users --}}
        <div class="mb-3">
          <label class="form-label">Staff (Users)</label>
          <select name="users[]" multiple 
                  class="form-select select2 @error('user_ids') is-invalid @enderror">
            @foreach($users as $user)
              <option value="{{ $user->id }}"
                {{ collect(old('users'))->contains($user->id) ? 'selected' : '' }}>
                {{ $user->name }}
              </option>
            @endforeach
          </select>
          <small class="text-muted">* Tekan CTRL/Command untuk pilih lebih dari satu</small>
          @error('user_ids')
            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
          @enderror
        </div>


        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('fieldwork.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">	
	$(document).ready(function () {
    // Init select2
    $('#region').select2({ placeholder: "-- Choose Region --" });
    $('#branch').select2({ placeholder: "-- Choose Branch --" });
    $('select[name="users[]"]').select2({ placeholder: "-- Choose Users --" });

    // Saat region dipilih
    $('#region').on('change', function () {
        let regionId = $(this).val();
        $('#branch').empty().append('<option value="">-- Choose Branch --</option>');

        if (regionId) {
            $.get('/branches-by-region/' + regionId, function (data) {
                let newOptions = '';
                $.each(data, function (i, branch) {
                    newOptions += '<option value="' + branch.id + '">' + branch.name + '</option>';
                });
                $('#branch').html('<option value="">-- Choose Branch --</option>' + newOptions);
                $('#branch').val(null).trigger('change.select2');
            });
        } else {
            $('#branch').val(null).trigger('change.select2');
        }
    });
});


</script>
@endpush