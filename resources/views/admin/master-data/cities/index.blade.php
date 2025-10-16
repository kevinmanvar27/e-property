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
                    <li class="breadcrumb-item active" aria-current="page">Cities/Talukas</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cityModal" data-action="create">
                <i class="bx bx-plus"></i> Add New City/Taluka
            </button>
        </div>
    </div>
    <!--end breadcrumb-->
    
    <div class="row">
        <div class="col-xl-12 mx-auto">
            <h6 class="mb-0 text-uppercase">Cities/Talukas</h6>
            <hr/>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="citiesTable">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>City/Taluka Name</th>
                                    <th>District</th>
                                    <th>State</th>
                                    <th>Country</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cities as $index => $city)
                                <tr data-id="{{ $city->id }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td class="city-name">{{ $city->name }}</td>
                                    <td class="city-district">{{ $city->district->district_title ?? '-' }}</td>
                                    <td class="city-state">{{ $city->state->state_title ?? '-' }}</td>
                                    <td class="city-country">{{ $city->state->country->country_name ?? '-' }}</td>
                                    <td class="city-description">{{ $city->description ?? '-' }}</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input toggle-status" type="checkbox" role="switch" 
                                                   data-id="{{ $city->id }}" data-status="{{ $city->status }}" {{ $city->status === 'active' ? 'checked' : '' }}>
                                            <span class="status-text {{ $city->status === 'active' ? 'text-success' : 'text-danger' }}">
                                                {{ $city->status === 'active' ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex order-actions">
                                            <a href="javascript:;" class="ms-3 edit-city text-warning" 
                                               data-id="{{ $city->id }}" 
                                               data-name="{{ $city->name }}" 
                                               data-district="{{ $city->districtid }}" 
                                               data-state="{{ $city->state_id }}" 
                                               data-country="{{ $city->state->country_id ?? '' }}"
                                               data-description="{{ $city->description }}"
                                               data-bs-toggle="modal" 
                                               data-bs-target="#cityModal">
                                                <i class='bx bxs-edit bx-sm'></i>
                                            </a>
                                            <a href="javascript:;" class="ms-3 delete-city text-danger" 
                                               data-id="{{ $city->id }}">
                                                <i class='bx bxs-trash bx-sm'></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No cities/talukas found</td>
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

<!-- City Modal -->
<div class="modal fade" id="cityModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cityModalLabel">Add New City/Taluka</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="city-form">
                @csrf
                <input type="hidden" id="city-id" name="id">
                <input type="hidden" id="form-method" name="_method" value="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="city-name" class="form-label">City/Taluka Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="city-name" name="name" required>
                        <div class="invalid-feedback" id="name-error"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="city-country" class="form-label">Country <span class="text-danger">*</span></label>
                        <select class="form-select" id="city-country" name="country_id" required>
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->country_id }}">{{ $country->country_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="country_id-error"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="city-state" class="form-label">State <span class="text-danger">*</span></label>
                        <select class="form-select" id="city-state" name="state_id" required>
                            <option value="">Select State</option>
                        </select>
                        <div class="invalid-feedback" id="state_id-error"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="city-district" class="form-label">District <span class="text-danger">*</span></label>
                        <select class="form-select" id="city-district" name="districtid" required>
                            <option value="">Select District</option>
                        </select>
                        <div class="invalid-feedback" id="districtid-error"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="city-description" class="form-label">Description</label>
                        <textarea class="form-control" id="city-description" name="description" rows="3"></textarea>
                        <div class="invalid-feedback" id="description-error"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="save-city">Save City/Taluka</button>
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
    var table = $('#citiesTable').DataTable({
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

// Add CSRF token and AJAX header to all AJAX requests
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

document.addEventListener('DOMContentLoaded', function() {
    const cityModal = document.getElementById('cityModal');
    const cityForm = document.getElementById('city-form');
    const modalTitle = document.getElementById('cityModalLabel');
    const saveButton = document.getElementById('save-city');
    const originalSaveText = saveButton.textContent;
    
    // Handle country change for cascading states
    document.getElementById('city-country').addEventListener('change', function() {
        const countryId = this.value;
        const stateSelect = document.getElementById('city-state');
        const districtSelect = document.getElementById('city-district');
        
        // Clear existing options
        stateSelect.innerHTML = '<option value="">Select State</option>';
        districtSelect.innerHTML = '<option value="">Select District</option>';
        
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
    
    // Handle state change for cascading districts
    document.getElementById('city-state').addEventListener('change', function() {
        const stateId = this.value;
        const districtSelect = document.getElementById('city-district');
        
        // Clear existing options
        districtSelect.innerHTML = '<option value="">Select District</option>';
        
        if (stateId) {
            fetch(`/admin/locations/districts/${stateId}`)
                .then(response => response.json())
                .then(districts => {
                    districts.forEach(district => {
                        const option = document.createElement('option');
                        option.value = district.districtid;
                        option.textContent = district.district_title;
                        districtSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('Error loading districts.');
                });
        }
    });
    
    // Handle modal show event
    cityModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const action = button.getAttribute('data-action');

        // Reset form
        cityForm.reset();
        document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
        document.querySelectorAll('.form-control').forEach(el => el.classList.remove('is-invalid'));

        if (action === 'create') {
            modalTitle.textContent = 'Add New City/Taluka';
            document.getElementById('city-id').value = '';
            document.getElementById('form-method').value = 'POST';
            document.getElementById('city-district').innerHTML = '<option value="">Select District</option>';
        } else {
            modalTitle.textContent = 'Edit City/Taluka';
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const district = button.getAttribute('data-district');
            const state = button.getAttribute('data-state');
            const country = button.getAttribute('data-country');
            const description = button.getAttribute('data-description');

            document.getElementById('city-id').value = id;
            document.getElementById('city-name').value = name;
            document.getElementById('city-country').value = country;
            document.getElementById('city-description').value = description || '';
            document.getElementById('form-method').value = 'PUT';

            if (country) {
                fetch(`/admin/locations/states/${country}`)
                    .then(res => res.json())
                    .then(states => {
                        const stateSelect = document.getElementById('city-state');
                        stateSelect.innerHTML = '<option value="">Select State</option>';
                        states.forEach(st => {
                            const option = document.createElement('option');
                            option.value = st.state_id;
                            option.textContent = st.state_title;
                            stateSelect.appendChild(option);
                        });

                        // Now set the selected state
                        stateSelect.value = state;

                        // Fetch districts for this state
                        if (state) {
                            fetch(`/admin/locations/districts/${state}`)
                                .then(res => res.json())
                                .then(districts => {
                                    const districtSelect = document.getElementById('city-district');
                                    districtSelect.innerHTML = '<option value="">Select District</option>';
                                    districts.forEach(dist => {
                                        const option = document.createElement('option');
                                        option.value = dist.districtid;
                                        option.textContent = dist.district_title;
                                        districtSelect.appendChild(option);
                                    });

                                    // Now set the selected district
                                    districtSelect.value = district;
                                })
                                .catch(err => {
                                    console.error('Error loading districts:', err);
                                    toastr.error('Error loading districts.');
                                });
                        }
                    })
                    .catch(err => {
                        console.error('Error loading states:', err);
                        toastr.error('Error loading states.');
                    });
            }
        }
    });
    
    // Handle form submission
    cityForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const id = document.getElementById('city-id').value;
        const method = document.getElementById('form-method').value;
        const url = id ? `/admin/cities/${id}` : '/admin/cities';
        
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
                        document.getElementById('city-' + field).classList.add('is-invalid');
                    }
                });
            } else if (data.success) {
                // Success - show message and update the table without reload
                toastr.success('City/Taluka saved successfully!');
                $('#cityModal').modal('hide');
                
                if (id) {
                    // Update existing row
                    const row = document.querySelector(`tr[data-id="${id}"]`);
                    if (row) {
                        row.querySelector('.city-name').textContent = data.city.name;
                        row.querySelector('.city-description').textContent = data.city.description || '-';
                        row.querySelector('.city-district').textContent = data.city.district.district_title || '-';
                        row.querySelector('.city-state').textContent = data.city.state.state_title || '-';
                        row.querySelector('.city-country').textContent = data.city.state.country.country_name || '-';
                    }
                } else {
                    // Add new row dynamically
                    const table = $('#citiesTable').DataTable();
                    const newRow = `
                        <tr data-id="${data.city.id}">
                            <td>${table.rows().count() + 1}</td>
                            <td class="city-name">${data.city.name}</td>
                            <td class="city-district">${data.city.district.district_title || '-'}</td>
                            <td class="city-state">${data.city.state.state_title || '-'}</td>
                            <td class="city-country">${data.city.state.country.country_name || '-'}</td>
                            <td class="city-description">${data.city.description || '-'}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input toggle-status" type="checkbox" role="switch" 
                                           data-id="${data.city.id}" data-status="${data.city.status}" ${data.city.status === 'active' ? 'checked' : ''}>
                                    <span class="status-text ${data.city.status === 'active' ? 'text-success' : 'text-danger'}">
                                        ${data.city.status === 'active' ? 'Active' : 'Inactive'}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex order-actions">
                                    <a href="javascript:;" class="ms-3 edit-city text-warning" 
                                       data-id="${data.city.id}" 
                                       data-name="${data.city.name}" 
                                       data-district="${data.city.districtid}" 
                                       data-state="${data.city.state_id}" 
                                       data-country="${data.city.state.country_id || ''}"
                                       data-description="${data.city.description || ''}">
                                        <i class='bx bxs-edit bx-sm'></i>
                                    </a>
                                    <a href="javascript:;" class="ms-3 delete-city text-danger" 
                                       data-id="${data.city.id}">
                                        <i class='bx bxs-trash bx-sm'></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    `;
                    const addedRow = table.row.add($(newRow)).draw(false);
                    // Get the actual node to add data-id attribute
                    const addedNode = addedRow.node();
                    addedNode.setAttribute('data-id', data.city.id);
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
    
    // Handle delete buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-city')) {
            const button = e.target.closest('.delete-city');
            const id = button.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this city/taluka?')) {
                fetch(`/admin/cities/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        toastr.success('City/Taluka deleted successfully!');
                        // Remove row from table without reload
                        const table = $('#citiesTable').DataTable();
                        const row = document.querySelector(`tr[data-id="${id}"]`);
                        if (row) {
                            table.row(row).remove().draw(false);
                        }
                    } else {
                        toastr.error('Error deleting city/taluka.');
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
            
            fetch(`/admin/cities/${id}`, {
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
                    toastr.success('City/Taluka status updated successfully!');
                    // Update status text and color
                    statusText.textContent = status === 'active' ? 'Active' : 'Inactive';
                    statusText.className = status === 'active' ? 'status-text text-success' : 'status-text text-danger';
                } else {
                    toastr.error('Error updating city/taluka status.');
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