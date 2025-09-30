@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Shad</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" aria-label="Dashboard"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('shad.index') }}" aria-label="Shad List">Shad List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add New Shad</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Main Form Card -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Add New Shad Record</h5>
    </div>
    <div class="card-body">
        <form id="shad-form" enctype="multipart/form-data" aria-label="Shad Form">
            @csrf
            <input type="hidden" name="property_type" value="shad">
            
            <!-- Section 1: Basic Information -->
            <div class="section-card mb-4">
                <div class="section-header bg-light p-3 mb-3 rounded">
                    <h6 class="mb-0">Basic Information</h6>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="owner_name" class="form-label">Owner Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="owner_name" name="owner_name" required aria-describedby="owner_name_error">
                        <div class="invalid-feedback" id="owner_name_error" role="alert"></div>
                    </div>
                    <div class="col-md-4">
                        <label for="contact_number" class="form-label">Contact Number</label>
                        <input type="text" class="form-control" id="contact_number" name="contact_number" maxlength="15">
                        <div class="invalid-feedback" id="contact_number_error"></div>
                    </div>
                    <div class="col-md-4">
                        <label for="size" class="form-label">Size (Square Meters) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="size" name="size" step="0.01" min="0" required aria-describedby="size_error">
                        <div class="invalid-feedback" id="size_error" role="alert"></div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="active" selected>Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="urgent">Urgent</option>
                            <option value="under_offer">Under Offer</option>
                            <option value="reserved">Reserved</option>
                            <option value="sold">Sold</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="coming_soon">Coming Soon</option>
                            <option value="price_reduced">Price Reduced</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Section 2: Address Information -->
            <div class="section-card mb-4">
                <div class="section-header bg-light p-3 mb-3 rounded">
                    <h6 class="mb-0">Address Information</h6>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="first_line" class="form-label">Address First Line <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="first_line" name="first_line" required>
                        <div class="invalid-feedback" id="first_line_error"></div>
                    </div>
                    <div class="col-md-6">
                        <label for="second_line" class="form-label">Address Second Line</label>
                        <input type="text" class="form-control" id="second_line" name="second_line">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="village" class="form-label">Village <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="village" name="village" required>
                        <div class="invalid-feedback" id="village_error"></div>
                    </div>
                    <div class="col-md-4">
                        <label for="state_id" class="form-label">State <span class="text-danger">*</span></label>
                        <select class="form-select" id="state_id" name="state_id" required data-add-new="true" data-entity-type="state">
                            <option value="">Select State</option>
                            @foreach($states as $stateId => $stateName)
                            <option value="{{ $stateId }}">{{ $stateName }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="state_id_error"></div>
                    </div>
                    <div class="col-md-4">
                        <label for="district_id" class="form-label">District <span class="text-danger">*</span></label>
                        <select class="form-select" id="district_id" name="district_id" required data-add-new="true" data-entity-type="district">
                            <option value="">Select District</option>
                        </select>
                        <div class="invalid-feedback" id="district_id_error"></div>
                    </div>
                    <div class="col-md-4">
                        <label for="taluka_id" class="form-label">Taluka</label>
                        <select class="form-select" id="taluka_id" name="taluka_id" data-add-new="true" data-entity-type="city">
                            <option value="">Select Taluka</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="pincode" class="form-label">Pincode <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="pincode" name="pincode" required maxlength="6">
                        <div class="invalid-feedback" id="pincode_error"></div>
                    </div>
                    <div class="col-md-4">
                        <label for="country_id" class="form-label">Country <span class="text-danger">*</span></label>
                        <select class="form-select" id="country_id" name="country_id" required>
                            <option value="">Select Country</option>
                            @foreach($countries as $countryId => $countryName)
                            <option value="{{ $countryId }}" {{ $countryName == 'India' ? 'selected' : '' }}>{{ $countryName }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="country_id_error"></div>
                    </div>
                </div>
            </div>
            
            <!-- Section 3: Photographs -->
            <div class="section-card mb-4">
                <div class="section-header bg-light p-3 mb-3 rounded">
                    <h6 class="mb-0">Shad Images</h6>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="photos" class="form-label">Shad Images (Multiple uploads supported)</label>
                        <input type="file" class="form-control" id="photos" name="photos[]" multiple accept=".jpg,.jpeg,.png" aria-describedby="photos_error">
                        <div class="file-size-info text-muted small mt-1" id="photos_size"></div>
                        <div class="invalid-feedback" id="photos_error" role="alert"></div>
                        
                        <!-- Preview area for selected photos with repositioning -->
                        <div class="row mt-3" id="photo-preview" style="display: none;" aria-live="polite">
                            <div class="col-12">
                                <h6>Newly Selected Photos:</h6>
                                <div class="row" id="preview-container"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Section 4: Property Details -->
            <div class="section-card mb-4">
                <div class="section-header bg-light p-3 mb-3 rounded">
                    <h6 class="mb-0">Property Details</h6>
                </div>
                
                <!-- Amenities -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label">Amenities</label>
                        <div class="d-flex flex-wrap" id="amenities-container">
                            @foreach($amenities as $amenity)
                            <div class="form-check me-3 mb-2">
                                <input class="form-check-input" type="checkbox" name="amenities[]" value="{{ $amenity->id }}" id="amenity_{{ $amenity->id }}">
                                <label class="form-check-label" for="amenity_{{ $amenity->id }}">{{ $amenity->name }}</label>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" data-bs-toggle="modal" data-bs-target="#addAmenityModal">Add New Amenity</button>
                    </div>
                </div>
            </div>
            
            <!-- Section 5: Additional Information -->
            <div class="section-card mb-4">
                <div class="section-header bg-light p-3 mb-3 rounded">
                    <h6 class="mb-0">Additional Information</h6>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="additional_notes" class="form-label">Additional Notes</label>
                        <textarea class="form-control" id="additional_notes" name="additional_notes" rows="3"></textarea>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end">
                <a href="{{ route('shad.index') }}" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Shad Record</button>
            </div>
        </form>
    </div>
</div>

<!-- Add Amenity Modal -->
<div class="modal fade" id="addAmenityModal" tabindex="-1" aria-labelledby="addAmenityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAmenityModalLabel">Add New Amenity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add-amenity-form" aria-label="Add Amenity Form">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="amenity-name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="amenity-name" name="name" required aria-describedby="amenity-name-error">
                        <div class="invalid-feedback" id="amenity-name-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="amenity-description" class="form-label">Description</label>
                        <textarea class="form-control" id="amenity-description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Amenity</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Include the add new modal -->
@include('admin.layouts.add-new-modal')

@endsection

@section('styles')
<style>
.photo-item {
    position: relative;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-bottom: 15px;
    background: #f8f9fa;
    transition: all 0.3s ease;
    max-width: 200px;
    margin-left: auto;
    margin-right: auto;
    display: flex;
    flex-direction: column;
    height: 220px; /* Fixed height for consistent sizing */
}

.photo-item:hover {
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.photo-item img {
    width: 100%;
    max-width: 200px;
    height: 150px; /* Fixed height */
    object-fit: cover; /* Maintain aspect ratio while covering the area */
    border-radius: 5px 5px 0 0;
    cursor: pointer;
}

.photo-item .photo-info {
    padding: 10px;
    font-size: 0.85rem;
    text-align: center;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    flex-grow: 1;
    display: flex;
    align-items: center;
    justify-content: center;
}

.photo-item .photo-actions {
    display: flex;
    justify-content: space-between;
    padding: 10px;
    border-top: 1px solid #eee;
}

.photo-item .btn-move {
    cursor: move;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 3px;
    padding: 3px 8px;
    font-size: 0.8rem;
}

.photo-item .btn-view {
    background: #28a745;
    color: white;
    border: none;
    border-radius: 3px;
    padding: 3px 8px;
    font-size: 0.8rem;
}

.photo-item .btn-delete {
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 3px;
    padding: 3px 8px;
    font-size: 0.8rem;
}

.draggable {
    cursor: move;
}

.drag-over {
    border: 2px dashed #007bff;
    background-color: #e3f2fd;
}

/* Additional styles for consistent photo display */
#preview-container .col-md-3 {
    display: flex;
    justify-content: center;
}

/* Ensure consistent sizing for photo previews */
#preview-container img {
    width: 100%;
    max-width: 200px;
    height: 150px;
    object-fit: cover;
}
</style>
@endsection

@section('scripts')
<script>
// Handle country change to load states
document.getElementById('country_id').addEventListener('change', function() {
    const countryId = this.value;
    const stateSelect = document.getElementById('state_id');
    const districtSelect = document.getElementById('district_id');
    const talukaSelect = document.getElementById('taluka_id');
    
    // Clear existing options but keep the placeholder
    stateSelect.innerHTML = '<option value="">Select State</option>';
    districtSelect.innerHTML = '<option value="">Select District</option>';
    talukaSelect.innerHTML = '<option value="">Select Taluka</option>';
    
    if (countryId) {
        fetch("{{ url('admin/shad/states') }}/" + countryId)
            .then(response => response.json())
            .then(data => {
                data.forEach(state => {
                    const option = document.createElement('option');
                    option.value = state.state_id;
                    option.textContent = state.state_title;
                    stateSelect.appendChild(option);
                });
                // Add "Add New" option
                const addNewOption = document.createElement('option');
                addNewOption.value = 'add_new';
                addNewOption.textContent = '+ Add New State';
                addNewOption.setAttribute('data-entity', 'state');
                stateSelect.appendChild(addNewOption);
            })
            .catch(error => {
                console.error('Error loading states:', error);
            });
    }
});

// Load states for default selected country (India) on page load
document.addEventListener('DOMContentLoaded', function() {
    const countrySelect = document.getElementById('country_id');
    const selectedCountryId = countrySelect.value;
    
    if (selectedCountryId) {
        // Trigger the change event to load states
        const event = new Event('change');
        countrySelect.dispatchEvent(event);
    }
});

// Handle cascading dropdowns
document.getElementById('state_id').addEventListener('change', function() {
    const stateId = this.value;
    const districtSelect = document.getElementById('district_id');
    const talukaSelect = document.getElementById('taluka_id');
    
    // Clear existing options but keep the placeholder
    districtSelect.innerHTML = '<option value="">Select District</option>';
    talukaSelect.innerHTML = '<option value="">Select Taluka</option>';
    
    if (stateId && stateId !== 'add_new') {
        fetch("{{ url('admin/shad/districts') }}/" + stateId)
            .then(response => response.json())
            .then(data => {
                data.forEach(district => {
                    const option = document.createElement('option');
                    option.value = district.districtid;
                    option.textContent = district.district_title;
                    districtSelect.appendChild(option);
                });
                // Add "Add New" option
                const addNewOption = document.createElement('option');
                addNewOption.value = 'add_new';
                addNewOption.textContent = '+ Add New District';
                addNewOption.setAttribute('data-entity', 'district');
                districtSelect.appendChild(addNewOption);
            })
            .catch(error => {
                console.error('Error loading districts:', error);
            });
    } else if (stateId === 'add_new') {
        // Open add new modal
        openAddNewModal('state', 'state_id');
        // Reset to placeholder
        this.value = '';
    }
});

document.getElementById('district_id').addEventListener('change', function() {
    const districtId = this.value;
    const talukaSelect = document.getElementById('taluka_id');
    
    // Clear existing options but keep the placeholder
    talukaSelect.innerHTML = '<option value="">Select Taluka</option>';
    
    if (districtId && districtId !== 'add_new') {
        fetch("{{ url('admin/shad/talukas') }}/" + districtId)
            .then(response => response.json())
            .then(data => {
                data.forEach(taluka => {
                    const option = document.createElement('option');
                    option.value = taluka.id;
                    option.textContent = taluka.name;
                    talukaSelect.appendChild(option);
                });
                // Add "Add New" option
                const addNewOption = document.createElement('option');
                addNewOption.value = 'add_new';
                addNewOption.textContent = '+ Add New Taluka';
                addNewOption.setAttribute('data-entity', 'city');
                talukaSelect.appendChild(addNewOption);
            })
            .catch(error => {
                console.error('Error loading talukas:', error);
            });
    } else if (districtId === 'add_new') {
        // Open add new modal
        openAddNewModal('district', 'district_id');
        // Reset to placeholder
        this.value = '';
    }
});

// Add event listener for taluka dropdown
document.getElementById('taluka_id').addEventListener('change', function() {
    const talukaId = this.value;
    
    if (talukaId === 'add_new') {
        // Open add new modal for city (taluka)
        openAddNewModal('city', 'taluka_id');
        // Reset to placeholder
        this.value = '';
    }
});

// Function to open the Add New modal
function openAddNewModal(entityType, dropdownId) {
    const modal = new bootstrap.Modal(document.getElementById('addNewModal'));
    const modalTitle = document.getElementById('addNewModalLabel');
    const entityTypeInput = document.getElementById('add-new-entity-type');
    const dropdownIdInput = document.getElementById('add-new-dropdown-id');
    const nameInput = document.getElementById('add-new-name');
    const descriptionInput = document.getElementById('add-new-description');
    const additionalFields = document.getElementById('add-new-additional-fields');
    
    // Reset form
    document.getElementById('add-new-form').reset();
    document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    
    // Set modal title and inputs
    modalTitle.textContent = 'Add New ' + entityType.charAt(0).toUpperCase() + entityType.slice(1);
    entityTypeInput.value = entityType;
    dropdownIdInput.value = dropdownId;
    nameInput.value = '';
    descriptionInput.value = '';
    additionalFields.innerHTML = '';
    
    // Add additional fields based on entity type
    switch (entityType) {
        case 'state':
            additionalFields.innerHTML = `
                <div class="mb-3">
                    <label for="add-new-country-id" class="form-label">Country <span class="text-danger">*</span></label>
                    <select class="form-select" id="add-new-country-id" name="country_id" required>
                        <option value="">Select Country</option>
                        @foreach($countries as $countryId => $countryName)
                        <option value="{{ $countryId }}">{{ $countryName }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="add-new-country-id-error"></div>
                </div>
            `;
            
            // Pre-select current country if available
            const countrySelect = document.getElementById('country_id');
            if (countrySelect && countrySelect.value) {
                document.getElementById('add-new-country-id').value = countrySelect.value;
            }
            break;
            
        case 'district':
            additionalFields.innerHTML = `
                <div class="mb-3">
                    <label for="add-new-state-id" class="form-label">State <span class="text-danger">*</span></label>
                    <select class="form-select" id="add-new-state-id" name="state_id" required>
                        <option value="">Select State</option>
                    </select>
                    <div class="invalid-feedback" id="add-new-state-id-error"></div>
                </div>
            `;
            
            // Populate and pre-select state
            const stateSelect = document.getElementById('state_id');
            const newStateSelect = document.getElementById('add-new-state-id');
            newStateSelect.innerHTML = stateSelect.innerHTML;
            
            // Remove the "Add New" option
            Array.from(newStateSelect.options).forEach(option => {
                if (option.value === 'add_new') {
                    newStateSelect.remove(option.index);
                }
            });
            
            if (stateSelect && stateSelect.value && stateSelect.value !== 'add_new') {
                newStateSelect.value = stateSelect.value;
            }
            break;
            
        case 'city':
            additionalFields.innerHTML = `
                <div class="mb-3">
                    <label for="add-new-district-id" class="form-label">District <span class="text-danger">*</span></label>
                    <select class="form-select" id="add-new-district-id" name="districtid" required>
                        <option value="">Select District</option>
                    </select>
                    <div class="invalid-feedback" id="add-new-district-id-error"></div>
                </div>
                <div class="mb-3">
                    <label for="add-new-city-state-id" class="form-label">State <span class="text-danger">*</span></label>
                    <select class="form-select" id="add-new-city-state-id" name="state_id" required>
                        <option value="">Select State</option>
                    </select>
                    <div class="invalid-feedback" id="add-new-city-state-id-error"></div>
                </div>
            `;
            
            // Populate states
            const stateSelectForCity = document.getElementById('state_id');
            const districtSelect = document.getElementById('district_id');
            const newDistrictSelect = document.getElementById('add-new-district-id');
            const newCityStateSelect = document.getElementById('add-new-city-state-id');
            
            // Copy options from existing state select
            newCityStateSelect.innerHTML = stateSelectForCity.innerHTML;
            
            // Remove the "Add New" option
            Array.from(newCityStateSelect.options).forEach(option => {
                if (option.value === 'add_new') {
                    newCityStateSelect.remove(option.index);
                }
            });
            
            // Set state selection handler
            newCityStateSelect.addEventListener('change', function() {
                const stateId = this.value;
                if (stateId) {
                    fetch("{{ url('admin/shad/districts') }}/" + stateId)
                        .then(response => response.json())
                        .then(data => {
                            newDistrictSelect.innerHTML = '<option value="">Select District</option>';
                            data.forEach(district => {
                                const option = document.createElement('option');
                                option.value = district.districtid;
                                option.textContent = district.district_title;
                                newDistrictSelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Error loading districts:', error);
                        });
                } else {
                    newDistrictSelect.innerHTML = '<option value="">Select District</option>';
                }
            });
            
            // Pre-select current state and load districts
            if (stateSelectForCity.value && stateSelectForCity.value !== 'add_new') {
                newCityStateSelect.value = stateSelectForCity.value;
                // Trigger change event to load districts
                const event = new Event('change');
                newCityStateSelect.dispatchEvent(event);
                
                // Pre-select current district after a short delay to allow districts to load
                setTimeout(() => {
                    if (districtSelect.value && districtSelect.value !== 'add_new') {
                        newDistrictSelect.value = districtSelect.value;
                    }
                }, 500); // Increased delay to ensure districts are loaded
            }
            break;
    }
    
    modal.show();
}

// Handle add new form submission
document.getElementById('add-new-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const entityType = document.getElementById('add-new-entity-type').value;
    const dropdownId = document.getElementById('add-new-dropdown-id').value;
    
    // Show loading state
    const submitButton = this.querySelector('button[type="submit"]');
    const originalText = submitButton.textContent;
    submitButton.disabled = true;
    submitButton.textContent = 'Adding...';
    
    // Clear previous errors
    document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    
    fetch("{{ route('admin.locations.entities.store') }}", {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.errors) {
            // Handle validation errors
            Object.keys(data.errors).forEach(field => {
                const errorElement = document.getElementById('add-new-' + field + '-error');
                if (errorElement) {
                    errorElement.textContent = data.errors[field][0];
                    document.getElementById('add-new-' + field).classList.add('is-invalid');
                }
            });
        } else if (data.success) {
            // Success - add new entity to the dropdown and select it
            const dropdown = document.getElementById(dropdownId);
            const option = document.createElement('option');
            let entityId, entityName;
            
            switch (entityType) {
                case 'state':
                    entityId = data.entity.state_id;
                    entityName = data.entity.state_title;
                    break;
                case 'district':
                    entityId = data.entity.districtid;
                    entityName = data.entity.district_title;
                    break;
                case 'city':
                    entityId = data.entity.id;
                    entityName = data.entity.name;
                    break;
            }
            
            option.value = entityId;
            option.textContent = entityName;
            option.selected = true;
            
            // Add the option to the dropdown
            dropdown.appendChild(option);
            
            // Add "Add New" option back
            const addNewOption = document.createElement('option');
            addNewOption.value = 'add_new';
            addNewOption.textContent = '+ Add New ' + entityType.charAt(0).toUpperCase() + entityType.slice(1);
            addNewOption.setAttribute('data-entity', entityType);
            dropdown.appendChild(addNewOption);
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('addNewModal'));
            modal.hide();
            
            // Trigger change event for cascading dropdowns if needed
            if (entityType === 'state') {
                const event = new Event('change');
                dropdown.dispatchEvent(event);
            } else if (entityType === 'district') {
                const event = new Event('change');
                dropdown.dispatchEvent(event);
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
    })
    .finally(() => {
        // Reset loading state
        submitButton.disabled = false;
        submitButton.textContent = originalText;
    });
});

// Handle pincode validation
document.getElementById('pincode').addEventListener('input', function() {
    // Remove any non-digit characters
    this.value = this.value.replace(/\D/g, '');
    
    // Limit to 6 digits
    if (this.value.length > 6) {
        this.value = this.value.slice(0, 6);
    }
});

// Handle photo selection preview with repositioning
let selectedPhotos = [];
let draggedItem = null;

document.getElementById('photos').addEventListener('change', function() {
    const files = Array.from(this.files);
    if (files.length > 0) {
        // Add new files to the existing array
        files.forEach(file => {
            if (file.type.startsWith('image/')) {
                selectedPhotos.push({
                    file: file,
                    name: file.name,
                    url: URL.createObjectURL(file)
                });
            }
        });
        
        // Display the photos
        displaySelectedPhotos();
    }
});

function displaySelectedPhotos() {
    const previewContainer = document.getElementById('preview-container');
    const photoPreview = document.getElementById('photo-preview');
    
    if (selectedPhotos.length > 0) {
        photoPreview.style.display = 'block';
        previewContainer.innerHTML = '';
        
        selectedPhotos.forEach((photo, index) => {
            const col = document.createElement('div');
            col.className = 'col-md-3 mb-3 photo-item draggable';
            col.setAttribute('data-index', index);
            col.setAttribute('draggable', 'true');
            
            col.innerHTML = `
                <img src="${photo.url}" alt="Preview" onclick="viewImage(${index})">
                <div class="photo-info">
                    <small class="text-muted">${photo.name.substring(0, 20)}${photo.name.length > 20 ? '...' : ''}</small>
                </div>
                <div class="photo-actions">
                    <button type="button" class="btn-move" title="Drag to reposition"><i class='bx bx-move'></i></button>
                    <button type="button" class="btn-view" onclick="viewImage(${index})" title="View"><i class='bx bx-show'></i></button>
                    <button type="button" class="btn-delete" onclick="deletePhoto(${index})" title="Delete"><i class='bx bx-trash'></i></button>
                </div>
            `;
            
            // Add drag events
            col.addEventListener('dragstart', handleDragStart);
            col.addEventListener('dragover', handleDragOver);
            col.addEventListener('dragenter', handleDragEnter);
            col.addEventListener('dragleave', handleDragLeave);
            col.addEventListener('drop', handleDrop);
            col.addEventListener('dragend', handleDragEnd);
            
            previewContainer.appendChild(col);
        });
    } else {
        photoPreview.style.display = 'none';
    }
}

function handleDragStart(e) {
    draggedItem = this;
    setTimeout(() => {
        this.style.opacity = '0.5';
    }, 0);
}

function handleDragOver(e) {
    e.preventDefault();
}

function handleDragEnter(e) {
    e.preventDefault();
    this.classList.add('drag-over');
}

function handleDragLeave() {
    this.classList.remove('drag-over');
}

function handleDrop(e) {
    e.preventDefault();
    this.classList.remove('drag-over');
    
    if (draggedItem !== this) {
        const draggedIndex = parseInt(draggedItem.getAttribute('data-index'));
        const targetIndex = parseInt(this.getAttribute('data-index'));
        
        // Remove the dragged item from its original position
        const draggedItemData = selectedPhotos.splice(draggedIndex, 1)[0];
        
        // Insert the dragged item at the new position
        selectedPhotos.splice(targetIndex, 0, draggedItemData);
        
        // Update data-index attributes
        selectedPhotos.forEach((photo, index) => {
            photo.index = index;
        });
        
        // Redisplay the photos
        displaySelectedPhotos();
    }
}

function handleDragEnd() {
    this.style.opacity = '1';
    document.querySelectorAll('.photo-item').forEach(item => {
        item.classList.remove('drag-over');
    });
    draggedItem = null;
}

function viewImage(index) {
    const photo = selectedPhotos[index];
    const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
    const previewImage = document.getElementById('previewImage');
    const downloadLink = document.getElementById('downloadImage');
    
    previewImage.src = photo.url;
    previewImage.alt = photo.name;
    downloadLink.href = photo.url;
    downloadLink.download = photo.name;
    
    document.getElementById('imagePreviewModalLabel').textContent = photo.name;
    modal.show();
}

function deletePhoto(index) {
    if (confirm('Are you sure you want to delete this photo?')) {
        // Remove the photo from the array
        selectedPhotos.splice(index, 1);
        
        // Update indices
        selectedPhotos.forEach((photo, i) => {
            photo.index = i;
        });
        
        // Redisplay the photos
        displaySelectedPhotos();
    }
}

// Handle form submission
document.getElementById('shad-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Show loading state
    const submitButton = this.querySelector('button[type="submit"]');
    const originalText = submitButton.textContent;
    submitButton.disabled = true;
    submitButton.textContent = 'Saving...';
    
    // Clear previous errors
    document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    
    // Create FormData object
    const formData = new FormData(this);
    
    // Add selected photos to form data
    selectedPhotos.forEach((photo, index) => {
        formData.append('photos[]', photo.file);
    });
    
    fetch("{{ route('shad.store') }}", {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.errors) {
            // Handle validation errors
            Object.keys(data.errors).forEach(field => {
                const errorElement = document.getElementById(field + '_error');
                if (errorElement) {
                    errorElement.textContent = data.errors[field][0];
                    document.getElementById(field).classList.add('is-invalid');
                }
            });
            
            // Show a general error message if needed
            if (data.errors.general) {
                alert(data.errors.general[0]);
            }
        } else if (data.success) {
            // Success - redirect to index page
            window.location.href = "{{ route('shad.index') }}";
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while saving the shad record. Please try again.');
    })
    .finally(() => {
        // Reset loading state
        submitButton.disabled = false;
        submitButton.textContent = originalText;
    });
});

// Handle add amenity form submission
document.getElementById('add-amenity-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Show loading state
    const submitButton = this.querySelector('button[type="submit"]');
    const originalText = submitButton.textContent;
    submitButton.disabled = true;
    submitButton.textContent = 'Adding...';
    
    // Clear previous errors
    document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    
    const formData = new FormData(this);
    
    fetch("{{ route('shad.amenities.store') }}", {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.errors) {
            // Handle validation errors
            Object.keys(data.errors).forEach(field => {
                const errorElement = document.getElementById('amenity-' + field + '-error');
                if (errorElement) {
                    errorElement.textContent = data.errors[field][0];
                    document.getElementById('amenity-' + field).classList.add('is-invalid');
                }
            });
        } else if (data.success) {
            // Success - add new amenity to the list
            const amenityContainer = document.getElementById('amenities-container');
            const div = document.createElement('div');
            div.className = 'form-check me-3 mb-2';
            div.innerHTML = `
                <input class="form-check-input" type="checkbox" name="amenities[]" value="${data.amenity.id}" id="amenity_${data.amenity.id}" checked>
                <label class="form-check-label" for="amenity_${data.amenity.id}">${data.amenity.name}</label>
            `;
            amenityContainer.appendChild(div);
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('addAmenityModal'));
            modal.hide();
            
            // Reset form
            document.getElementById('add-amenity-form').reset();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while adding the amenity. Please try again.');
    })
    .finally(() => {
        // Reset loading state
        submitButton.disabled = false;
        submitButton.textContent = originalText;
    });
});
</script>
@endsection