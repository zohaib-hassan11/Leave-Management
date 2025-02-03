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

    <form action="{{ route('user.update', $user->id) }}" method="POST">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ $user->name }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="{{ $user->email }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirmed Password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="role">Role</label>
                                <select name="role" id="role" class="form-control">
                                    <option value="admin" {{ old('role', $user->role == 'admin' ? 'selected' : '')}}>Admin</option>
                                    <option value="manager" {{ old('role', $user->role == 'manager' ? 'selected' : '')}}>Manager</option>
                                    <option value="employee" {{ old('role', $user->role == 'employee' ? 'selected' : '')}}>Employee</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pb-5 pt-3">
                <button class="btn btn-primary">Update</button>
                <a href="{{ route('user.index') }}" class="btn btn-outline-dark ml-3">Back</a>
            </div>
        </div>
    </form>

    <!-- /.card -->
</section>

@push('scripts')

@endpush

@endsection


