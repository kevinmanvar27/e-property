@extends('admin.layouts.app')

@section('title', 'Permission Details')

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">User Management</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">Permissions</a></li>
                <li class="breadcrumb-item active" aria-current="page">Permission Details</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Permission Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th>ID:</th>
                        <td>{{ $permission->id }}</td>
                    </tr>
                    <tr>
                        <th>Name:</th>
                        <td>{{ $permission->name }}</td>
                    </tr>
                    <tr>
                        <th>Module:</th>
                        <td>{{ ucfirst(str_replace('-', ' ', $permission->module)) }}</td>
                    </tr>
                    <tr>
                        <th>Action:</th>
                        <td>{{ ucfirst($permission->action) }}</td>
                    </tr>
                    <tr>
                        <th>Created At:</th>
                        <td>{{ $permission->created_at->format('M d, Y H:i:s') }}</td>
                    </tr>
                    <tr>
                        <th>Updated At:</th>
                        <td>{{ $permission->updated_at->format('M d, Y H:i:s') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="btn btn-warning">Edit Permission</a>
                    <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this permission?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Permission</button>
                    </form>
                    <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Back to Permissions</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Assigned Roles ({{ $permission->roles->count() }})</h5>
    </div>
    <div class="card-body">
        @if($permission->roles->count() > 0)
        <div class="d-flex flex-wrap gap-2">
            @foreach($permission->roles as $role)
            <a href="{{ route('admin.roles.show', $role->id) }}" class="badge bg-primary text-decoration-none">{{ $role->name }}</a>
            @endforeach
        </div>
        @else
        <p class="text-muted">No roles assigned to this permission.</p>
        @endif
    </div>
</div>
@endsection