@extends('admin.layouts.app')

@section('content')
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Users</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Management Users</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="bx bx-plus"></i> Add New User
            </button>
        </div>
    </div>
    <!--end breadcrumb-->
    
    <div class="row">
        <div class="col-xl-12 mx-auto">
            <h6 class="mb-0 text-uppercase">Management Users</h6>
            <hr/>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="usersTable">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if($user->photo)
                                            <img src="{{ safe_asset('storage/' . $user->photo, 'assets/images/avatars/avatar-1.png') }}" alt="{{ $user->name }}" class="user-avatar rounded-circle" width="40" height="40">
                                        @else
                                            <div class="user-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->contact ?? 'N/A' }}</td>
                                    <td>
                                        @if($user->role == 'super_admin')
                                            <span class="badge bg-danger">Super Admin</span>
                                        @elseif($user->role == 'admin')
                                            <span class="badge bg-primary">Admin</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            @if(Auth::id() == $user->id)
                                                <input class="form-check-input" type="checkbox" id="statusToggle{{ $user->id }}" disabled checked>
                                                <label class="form-check-label" for="statusToggle{{ $user->id }}" title="You cannot deactivate your own account">
                                                    <span class="status-text ms-2" id="statusText{{ $user->id }}">
                                                        <span class="text-success fw-bold">Active</span> <i class='bx bx-info-circle'></i>
                                                    </span>
                                                </label>
                                            @else
                                                <input class="form-check-input status-toggle" type="checkbox" id="statusToggle{{ $user->id }}" data-id="{{ $user->id }}" {{ $user->status == 'active' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="statusToggle{{ $user->id }}">
                                                    <span class="status-text ms-2" id="statusText{{ $user->id }}">
                                                        @if($user->status == 'active')
                                                            <span class="text-success fw-bold">Active</span>
                                                        @else
                                                            <span class="text-danger fw-bold">Inactive</span>
                                                        @endif
                                                    </span>
                                                </label>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex order-actions">
                                            <a href="{{ route('users.management.permissions', $user->id) }}" class="ms-3 text-primary" title="Manage Permissions"><i class='bx bx-key bx-sm'></i></a>
                                            <a href="javascript:;" class="ms-3 edit-user text-warning" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-username="{{ $user->username }}" data-email="{{ $user->email }}" data-contact="{{ $user->contact }}" data-dob="{{ $user->dob ? $user->dob->format('Y-m-d') : '' }}" data-role="{{ $user->role }}" data-status="{{ $user->status }}"><i class='bx bxs-edit bx-sm'></i></a>
                                            <a href="javascript:;" class="ms-3 delete-user text-danger" data-id="{{ $user->id }}"><i class='bx bxs-trash bx-sm'></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Management User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addUserForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="username" name="username" required autocomplete="username">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required autocomplete="username">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="contact" class="form-label">Contact</label>
                                <input type="text" class="form-control" id="contact" name="contact">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password" name="password" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="dob" name="dob" max="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="photo" class="form-label">Photo</label>
                                <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                            </div>
                        </div>
                        
                        <!-- Remove the redundant Role field and keep only Role Assignment -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="role_id" class="form-label">Role Assignment <span class="text-danger">*</span></label>
                                <select class="form-select" id="role_id" name="role_id" required>
                                    <option value="">Select Role</option>
                                    @foreach($roles as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                                <div class="form-text">Select a role to assign default permissions.</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Permissions Section -->
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Permissions</label>
                                <div class="permissions-container">
                                    @if(isset($modules))
                                        @foreach($modules as $moduleKey => $moduleLabel)
                                            <div class="card mb-2">
                                                <div class="card-header">
                                                    <h6 class="mb-0">{{ $moduleLabel }}</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $moduleKey }}-view" id="add-{{ $moduleKey }}-view">
                                                                <label class="form-check-label" for="add-{{ $moduleKey }}-view">
                                                                    View
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $moduleKey }}-create" id="add-{{ $moduleKey }}-create">
                                                                <label class="form-check-label" for="add-{{ $moduleKey }}-create">
                                                                    Create
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $moduleKey }}-update" id="add-{{ $moduleKey }}-update">
                                                                <label class="form-check-label" for="add-{{ $moduleKey }}-update">
                                                                    Update
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $moduleKey }}-delete" id="add-{{ $moduleKey }}-delete">
                                                                <label class="form-check-label" for="add-{{ $moduleKey }}-delete">
                                                                    Delete
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Management User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editUserForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="edit_user_id" name="id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_username" class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_username" name="username" required autocomplete="username">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="edit_email" name="email" required autocomplete="username">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_contact" class="form-label">Contact</label>
                                <input type="text" class="form-control" id="edit_contact" name="contact">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_password" class="form-label">Password (Leave blank to keep current)</label>
                                <input type="password" class="form-control" id="edit_password" name="password" autocomplete="new-password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_dob" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="edit_dob" name="dob" max="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_photo" class="form-label">Photo</label>
                                <input type="file" class="form-control" id="edit_photo" name="photo" accept="image/*">
                                <div class="mt-2" id="current_photo"></div>
                            </div>
                        </div>
                        
                        <!-- Remove the redundant Role field and keep only Role Assignment -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_role_id" class="form-label">Role Assignment <span class="text-danger">*</span></label>
                                <select class="form-select" id="edit_role_id" name="role_id" required>
                                    <option value="">Select Role</option>
                                    @foreach($roles as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                                <div class="form-text">Select a role to assign default permissions.</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Permissions Section -->
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Permissions</label>
                                <div class="permissions-container">
                                    @if(isset($modules))
                                        @foreach($modules as $moduleKey => $moduleLabel)
                                            <div class="card mb-2">
                                                <div class="card-header">
                                                    <h6 class="mb-0">{{ $moduleLabel }}</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $moduleKey }}-view" id="edit-{{ $moduleKey }}-view">
                                                                <label class="form-check-label" for="edit-{{ $moduleKey }}-view">
                                                                    View
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $moduleKey }}-create" id="edit-{{ $moduleKey }}-create">
                                                                <label class="form-check-label" for="edit-{{ $moduleKey }}-create">
                                                                    Create
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $moduleKey }}-update" id="edit-{{ $moduleKey }}-update">
                                                                <label class="form-check-label" for="edit-{{ $moduleKey }}-update">
                                                                    Update
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $moduleKey }}-delete" id="edit-{{ $moduleKey }}-delete">
                                                                <label class="form-check-label" for="edit-{{ $moduleKey }}-delete">
                                                                    Delete
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('styles')
<!-- DataTables CSS -->
<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
<!-- Toastr CSS -->
<link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
<style>
    .user-avatar {
        object-fit: cover;
    }
    .user-avatar img {
        width: 40px;
        height: 40px;
        object-fit: cover;
    }
    .permissions-container .card {
        border: 1px solid #dee2e6;
    }
    .permissions-container .card-header {
        background-color: #f8f9fa;
    }
</style>
@endsection

@section('scripts')
<!-- DataTables JS -->
<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
<!-- Toastr JS -->
<script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#usersTable').DataTable({
            "order": [[ 0, "asc" ]], // Sort by Sr. No by default
            "pageLength": 10,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true
        });
        
        // Initialize Toastr
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    });
    
    // Function to refresh CSRF token
    function refreshCSRFToken() {
        $.get('/refresh-csrf').done(function(data) {
            $('meta[name="csrf-token"]').attr('content', data.token);
        }).fail(function() {
            console.log('Failed to refresh CSRF token');
        });
    }
    
    // Add CSRF token to all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        beforeSend: function(xhr, settings) {
            // Refresh CSRF token before each request
            var token = $('meta[name="csrf-token"]').attr('content');
            if (token) {
                xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        }
    });

    // Status toggle
    $(document).on('change', '.status-toggle', function() {
        var id = $(this).data('id');
        var status = $(this).is(':checked') ? 'active' : 'inactive';
        
        $.ajax({
            url: '{{ url("/admin/users/management") }}/' + id + '/toggle-status',
            type: 'PATCH',
            data: {
                status: status,
                _method: 'PATCH'
            },
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                $('#statusText' + id).html(response.status_text);
                // Show success message
                toastr.success(response.message);
            },
            error: function(xhr) {
                // Revert the toggle switch
                $('#statusToggle' + id).prop('checked', !$('#statusToggle' + id).is(':checked'));
                
                if (xhr.status === 401) {
                    // Session expired, redirect to login
                    toastr.error('Session expired. Redirecting to login...');
                    setTimeout(function() {
                        window.location.href = '{{ route('login') }}';
                    }, 2000);
                } else if (xhr.status === 403) {
                    // Forbidden action (e.g., trying to deactivate own account)
                    toastr.error(xhr.responseJSON.message || 'You do not have permission to perform this action.');
                } else if (xhr.status === 419) {
                    // CSRF token mismatch
                    toastr.error('Page expired. Please refresh the page and try again.');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    toastr.error(xhr.responseJSON.message);
                } else {
                    toastr.error('Error updating user status. Please try again.');
                }
            }
        });
    });

    // Edit user
    $(document).on('click', '.edit-user', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var username = $(this).data('username');
        var email = $(this).data('email');
        var contact = $(this).data('contact');
        var dob = $(this).data('dob');
        var role = $(this).data('role');
        var status = $(this).data('status');
        
        $('#edit_user_id').val(id);
        $('#edit_name').val(name);
        $('#edit_username').val(username);
        $('#edit_email').val(email);
        $('#edit_contact').val(contact);
        $('#edit_dob').val(dob);
        $('#edit_role').val(role);
        $('#edit_status').val(status);
        
        // Reset all permission checkboxes
        $('.permissions-container input[type="checkbox"]').prop('checked', false);
        
        // Fetch user permissions
        $.ajax({
            url: '/admin/users/management/' + id + '/permissions',
            type: 'GET',
            success: function(response) {
                // Check the permission checkboxes based on user permissions
                if (response.permissions) {
                    response.permissions.forEach(function(permission) {
                        $('#edit-' + permission.module + '-' + permission.action).prop('checked', true);
                    });
                }
            },
            error: function(xhr) {
                console.log('Error fetching user permissions');
            }
        });
        
        // Display current photo if exists
        var photoHtml = '';
        // You would need to pass the photo URL from the backend to display it here
        $('#current_photo').html(photoHtml);
        
        $('#editUserModal').modal('show');
    });

    // Delete user
    $(document).on('click', '.delete-user', function() {
        var id = $(this).data('id');
        if (confirm('Are you sure you want to delete this user?')) {
            $.ajax({
                url: '{{ url("/admin/users/management") }}/' + id,
                type: 'DELETE',
                data: {},
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    toastr.success(response.message);
                    // Reload the table data
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        toastr.error(xhr.responseJSON.message);
                    } else {
                        toastr.error('Error deleting user');
                    }
                }
            });
        }
    });

    // Handle form submissions
    $('#addUserForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var formData = new FormData(this);
        
        $.ajax({
            url: '{{ route("users.management.store") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                toastr.success(response.message);
                // Close modal and reset form
                $('#addUserModal').modal('hide');
                $('#addUserForm')[0].reset();
                // Reload the table data
                setTimeout(function() {
                    location.reload();
                }, 1000);
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    var errorMsg = '';
                    $.each(errors, function(key, value) {
                        errorMsg += value[0] + '\n';
                    });
                    toastr.error(errorMsg);
                } else {
                    toastr.error('Error adding user');
                }
            }
        });
    });
    
    $('#editUserForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var id = $('#edit_user_id').val();
        var formData = new FormData(this);
        
        $.ajax({
            url: '{{ url("/admin/users/management") }}/' + id,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-HTTP-Method-Override': 'PUT'
            },
            success: function(response) {
                toastr.success(response.message);
                // Close modal
                $('#editUserModal').modal('hide');
                // Reload the table data
                setTimeout(function() {
                    location.reload();
                }, 1000);
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    var errorMsg = '';
                    $.each(errors, function(key, value) {
                        errorMsg += value[0] + '\n';
                    });
                    toastr.error(errorMsg);
                } else {
                    toastr.error('Error updating user');
                }
            }
        });
    });
    
    // Handle role selection for add user modal
    $('#role_id').on('change', function() {
        var roleId = $(this).val();
        
        // Reset all permission checkboxes
        $('#addUserModal .permissions-container input[type="checkbox"]').prop('checked', false);
        
        // If a role is selected, fetch and check its permissions
        if (roleId) {
            // In a real implementation, you would fetch the role permissions via AJAX
            // For now, we'll simulate this by checking a data attribute
            // In the future, you can make an AJAX call to fetch role permissions
            checkRolePermissions(roleId, 'add');
        }
    });
    
    // Handle role selection for edit user modal
    $('#edit_role_id').on('change', function() {
        var roleId = $(this).val();
        
        // Reset all permission checkboxes
        $('#editUserModal .permissions-container input[type="checkbox"]').prop('checked', false);
        
        // If a role is selected, fetch and check its permissions
        if (roleId) {
            // In a real implementation, you would fetch the role permissions via AJAX
            // For now, we'll simulate this by checking a data attribute
            // In the future, you can make an AJAX call to fetch role permissions
            checkRolePermissions(roleId, 'edit');
        }
    });
    
    // Function to check role permissions
    function checkRolePermissions(roleId, modalType) {
        // Make AJAX call to get role permissions
        $.ajax({
            url: '/admin/roles/' + roleId + '/permissions',
            type: 'GET',
            success: function(response) {
                if (response.permissions) {
                    response.permissions.forEach(function(permission) {
                        var checkboxId = (modalType === 'add' ? 'add-' : 'edit-') + permission.module + '-' + permission.action;
                        $('#' + checkboxId).prop('checked', true);
                    });
                }
            },
            error: function(xhr) {
                console.log('Error fetching role permissions');
            }
        });
    }
</script>
@endsection