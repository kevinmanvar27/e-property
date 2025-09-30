@extends('admin.layouts.app')

@section('content')
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Master Data</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">States</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#stateModal" data-action="create">
                <i class="bx bx-plus"></i> Add New State
            </button>
        </div>
    </div>
    <!--end breadcrumb-->
    
    <div class="row">
        <div class="col-xl-12 mx-auto">
            <h6 class="mb-0 text-uppercase">States</h6>
            <hr/>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="statesTable">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>State Name</th>
                                    <th>Country</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($states as $index => $state)
                                <tr data-id="{{ $state->state_id }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td class="state-name">{{ $state->state_title }}</td>
                                    <td class="state-country">{{ $state->country->country_name ?? '-' }}</td>
                                    <td class="state-description">{{ $state->state_description ?? '-' }}</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input toggle-status" type="checkbox" role="switch" 
                                                   data-id="{{ $state->state_id }}" data-status="{{ $state->status }}" {{ $state->status === 'active' ? 'checked' : '' }}>
                                            <span class="status-text {{ $state->status === 'active' ? 'text-success' : 'text-danger' }}">
                                                {{ $state->status === 'active' ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex order-actions">
                                            <a href="javascript:;" class="ms-3 edit-state text-warning" 
                                               data-id="{{ $state->state_id }}" 
                                               data-name="{{ $state->state_title }}" 
                                               data-country="{{ $state->country_id }}" 
                                               data-description="{{ $state->state_description }}">
                                                <i class='bx bxs-edit bx-sm'></i>
                                            </a>
                                            <a href="javascript:;" class="ms-3 delete-state text-danger" 
                                               data-id="{{ $state->state_id }}">
                                                <i class='bx bxs-trash bx-sm'></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No states found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- State Modal -->
<div class="modal fade" id="stateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stateModalLabel">Add New State</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="state-form">
                @csrf
                <input type="hidden" id="state-id" name="state_id">
                <input type="hidden" id="form-method" name="_method" value="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="state-name" class="form-label">State Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="state-name" name="state_title" required>
                        <div class="invalid-feedback" id="state_title-error"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="state-country" class="form-label">Country <span class="text-danger">*</span></label>
                        <select class="form-select" id="state-country" name="country_id" required>
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->country_id }}">{{ $country->country_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="country_id-error"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="state-description" class="form-label">Description</label>
                        <textarea class="form-control" id="state-description" name="state_description" rows="3"></textarea>
                        <div class="invalid-feedback" id="state_description-error"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="save-state">Save State</button>
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
    var table = $('#statesTable').DataTable({
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

document.addEventListener('DOMContentLoaded', function() {
    const stateModal = document.getElementById('stateModal');
    const stateForm = document.getElementById('state-form');
    const modalTitle = document.getElementById('stateModalLabel');
    const saveButton = document.getElementById('save-state');
    const originalSaveText = saveButton.textContent;
    
    // Handle modal show event
    stateModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const action = button.getAttribute('data-action');
        
        // Reset form
        stateForm.reset();
        document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
        document.querySelectorAll('.form-control').forEach(el => el.classList.remove('is-invalid'));
        
        if (action === 'create') {
            // Create new state
            modalTitle.textContent = 'Add New State';
            document.getElementById('state-id').value = '';
            document.getElementById('form-method').value = 'POST';
        } else {
            // Edit existing state
            modalTitle.textContent = 'Edit State';
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const country = button.getAttribute('data-country');
            const description = button.getAttribute('data-description');
            
            document.getElementById('state-id').value = id;
            document.getElementById('state-name').value = name;
            document.getElementById('state-country').value = country;
            document.getElementById('state-description').value = description || '';
            document.getElementById('form-method').value = 'PUT';
        }
    });
    
    // Handle form submission
    stateForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const id = document.getElementById('state-id').value;
        const method = document.getElementById('form-method').value;
        const url = id ? `/admin/states/${id}` : '/admin/states';
        
        // Show loading state
        saveButton.disabled = true;
        saveButton.textContent = 'Saving...';
        
        // Clear previous errors
        document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        
        fetch(url, {
            method: method === 'PUT' ? 'POST' : method,
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-HTTP-Method-Override': method === 'PUT' ? 'PUT' : ''
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.errors) {
                // Handle validation errors
                Object.keys(data.errors).forEach(field => {
                    const errorElement = document.getElementById(field + '-error');
                    if (errorElement) {
                        errorElement.textContent = data.errors[field][0];
                        document.getElementById('state-' + field.replace('_', '-')).classList.add('is-invalid');
                    }
                });
            } else if (data.success) {
                // Success - show message and update the table without reload
                toastr.success('State saved successfully!');
                $('#stateModal').modal('hide');
                
                if (id) {
                    // Update existing row
                    const row = document.querySelector(`tr[data-id="${id}"]`);
                    if (row) {
                        row.querySelector('.state-name').textContent = data.state.state_title;
                        row.querySelector('.state-description').textContent = data.state.state_description || '-';
                        row.querySelector('.state-country').textContent = data.state.country.country_name || '-';
                    }
                } else {
                    // Add new row dynamically
                    const table = $('#statesTable').DataTable();
                    const newRow = `
                        <tr data-id="${data.state.state_id}">
                            <td>${table.rows().count() + 1}</td>
                            <td class="state-name">${data.state.state_title}</td>
                            <td class="state-country">${data.state.country?.country_name || '-'}</td>
                            <td class="state-description">${data.state.state_description || '-'}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input toggle-status" type="checkbox" role="switch" 
                                           data-id="${data.state.state_id}" data-status="active" checked>
                                    <span class="status-text text-success">Active</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex order-actions">
                                    <a href="javascript:;" class="ms-3 edit-state text-warning" 
                                       data-id="${data.state.state_id}" 
                                       data-name="${data.state.state_title}" 
                                       data-country="${data.state.country_id}" 
                                       data-description="${data.state.state_description || ''}">
                                        <i class='bx bxs-edit bx-sm'></i>
                                    </a>
                                    <a href="javascript:;" class="ms-3 delete-state text-danger" 
                                       data-id="${data.state.state_id}">
                                        <i class='bx bxs-trash bx-sm'></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    `;
                    table.row.add($(newRow)).draw(false);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.error('An error occurred. Please try again.');
        })
        .finally(() => {
            // Reset loading state
            saveButton.disabled = false;
            saveButton.textContent = originalSaveText;
        });
    });
    
    // Handle edit buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('.edit-state')) {
            const button = e.target.closest('.edit-state');
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const country = button.getAttribute('data-country');
            const description = button.getAttribute('data-description');
            
            // Set form values
            document.getElementById('state-id').value = id;
            document.getElementById('state-name').value = name;
            document.getElementById('state-country').value = country;
            document.getElementById('state-description').value = description || '';
            document.getElementById('form-method').value = 'PUT';
            document.getElementById('stateModalLabel').textContent = 'Edit State';
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('stateModal'));
            modal.show();
        }
    });
    
    // Handle delete buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-state')) {
            const button = e.target.closest('.delete-state');
            const id = button.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this state?')) {
                fetch(`/admin/states/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        toastr.success('State deleted successfully!');
                        // Remove row from table without reload
                        const table = $('#statesTable').DataTable();
                        const row = document.querySelector(`tr[data-id="${id}"]`);
                        if (row) {
                            table.row(row).remove().draw(false);
                        }
                    } else {
                        toastr.error('Error deleting state.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('An error occurred. Please try again.');
                });
            }
        }
    });
    
    // Handle status toggle
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('toggle-status')) {
            const id = e.target.getAttribute('data-id');
            const status = e.target.checked ? 'active' : 'inactive';
            const statusText = e.target.nextElementSibling;
            
            fetch(`/admin/states/${id}`, {
                method: 'PUT',
                body: JSON.stringify({ 
                    status: status,
                    _method: 'PUT'
                }),
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    toastr.success('State status updated successfully!');
                    // Update status text and color
                    statusText.textContent = status === 'active' ? 'Active' : 'Inactive';
                    statusText.className = status === 'active' ? 'status-text text-success' : 'status-text text-danger';
                } else {
                    toastr.error('Error updating state status.');
                    // Revert the toggle
                    e.target.checked = !e.target.checked;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toastr.error('An error occurred. Please try again.');
                // Revert the toggle
                e.target.checked = !e.target.checked;
            });
        }
    });
});
</script>
@endsection