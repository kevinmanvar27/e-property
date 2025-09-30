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
                    <li class="breadcrumb-item active" aria-current="page">Districts</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#districtModal" data-action="create">
                <i class="bx bx-plus"></i> Add New District
            </button>
        </div>
    </div>
    <!--end breadcrumb-->
    
    <div class="row">
        <div class="col-xl-12 mx-auto">
            <h6 class="mb-0 text-uppercase">Districts</h6>
            <hr/>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="districtsTable">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>District Name</th>
                                    <th>State</th>
                                    <th>Country</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($districts as $index => $district)
                                <tr data-id="{{ $district->districtid }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td class="district-name">{{ $district->district_title }}</td>
                                    <td class="district-state">{{ $district->state->state_title ?? '-' }}</td>
                                    <td class="district-country">{{ $district->state->country->country_name ?? '-' }}</td>
                                    <td class="district-description">{{ $district->district_description ?? '-' }}</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input toggle-status" type="checkbox" role="switch" 
                                                   data-id="{{ $district->districtid }}" data-status="{{ $district->district_status }}" {{ $district->district_status === 'active' ? 'checked' : '' }}>
                                            <span class="status-text {{ $district->district_status === 'active' ? 'text-success' : 'text-danger' }}">
                                                {{ $district->district_status === 'active' ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex order-actions">
                                            <a href="javascript:;" class="ms-3 edit-district text-warning" 
                                               data-id="{{ $district->districtid }}" 
                                               data-name="{{ $district->district_title }}" 
                                               data-state="{{ $district->state_id }}" 
                                               data-country="{{ $district->state->country_id ?? '' }}"
                                               data-description="{{ $district->district_description }}">
                                                <i class='bx bxs-edit bx-sm'></i>
                                            </a>
                                            <a href="javascript:;" class="ms-3 delete-district text-danger" 
                                               data-id="{{ $district->districtid }}">
                                                <i class='bx bxs-trash bx-sm'></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No districts found</td>
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

<!-- District Modal -->
<div class="modal fade" id="districtModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="districtModalLabel">Add New District</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="district-form">
                @csrf
                <input type="hidden" id="district-id" name="districtid">
                <input type="hidden" id="form-method" name="_method" value="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="district-name" class="form-label">District Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="district-name" name="district_title" required>
                        <div class="invalid-feedback" id="district_title-error"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="district-country" class="form-label">Country <span class="text-danger">*</span></label>
                        <select class="form-select" id="district-country" name="country_id" required>
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->country_id }}">{{ $country->country_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="country_id-error"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="district-state" class="form-label">State <span class="text-danger">*</span></label>
                        <select class="form-select" id="district-state" name="state_id" required>
                            <option value="">Select State</option>
                        </select>
                        <div class="invalid-feedback" id="state_id-error"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="district-description" class="form-label">Description</label>
                        <textarea class="form-control" id="district-description" name="district_description" rows="3"></textarea>
                        <div class="invalid-feedback" id="district_description-error"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="save-district">Save District</button>
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
    var table = $('#districtsTable').DataTable({
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
    const districtModal = document.getElementById('districtModal');
    const districtForm = document.getElementById('district-form');
    const modalTitle = document.getElementById('districtModalLabel');
    const saveButton = document.getElementById('save-district');
    const originalSaveText = saveButton.textContent;
    
    // Handle country change for cascading states
    document.getElementById('district-country').addEventListener('change', function() {
        const countryId = this.value;
        const stateSelect = document.getElementById('district-state');
        
        // Clear existing options
        stateSelect.innerHTML = '<option value="">Select State</option>';
        
        if (countryId) {
            fetch(`/admin/locations/states/${countryId}`)
                .then(response => response.json())
                .then(states => {
                    states.forEach(state => {
                        const option = document.createElement('option');
                        option.value = state.state_id;
                        option.textContent = state.state_title;
                        stateSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('Error loading states.');
                });
        }
    });
    
    // Handle modal show event
    districtModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const action = button.getAttribute('data-action');
        
        // Reset form
        districtForm.reset();
        document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
        document.querySelectorAll('.form-control').forEach(el => el.classList.remove('is-invalid'));
        
        if (action === 'create') {
            // Create new district
            modalTitle.textContent = 'Add New District';
            document.getElementById('district-id').value = '';
            document.getElementById('form-method').value = 'POST';
        } else {
            // Edit existing district
            modalTitle.textContent = 'Edit District';
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const state = button.getAttribute('data-state');
            const country = button.getAttribute('data-country');
            const description = button.getAttribute('data-description');
            
            document.getElementById('district-id').value = id;
            document.getElementById('district-name').value = name;
            document.getElementById('district-country').value = country;
            document.getElementById('district-state').value = state;
            document.getElementById('district-description').value = description || '';
            document.getElementById('form-method').value = 'PUT';
            
            // Load states for the selected country
            if (country) {
                fetch(`/admin/locations/states/${country}`)
                    .then(response => response.json())
                    .then(states => {
                        const stateSelect = document.getElementById('district-state');
                        stateSelect.innerHTML = '<option value="">Select State</option>';
                        states.forEach(state => {
                            const option = document.createElement('option');
                            option.value = state.state_id;
                            option.textContent = state.state_title;
                            if (state.state_id == button.getAttribute('data-state')) {
                                option.selected = true;
                            }
                            stateSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        toastr.error('Error loading states.');
                    });
            }
        }
    });
    
    // Handle form submission
    districtForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const id = document.getElementById('district-id').value;
        const method = document.getElementById('form-method').value;
        const url = id ? `/admin/districts/${id}` : '/admin/districts';
        
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
                        document.getElementById('district-' + field.replace('_', '-')).classList.add('is-invalid');
                    }
                });
            } else if (data.success) {
                // Success - show message and update the table without reload
                toastr.success('District saved successfully!');
                $('#districtModal').modal('hide');
                
                if (id) {
                    // Update existing row
                    const row = document.querySelector(`tr[data-id="${id}"]`);
                    if (row) {
                        row.querySelector('.district-name').textContent = data.district.district_title;
                        row.querySelector('.district-description').textContent = data.district.district_description || '-';
                        row.querySelector('.district-state').textContent = data.district.state.state_title || '-';
                        row.querySelector('.district-country').textContent = data.district.state.country.country_name || '-';
                    }
                } else {
                    // Add new row dynamically
                    const table = $('#districtsTable').DataTable();
                    const newRow = `
                        <tr data-id="${data.district.districtid}">
                            <td>${table.rows().count() + 1}</td>
                            <td class="district-name">${data.district.district_title}</td>
                            <td class="district-state">${data.district.state.state_title || '-'}</td>
                            <td class="district-country">${data.district.state.country.country_name || '-'}</td>
                            <td class="district-description">${data.district.district_description || '-'}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input toggle-status" type="checkbox" role="switch" 
                                           data-id="${data.district.districtid}" data-status="active" checked>
                                    <span class="status-text text-success">Active</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex order-actions">
                                    <a href="javascript:;" class="ms-3 edit-district text-warning" 
                                       data-id="${data.district.districtid}" 
                                       data-name="${data.district.district_title}" 
                                       data-state="${data.district.state_id}" 
                                       data-country="${data.district.state.country_id}"
                                       data-description="${data.district.district_description || ''}">
                                        <i class='bx bxs-edit bx-sm'></i>
                                    </a>
                                    <a href="javascript:;" class="ms-3 delete-district text-danger" 
                                       data-id="${data.district.districtid}">
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
        if (e.target.closest('.edit-district')) {
            const button = e.target.closest('.edit-district');
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const state = button.getAttribute('data-state');
            const country = button.getAttribute('data-country');
            const description = button.getAttribute('data-description');
            
            // Set form values
            document.getElementById('district-id').value = id;
            document.getElementById('district-name').value = name;
            document.getElementById('district-country').value = country;
            document.getElementById('district-state').value = state;
            document.getElementById('district-description').value = description || '';
            document.getElementById('form-method').value = 'PUT';
            document.getElementById('districtModalLabel').textContent = 'Edit District';
            
            // Load states for the selected country
            if (country) {
                fetch(`/admin/locations/states/${country}`)
                    .then(response => response.json())
                    .then(states => {
                        const stateSelect = document.getElementById('district-state');
                        stateSelect.innerHTML = '<option value="">Select State</option>';
                        states.forEach(state => {
                            const option = document.createElement('option');
                            option.value = state.state_id;
                            option.textContent = state.state_title;
                            if (state.state_id == button.getAttribute('data-state')) {
                                option.selected = true;
                            }
                            stateSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        toastr.error('Error loading states.');
                    });
            }
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('districtModal'));
            modal.show();
        }
    });
    
    // Handle delete buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-district')) {
            const button = e.target.closest('.delete-district');
            const id = button.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this district?')) {
                fetch(`/admin/districts/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        toastr.success('District deleted successfully!');
                        // Remove row from table without reload
                        const table = $('#districtsTable').DataTable();
                        const row = document.querySelector(`tr[data-id="${id}"]`);
                        if (row) {
                            table.row(row).remove().draw(false);
                        }
                    } else {
                        toastr.error('Error deleting district.');
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
            
            fetch(`/admin/districts/${id}`, {
                method: 'PUT',
                body: JSON.stringify({ 
                    district_status: status,
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
                    toastr.success('District status updated successfully!');
                    // Update status text and color
                    statusText.textContent = status === 'active' ? 'Active' : 'Inactive';
                    statusText.className = status === 'active' ? 'status-text text-success' : 'status-text text-danger';
                } else {
                    toastr.error('Error updating district status.');
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