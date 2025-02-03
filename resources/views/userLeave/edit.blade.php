@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')

@push('styles')

@endpush

<section class="content">
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

    <form action="{{  route('leave.update', $userLeave->id ) }}" method="post">
        @method('PATCH')
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <select name="user_id" class="form-control">
                                        <option value="">Select User</option>
                                        @foreach ($user as $item)
                                            <option value="{{ $item->id }}" {{ old('user_id', $userLeave->user_id) == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Leave Types</label>
                                    <select name="leave_type_id" class="form-control form-control">
                                        <option value="">Select Leave Type</option>
                                        @foreach ($type as $leaveType)
                                            <option value="{{ $leaveType->id }}" {{ old('leave_type_id', $userLeave->leave_type_id) == $leaveType->id ? 'selected' : '' }}>
                                                {{ $leaveType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control" placeholder="Start Date" value="{{ $userLeave->start_date }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_date">End Date</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control" placeholder="End Date" value="{{ $userLeave->end_date }}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="reason">Reason</label>
                                    <textarea name="reason" id="reason" class="form-control" placeholder="Enter your reason here" rows="4" >{{ old('reason', $userLeave->reason) }}</textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary">Create</button>
                    <a href="{{ route('leave.index') }}" class="btn btn-outline-dark ml-3">Back</a>
                </div>
            </div>
    </form>
    <!-- /.card -->
</section>

@push('scripts')

@endpush

@endsection


