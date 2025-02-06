<div class="card-body table-responsive p-0">
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
        <div class="text-center mt-3">
            No leave requests found.
        </div>
    @endif
</div>
