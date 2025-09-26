@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
@endsection

@section('content')
    <div class="container">
        <h4 class="fw-bold py-3 mb-4">List Users / <span class="text-muted">List Users</span></h4>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">List Users</h5>
                @if(Auth::user()->is_admin)
                    <a href="{{ route('listuser.create') }}" class="btn btn-primary">+ Add User Account</a>
                @endif
            </div>
            <div class="table-responsive">
                <table id="dataProfile" class="table">
                    <thead class="table-light">
                        <tr>
                            <th>Number</th>
                            <th>Name</th>
                            <th>Email</th>
                            @if (Auth::user()->is_admin)
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @php $no = 1; @endphp
                        @foreach ($users as $data)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->email }}</td>
                                    @if (Auth::user()->is_admin)
                                        <td><a href="{{ route('listuser.edit', $data->id) }}" class="btn btn-sm btn-warning">Edit</a></td>
                                    @endif
                        {{-- <td>
                            <a href="{{ route('listuser.edit', $data->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        </td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .table-responsive {
            overflow-x: hidden !important;
        }
    </style>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>
    <script>
        new DataTable('#dataProfile');
    </script>
@endpush
