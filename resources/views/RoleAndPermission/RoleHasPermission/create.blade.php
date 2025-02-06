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

        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    @csrf
                    <form action="{{  route('assignPermissionsToRole')  }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="role_name">Role Name</label>
                                    <select name="role_name" id="role_name" class="form-control" required>
                                        <option value="">Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 ml-2">
                                    <label class="form-label"><strong>Assign Permissions</strong></label>
                                    @php
                                        $groupedPermissions = [];
                                        foreach ($permissions as $permission) {
                                            $parts = explode('_', $permission->name);
                                            $module = ucfirst($parts[0]);
                                            $groupedPermissions[$module][] = $permission;
                                        }
                                    @endphp

                                    @foreach ($groupedPermissions as $module => $modulePermissions)
                                        <div class="mb-3">
                                            <strong class="d-block">{{ $module }}</strong>
                                            @foreach ($modulePermissions as $permission)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="perm_{{ $permission->id }}">
                                                    <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                        {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="pb-5 pt-3">
                            <button type="submit" class="btn btn-primary">Create</button>
                            <a href="{{ route('roles.index') }}" class="btn btn-outline-dark ml-3">Back</a>
                        </div>
                    </form>
                </div>
            </div>
    <!-- /.card -->
</section>

@push('scripts')

@endpush

@endsection


