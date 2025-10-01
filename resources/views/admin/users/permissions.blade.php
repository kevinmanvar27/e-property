@extends('admin.layouts.app')

@section('title', 'User Permissions')

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">User Management</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.management') }}">Management Users</a></li>
                <li class="breadcrumb-item active" aria-current="page">User Permissions</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Manage Permissions for {{ $user->name }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('users.management.permissions.assign', $user->id) }}" method="POST">
                    @csrf
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="role_id" class="form-label">Assign Role</label>
                                <select class="form-select" id="role_id" name="role_id">
                                    <option value="">Select Role (No Role)</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <div class="form-text">Selecting a role will assign its default permissions</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Additional Permissions</label>
                        <div class="row">
                            @foreach($permissions->groupBy('module') as $module => $modulePermissions)
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">{{ ucfirst(str_replace('-', ' ', $module)) }}</h6>
                                    </div>
                                    <div class="card-body">
                                        @foreach($modulePermissions as $permission)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}" {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                {{ ucfirst($permission->action) }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('users.management') }}" class="btn btn-secondary">Back to Users</a>
                        <button type="submit" class="btn btn-primary">Update Permissions</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">User Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th>Name:</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Username:</th>
                        <td>{{ $user->username }}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Role:</th>
                        <td>
                            @if($user->role == 'super_admin')
                                <span class="badge bg-danger">Super Admin</span>
                            @elseif($user->role == 'admin')
                                <span class="badge bg-primary">Admin</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Assigned Role:</th>
                        <td>
                            @if($user->role)
                                <span class="badge bg-info">{{ $user->role->name ?? 'None' }}</span>
                            @else
                                <span class="text-muted">None</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            @if($user->isActive())
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Current Permissions</h5>
            </div>
            <div class="card-body">
                @if($user->permissions->count() > 0)
                <div class="d-flex flex-wrap gap-2">
                    @foreach($user->permissions as $permission)
                    <span class="badge bg-primary">{{ ucfirst(str_replace('-', ' ', $permission->module)) }} - {{ ucfirst($permission->action) }}</span>
                    @endforeach
                </div>
                @else
                <p class="text-muted">No permissions assigned.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection