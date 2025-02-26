@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')

@push('styles')

@endpush

<!-- Content Header (Page header) -->
<section class="content-header">
     <!-- Default box -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('errors'))
            <div class="alert alert-danger">
                {{ session('errors') }}
            </div>
        @endif
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Users Leave</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('assign.form') }}" class="btn btn-primary">Assign Role To Permission</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <form method="GET" action="{{ route('leave-balance.index') }}">
                        <div class="input-group" style="width: 250px;">
                            <input type="text" name="search" class="form-control float-right" placeholder="Search" value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Roles Name</th>
                            <th>Permission Name</th>
                            <th width="100">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)

                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>
                                @if($role->permissions->isNotEmpty())
                                    <ul>
                                        @foreach ($role->permissions as $permission)
                                            <li>{{ $permission->name }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span>No Permissions Assigned</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('role-permission.destroy', $role->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <!-- Edit Button -->
                                    <a href="{{ route('role-permission.edit', $role->id) }}" class="text-primary w-4 h-4 mr-1">
                                        <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                        </svg>
                                    </a>

                                    <!-- Delete Button -->
                                    <button type="submit" class="text-danger w-4 h-4 mr-1" style="border: none; background: none; cursor: pointer;">
                                        <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-3 mr-3">
                {!! $roles->links('pagination::bootstrap-4') !!}
            </div>
            {{-- <div class="card-footer clearfix">
                <ul class="pagination pagination m-0 float-right">
                    @if ($userLeave->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">«</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $userLeave->previousPageUrl() }}">«</a></li>
                    @endif

                    @foreach ($userLeave->getUrlRange(1, $userLeave->lastPage()) as $page => $url)
                        <li class="page-item {{ $page == $userLeave->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    @if ($userLeave->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $userLeave->nextPageUrl() }}">»</a></li>
                    @else
                        <li class="page-item disabled"><span class="page-link">»</span></li>
                    @endif
                </ul>
            </div> --}}

        </div>
    </div>
    <!-- /.card -->
</section>

@push('scripts')

@endpush

@endsection
