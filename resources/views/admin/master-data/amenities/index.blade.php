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
                    <li class="breadcrumb-item active" aria-current="page">Amenities</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#amenityModal" data-action="create">
                <i class="bx bx-plus"></i> Add New Amenity
            </button>
        </div>
    </div>
    <!--end breadcrumb-->
    
    <div class="row">
        <div class="col-xl-12 mx-auto">
            <h6 class="mb-0 text-uppercase">Amenities</h6>
            <hr/>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="amenitiesTable">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($amenities as $index => $amenity)
                                <tr data-id="{{ $amenity->id }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td class="amenity-name">{{ $amenity->name }}</td>
                                    <td class="amenity-description">{{ $amenity->description ?? '-' }}</td>
                                    <td>
                                        <div class="d-flex order-actions">
                                            <a href="javascript:;" class="ms-3 edit-amenity text-warning" 
                                               data-id="{{ $amenity->id }}" 
                                               data-name="{{ $amenity->name }}" 
                                               data-description="{{ $amenity->description }}">
                                                <i class='bx bxs-edit bx-sm'></i>
                                            </a>
                                            <a href="javascript:;" class="ms-3 delete-amenity text-danger" 
                                               data-id="{{ $amenity->id }}">
                                                <i class='bx bxs-trash bx-sm'></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">No amenities found</td>
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

<!-- Amenity Modal -->
<div class="modal fade" id="amenityModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="amenityModalLabel">Add New Amenity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="amenity-form">
                @csrf
                <input type="hidden" id="amenity-id" name="id">
                <input type="hidden" id="form-method" name="_method" value="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="amenity-name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="amenity-name" name="name" required>
                        <div class="invalid-feedback" id="name-error"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="amenity-description" class="form-label">Description</label>
                        <textarea class="form-control" id="amenity-description" name="description" rows="3"></textarea>
                        <div class="invalid-feedback" id="description-error"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="save-amenity">Save Amenity</button>
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
    var table = $('#amenitiesTable').DataTable({
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
    const amenityModal = document.getElementById('amenityModal');
    const amenityForm = document.getElementById('amenity-form');
    const modalTitle = document.getElementById('amenityModalLabel');
    const saveButton = document.getElementById('save-amenity');
    const originalSaveText = saveButton.textContent;
    
    // Handle modal show event
    amenityModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const action = button.getAttribute('data-action');
        
        // Reset form
        amenityForm.reset();
        document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
        document.querySelectorAll('.form-control').forEach(el => el.classList.remove('is-invalid'));
        
        if (action === 'create') {
            // Create new amenity
            modalTitle.textContent = 'Add New Amenity';
            document.getElementById('amenity-id').value = '';
            document.getElementById('form-method').value = 'POST';
        } else {
            // Edit existing amenity
            modalTitle.textContent = 'Edit Amenity';
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const description = button.getAttribute('data-description');
            
            document.getElementById('amenity-id').value = id;
            document.getElementById('amenity-name').value = name;
            document.getElementById('amenity-description').value = description || '';
            document.getElementById('form-method').value = 'PUT';
        }
    });
    
    // Handle form submission
    amenityForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const id = document.getElementById('amenity-id').value;
        const method = document.getElementById('form-method').value;
        const url = id ? `/admin/amenities/${id}` : '/admin/amenities';
        
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
                        document.getElementById('amenity-' + field).classList.add('is-invalid');
                    }
                });
            } else if (data.success) {
                // Success - show message and reload the table
                toastr.success('Amenity saved successfully!');
                $('#amenityModal').modal('hide');
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
        if (e.target.closest('.edit-amenity')) {
            const button = e.target.closest('.edit-amenity');
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const description = button.getAttribute('data-description');
            
            // Set form values
            document.getElementById('amenity-id').value = id;
            document.getElementById('amenity-name').value = name;
            document.getElementById('amenity-description').value = description || '';
            document.getElementById('form-method').value = 'PUT';
            document.getElementById('amenityModalLabel').textContent = 'Edit Amenity';
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('amenityModal'));
            modal.show();
        }
    });
    
    // Handle delete buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-amenity')) {
            const button = e.target.closest('.delete-amenity');
            const id = button.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this amenity?')) {
                fetch(`/admin/amenities/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        toastr.success('Amenity deleted successfully!');
                        location.reload();
                    } else {
                        toastr.error('Error deleting amenity.');
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