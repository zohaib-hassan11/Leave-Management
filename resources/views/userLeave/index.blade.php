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
                <a href="{{ route('leave.create') }}" class="btn btn-primary">New Leave Request</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <div class="row g-2">
                        <div class="col-auto d-flex justify-content-start">
                            <select id="leaveTypeFilter" class="form-control">
                                <option value="">All Leave Types</option>
                                @foreach($leaveTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- User Role Dropdown -->
                        <div class="col-auto d-flex justify-content-start">
                            <select id="roleFilter" class="form-control">
                                <option value="">All User Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Search Bar -->
                        <div class="col-auto">
                            <div class="input-group">
                                <input type="text" id="searchInput" class="form-control" placeholder="Search">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Leave Records Container -->
                <div id="leaveRecords">
                    @include('partials.leave-list', ['leaves' => $userLeave])
                </div>

            </div>
            {{-- <div class="card-body table-responsive p-0">
                @if (!empty($userLeave) && $userLeave->count() > 0)
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Role</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Reason</th>
                                @can('leave_request_status')
                                    <th width="100">Status</th>
                                @endcan
                                @can(['edit_leave_request', 'delete_leave_request'])
                                    <th width="100">Actions</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userLeave as $leave)
                            <tr>
                                <td>{{ $leave->user->name }}</td>
                                <td>{{ $leave->leaveType->name }}</td>
                                <td>{{ $leave->user->role }}</td>
                                <td>{{ $leave->start_date }}</td>
                                <td>{{ $leave->end_date }}</td>
                                <td>{{ $leave->reason }}</td>

                                @can('leave_request_status')
                                <td>
                                    <form action="{{ route('leave.updateStatus', $leave->id) }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <select name="status" class="form-control-sm" onchange="this.form.submit()">
                                            <option value="pending" {{ $leave->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ $leave->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="rejected" {{ $leave->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </form>
                                </td>
                                @endcan

                                <!-- Actions (Edit/Delete) -->
                                @can('edit_leave_request')
                                <td>
                                    <!-- Edit Button -->
                                    <a href="{{ route('leave.edit', $leave->id) }}" class="text-primary w-4 h-4 mr-1">
                                        <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                        </svg>
                                    </a>
                                    @endcan

                                    @can('delete_leave_request')

                                    <!-- Delete Button -->
                                    <form action="{{ route('leave.destroy', $leave->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-danger w-4 h-4 mr-1" style="border: none; background: none; cursor: pointer;">
                                            <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center m-3">
                        No leave requests found.
                    </div>
                @endif
            </div> --}}

            <div class="d-flex justify-content-end mt-3 mr-2">
                {!! $userLeave->links('pagination::bootstrap-4') !!}
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        function fetchLeaves() {
            let search = $('#searchInput').val();
            let leaveType = $('#leaveTypeFilter').val();
            let roles = $('#roleFilter').val();

            $.ajax({
                url: "{{ route('leave.index') }}",
                type: "GET",
                data: { search: search, leave_type: leaveType, roles: roles },
                beforeSend: function() {
                    $('#leaveRecords').html('<p class="text-center">Loading...</p>');
                },
                success: function (response) {
                    $('#leaveRecords').html(response);
                },
                error: function () {
                    alert("Something went wrong! Please try again.");
                }
            });
        }

        // Trigger on search input change
        $('#searchInput').on('keyup', function () {
            fetchLeaves();
        });

        // Trigger on leave type change
        $('#leaveTypeFilter').on('change', function () {
            fetchLeaves();
        });

        // Trigger on search button click
        $('#searchButton').on('click', function (e) {
            e.preventDefault();
            fetchLeaves();
        });

        // Trigger on roles button click
        $('#roleFilter').on('change', function (e) {
            fetchLeaves();
        });
    });
</script>

@endpush

@endsection
