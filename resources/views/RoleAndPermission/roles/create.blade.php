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

    <form action="{{  route('roles.store')  }}" method="post">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Role Name</label>
                                    <input type="text" name="role_name" id="role_name" class="form-control" placeholder="Role Name" value="{{ old('role_name') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary">Create</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-outline-dark ml-3">Back</a>
                </div>
            </div>
    </form>
    <!-- /.card -->
</section>

@push('scripts')

@endpush

@endsection


