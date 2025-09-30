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
                    <li class="breadcrumb-item active" aria-current="page">Countries</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#countryModal" data-action="create">
                <i class="bx bx-plus"></i> Add New Country
            </button>
        </div>
    </div>
    <!--end breadcrumb-->
    
    <div class="row">
        <div class="col-xl-12 mx-auto">
            <h6 class="mb-0 text-uppercase">Countries</h6>
            <hr/>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="countriesTable">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Country Name</th>
                                    <th>Country Code</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($countries as $index => $country)
                                <tr data-id="{{ $country->country_id }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td class="country-name">{{ $country->country_name }}</td>
                                    <td class="country-code">{{ $country->country_code ?? '-' }}</td>
                                    <td class="country-description">{{ $country->description ?? '-' }}</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input toggle-status" type="checkbox" role="switch" 
                                                   data-id="{{ $country->country_id }}" data-status="{{ $country->status }}" {{ $country->status === 'active' ? 'checked' : '' }}>
                                            <span class="status-text {{ $country->status === 'active' ? 'text-success' : 'text-danger' }}">
                                                {{ $country->status === 'active' ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex order-actions">
                                            <a href="javascript:;" class="ms-3 edit-country text-warning" 
                                               data-id="{{ $country->country_id }}" 
                                               data-name="{{ $country->country_name }}" 
                                               data-code="{{ $country->country_code }}" 
                                               data-description="{{ $country->description }}">
                                                <i class='bx bxs-edit bx-sm'></i>
                                            </a>
                                            <a href="javascript:;" class="ms-3 delete-country text-danger" 
                                               data-id="{{ $country->country_id }}">
                                                <i class='bx bxs-trash bx-sm'></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No countries found</td>
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

<!-- Country Modal -->
<div class="modal fade" id="countryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="countryModalLabel">Add New Country</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="country-form">
                @csrf
                <input type="hidden" id="country-id" name="country_id">
                <input type="hidden" id="form-method" name="_method" value="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="country-name" class="form-label">Country Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="country-name" name="country_name" required>
                        <div class="invalid-feedback" id="country_name-error"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="country-code" class="form-label">Country Code</label>
                        <input type="text" class="form-control" id="country-code" name="country_code" maxlength="3">
                        <div class="invalid-feedback" id="country_code-error"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="country-description" class="form-label">Description</label>
                        <textarea class="form-control" id="country-description" name="description" rows="3"></textarea>
                        <div class="invalid-feedback" id="description-error"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="save-country">Save Country</button>
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
    var table = $('#countriesTable').DataTable({
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
    const countryModal = document.getElementById('countryModal');
    const countryForm = document.getElementById('country-form');
    const modalTitle = document.getElementById('countryModalLabel');
    const saveButton = document.getElementById('save-country');
    const originalSaveText = saveButton.textContent;
    
    // Handle modal show event
    countryModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const action = button.getAttribute('data-action');
        
        // Reset form
        countryForm.reset();
        document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
        document.querySelectorAll('.form-control').forEach(el => el.classList.remove('is-invalid'));
        
        if (action === 'create') {
            // Create new country
            modalTitle.textContent = 'Add New Country';
            document.getElementById('country-id').value = '';
            document.getElementById('form-method').value = 'POST';
        } else {
            // Edit existing country
            modalTitle.textContent = 'Edit Country';
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const code = button.getAttribute('data-code');
            const description = button.getAttribute('data-description');
            
            document.getElementById('country-id').value = id;
            document.getElementById('country-name').value = name;
            document.getElementById('country-code').value = code || '';
            document.getElementById('country-description').value = description || '';
            document.getElementById('form-method').value = 'PUT';
        }
    });
    
    // Handle form submission
    countryForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const id = document.getElementById('country-id').value;
        const method = document.getElementById('form-method').value;
        const url = id ? `/admin/countries/${id}` : '/admin/countries';
        
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
                        document.getElementById('country-' + field.replace('_', '-')).classList.add('is-invalid');
                    }
                });
            } else if (data.success) {
                // Success - show message and update the table without reload
                toastr.success('Country saved successfully!');
                $('#countryModal').modal('hide');
                
                if (id) {
                    // Update existing row
                    const row = document.querySelector(`tr[data-id="${id}"]`);
                    if (row) {
                        row.querySelector('.country-name').textContent = data.country.country_name;
                        row.querySelector('.country-code').textContent = data.country.country_code || '-';
                        row.querySelector('.country-description').textContent = data.country.description || '-';
                    }
                } else {
                    // Add new row dynamically
                    const table = $('#countriesTable').DataTable();
                    const newRow = `
                        <tr data-id="${data.country.country_id}">
                            <td>${table.rows().count() + 1}</td>
                            <td class="country-name">${data.country.country_name}</td>
                            <td class="country-code">${data.country.country_code || '-'}</td>
                            <td class="country-description">${data.country.description || '-'}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input toggle-status" type="checkbox" role="switch" 
                                           data-id="${data.country.country_id}" data-status="active" checked>
                                    <span class="status-text text-success">Active</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex order-actions">
                                    <a href="javascript:;" class="ms-3 edit-country text-warning" 
                                       data-id="${data.country.country_id}" 
                                       data-name="${data.country.country_name}" 
                                       data-code="${data.country.country_code || ''}" 
                                       data-description="${data.country.description || ''}">
                                        <i class='bx bxs-edit bx-sm'></i>
                                    </a>
                                    <a href="javascript:;" class="ms-3 delete-country text-danger" 
                                       data-id="${data.country.country_id}">
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
        if (e.target.closest('.edit-country')) {
            const button = e.target.closest('.edit-country');
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const code = button.getAttribute('data-code');
            const description = button.getAttribute('data-description');
            
            // Set form values
            document.getElementById('country-id').value = id;
            document.getElementById('country-name').value = name;
            document.getElementById('country-code').value = code || '';
            document.getElementById('country-description').value = description || '';
            document.getElementById('form-method').value = 'PUT';
            document.getElementById('countryModalLabel').textContent = 'Edit Country';
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('countryModal'));
            modal.show();
        }
    });
    
    // Handle delete buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-country')) {
            const button = e.target.closest('.delete-country');
            const id = button.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this country?')) {
                fetch(`/admin/countries/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        toastr.success('Country deleted successfully!');
                        // Remove row from table without reload
                        const table = $('#countriesTable').DataTable();
                        const row = document.querySelector(`tr[data-id="${id}"]`);
                        if (row) {
                            table.row(row).remove().draw(false);
                        }
                    } else {
                        toastr.error('Error deleting country.');
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
            
            fetch(`/admin/countries/${id}`, {
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
                    toastr.success('Country status updated successfully!');
                    // Update status text and color
                    statusText.textContent = status === 'active' ? 'Active' : 'Inactive';
                    statusText.className = status === 'active' ? 'status-text text-success' : 'status-text text-danger';
                } else {
                    toastr.error('Error updating country status.');
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