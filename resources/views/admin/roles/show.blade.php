@extends('admin.layouts.app')

@section('title', 'Role Details')

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">User Management</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles</a></li>
                <li class="breadcrumb-item active" aria-current="page">Role Details</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Role Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th>ID:</th>
                        <td>{{ $role->id }}</td>
                    </tr>
                    <tr>
                        <th>Name:</th>
                        <td>{{ $role->name }}</td>
                    </tr>
                    <tr>
                        <th>Description:</th>
                        <td>{{ $role->description ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            @if($role->isActive())
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Created At:</th>
                        <td>{{ $role->created_at->format('M d, Y H:i:s') }}</td>
                    </tr>
                    <tr>
                        <th>Updated At:</th>
                        <td>{{ $role->updated_at->format('M d, Y H:i:s') }}</td>
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
                    <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-warning">Edit Role</a>
                    <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this role?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Role</button>
                    </form>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Back to Roles</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Assigned Permissions ({{ $role->permissions->count() }})</h5>
    </div>
    <div class="card-body">
        @if($role->permissions->count() > 0)
        <div class="row">
            @foreach($role->permissions->groupBy('module') as $module => $modulePermissions)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">{{ ucfirst(str_replace('-', ' ', $module)) }}</h6>
                    </div>
                    <div class="card-body">
                        @foreach($modulePermissions as $permission)
                        <span class="badge bg-primary me-1 mb-1">{{ ucfirst($permission->action) }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-muted">No permissions assigned to this role.</p>
        @endif
    </div>
</div>
@endsection