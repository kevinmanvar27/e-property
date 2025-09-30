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
                    <li class="breadcrumb-item active" aria-current="page">Land Types</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#landTypeModal" data-action="create">
                <i class="bx bx-plus"></i> Add New Land Type
            </button>
        </div>
    </div>
    <!--end breadcrumb-->
    
    <div class="row">
        <div class="col-xl-12 mx-auto">
            <h6 class="mb-0 text-uppercase">Land Types</h6>
            <hr/>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="landTypesTable">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($landTypes as $index => $landType)
                                <tr data-id="{{ $landType->id }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td class="land-type-name">{{ $landType->name }}</td>
                                    <td class="land-type-description">{{ $landType->description ?? '-' }}</td>
                                    <td>
                                        <div class="d-flex order-actions">
                                            <a href="javascript:;" class="ms-3 edit-land-type text-warning" 
                                               data-id="{{ $landType->id }}" 
                                               data-name="{{ $landType->name }}" 
                                               data-description="{{ $landType->description }}">
                                                <i class='bx bxs-edit bx-sm'></i>
                                            </a>
                                            <a href="javascript:;" class="ms-3 delete-land-type text-danger" 
                                               data-id="{{ $landType->id }}">
                                                <i class='bx bxs-trash bx-sm'></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">No land types found</td>
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

<!-- Land Type Modal -->
<div class="modal fade" id="landTypeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="landTypeModalLabel">Add New Land Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="land-type-form">
                @csrf
                <input type="hidden" id="land-type-id" name="id">
                <input type="hidden" id="land-type-form-method" name="_method" value="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="land-type-name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="land-type-name" name="name" required>
                        <div class="invalid-feedback" id="land-type-name-error"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="land-type-description" class="form-label">Description</label>
                        <textarea class="form-control" id="land-type-description" name="description" rows="3"></textarea>
                        <div class="invalid-feedback" id="land-type-description-error"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="save-land-type">Save Land Type</button>
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
    var table = $('#landTypesTable').DataTable({
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
    const landTypeModal = document.getElementById('landTypeModal');
    const landTypeForm = document.getElementById('land-type-form');
    const modalTitle = document.getElementById('landTypeModalLabel');
    const saveButton = document.getElementById('save-land-type');
    const originalSaveText = saveButton.textContent;
    
    // Handle modal show event
    landTypeModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const action = button.getAttribute('data-action');
        
        // Reset form
        landTypeForm.reset();
        document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
        document.querySelectorAll('.form-control').forEach(el => el.classList.remove('is-invalid'));
        
        if (action === 'create') {
            // Create new land type
            modalTitle.textContent = 'Add New Land Type';
            document.getElementById('land-type-id').value = '';
            document.getElementById('land-type-form-method').value = 'POST';
        } else {
            // Edit existing land type
            modalTitle.textContent = 'Edit Land Type';
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const description = button.getAttribute('data-description');
            
            document.getElementById('land-type-id').value = id;
            document.getElementById('land-type-name').value = name;
            document.getElementById('land-type-description').value = description || '';
            document.getElementById('land-type-form-method').value = 'PUT';
        }
    });
    
    // Handle form submission
    landTypeForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const id = document.getElementById('land-type-id').value;
        const method = document.getElementById('land-type-form-method').value;
        const url = id ? `/admin/land-types/${id}` : '/admin/land-types';
        
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
                    const errorElement = document.getElementById('land-type-' + field + '-error');
                    if (errorElement) {
                        errorElement.textContent = data.errors[field][0];
                        document.getElementById('land-type-' + field).classList.add('is-invalid');
                    }
                });
            } else if (data.success) {
                // Success - show message and reload the table
                toastr.success('Land type saved successfully!');
                $('#landTypeModal').modal('hide');
                location.reload();
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
        if (e.target.closest('.edit-land-type')) {
            const button = e.target.closest('.edit-land-type');
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const description = button.getAttribute('data-description');
            
            // Set form values
            document.getElementById('land-type-id').value = id;
            document.getElementById('land-type-name').value = name;
            document.getElementById('land-type-description').value = description || '';
            document.getElementById('land-type-form-method').value = 'PUT';
            document.getElementById('landTypeModalLabel').textContent = 'Edit Land Type';
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('landTypeModal'));
            modal.show();
        }
    });
    
    // Handle delete buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-land-type')) {
            const button = e.target.closest('.delete-land-type');
            const id = button.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this land type?')) {
                fetch(`/admin/land-types/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        toastr.success('Land type deleted successfully!');
                        location.reload();
                    } else {
                        toastr.error('Error deleting land type.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('An error occurred. Please try again.');
                });
            }
        }
    });
});
</script>
@endsection