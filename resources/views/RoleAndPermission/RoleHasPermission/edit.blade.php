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
                    <form action="{{  route('role-permission.update', $rolesAndPermission->id)  }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="role_name">Role Name</label>
                                    <select name="role_name" id="role_name" class="form-control" required>
                                        <option value="{{ $rolesAndPermission->name }}">{{ $rolesAndPermission->name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 ml-2">
                                    <label class="form-label"><strong>Assign Permissions</strong></label>
                                    @php

                                        $groupedPermissions = [];
                                        foreach ($allPermissions as $permission) {
                                            $parts = explode('_', $permission->name);
                                            $module = ucfirst($parts[0]);
                                            $groupedPermissions[$module][$permission->name] = $permission;
                                        }
                                    @endphp

                                    @foreach ($groupedPermissions as $module => $permissions)
                                        <div class="mb-3">
                                            <strong class="d-block">{{ $module }}</strong>

                                            @foreach ($permissions as $permissionName => $permission)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permissionName }}" id="perm_{{ $permissionName }}"
                                                    @if($rolesAndPermission->permissions->contains('name', $permissionName)) checked @endif>
                                                    <label class="form-check-label" for="perm_{{ $permissionName }}">
                                                        {{ ucfirst(str_replace('_', ' ', $permissionName)) }}
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
                            <a href="{{ route('role-permission.index') }}" class="btn btn-outline-dark ml-3">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <!-- /.card -->
</section>

@push('scripts')

@endpush

@endsection


