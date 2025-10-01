@extends('admin.layouts.app')

@section('title', 'Edit Permission')

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">User Management</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">Permissions</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Permission</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Permission: {{ $permission->name }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Permission Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $permission->name) }}" required>
                        <div class="form-text">Unique identifier for the permission (e.g., land-jamin-view)</div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="module" class="form-label">Module <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="module" name="module" value="{{ old('module', $permission->module) }}" required>
                        <div class="form-text">The module this permission belongs to (e.g., land-jamin, plot)</div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="action" class="form-label">Action <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="action" name="action" value="{{ old('action', $permission->action) }}" required>
                        <div class="form-text">The action this permission allows (e.g., view, create, update, delete)</div>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Permission</button>
            </div>
        </form>
    </div>
</div>
@endsection