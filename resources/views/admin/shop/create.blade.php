@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Shop</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('shop.index') }}">Shop List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add New Shop</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Main Form Card -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Add New Shop Record</h5>
    </div>
    <div class="card-body">
        <form id="shop-form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="property_type" value="shop">
            
            <!-- Section 1: Basic Information -->
            <div class="section-card mb-4">
                <div class="section-header bg-light p-3 mb-3 rounded">
                    <h6 class="mb-0">Basic Information</h6>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="owner_name" class="form-label">Owner Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="owner_name" name="owner_name" required>
                        <div class="invalid-feedback" id="owner_name_error"></div>
                    </div>
                    <div class="col-md-4">
                        <label for="contact_number" class="form-label">Contact Number</label>
                        <input type="text" class="form-control" id="contact_number" name="contact_number" maxlength="15">
                        <div class="invalid-feedback" id="contact_number_error"></div>
                    </div>
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
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="apartment_name" class="form-label">Apartment Name</label>
                        <input type="text" class="form-control" id="apartment_name" name="apartment_name">
                    </div>
                    <div class="col-md-4">
                        <label for="size" class="form-label">Size (in sq ft)</label>
                        <input type="number" class="form-control" id="size" name="size" min="0">
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
                        <select class="form-select" id="state_id" name="state_id" required>
                            <option value="">Select State</option>
                            @foreach($states as $stateId => $stateName)
                            <option value="{{ $stateId }}">{{ $stateName }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="state_id_error"></div>
                    </div>
                    <div class="col-md-4">
                        <label for="district_id" class="form-label">District <span class="text-danger">*</span></label>
                        <select class="form-select" id="district_id" name="district_id" required>
                            <option value="">Select District</option>
                        </select>
                        <div class="invalid-feedback" id="district_id_error"></div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="taluka_id" class="form-label">Taluka</label>
                        <select class="form-select" id="taluka_id" name="taluka_id">
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
                    <h6 class="mb-0">Photographs</h6>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="photos" class="form-label">Photographs (Multiple uploads supported)</label>
                        <input type="file" class="form-control" id="photos" name="photos[]" multiple accept=".jpg,.jpeg,.png">
                        <div class="file-size-info text-muted small mt-1" id="photos_size"></div>
                        <div class="invalid-feedback" id="photos_error"></div>
                        
                        <!-- Preview area for selected photos with repositioning -->
                        <div class="row mt-3" id="photo-preview" style="display: none;">
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
                <a href="{{ route('shop.index') }}" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Shop Record</button>
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
            <div class="modal-body">
                <form id="add-amenity-form">
                    @csrf
                    <div class="mb-3">
                        <label for="amenity_name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="amenity_name" name="name" required>
                        <div class="invalid-feedback" id="amenity_name_error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="amenity_description" class="form-label">Description</label>
                        <textarea class="form-control" id="amenity_description" name="description" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Amenity</button>
                </form>
            </div>
        </div>
    </div>
</div>
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
}

.photo-item:hover {
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.photo-item img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 5px 5px 0 0;
    cursor: pointer;
}

.photo-item .photo-info {
    padding: 10px;
    font-size: 0.85rem;
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
        fetch("{{ url('admin/shop/states') }}/" + countryId)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                // Check if data is an array
                if (Array.isArray(data)) {
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
                } else {
                    console.error('Expected array but received:', data);
                }
            })
            .catch(error => {
                console.error('Error loading states:', error);
            });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const stateSelect = document.getElementById('state_id');

    // Append "+ Add New State" option if not exists
    if (!stateSelect.querySelector('option[value="add_new"]')) {
        const addNewOption = document.createElement('option');
        addNewOption.value = 'add_new';
        addNewOption.textContent = '+ Add New State';
        addNewOption.setAttribute('data-entity', 'state');
        stateSelect.appendChild(addNewOption);
    }

    // Open modal if "Add New" is selected
    stateSelect.addEventListener('change', function() {
        if (this.value === 'add_new') {
            openAddNewModal('state', 'state_id');
            this.value = '';
        }
    });
});

// Handle state change to load districts
document.getElementById('state_id').addEventListener('change', function() {
    const stateId = this.value;
    const districtSelect = document.getElementById('district_id');
    const talukaSelect = document.getElementById('taluka_id');
    
    // Clear existing options but keep the placeholder
    districtSelect.innerHTML = '<option value="">Select District</option>';
    talukaSelect.innerHTML = '<option value="">Select Taluka</option>';
    
    if (stateId && stateId !== 'add_new') {
        fetch("{{ url('admin/shop/districts') }}/" + stateId)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                // Check if data is an array
                if (Array.isArray(data)) {
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
                } else {
                    console.error('Expected array but received:', data);
                }
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

// Handle district change to load talukas
document.getElementById('district_id').addEventListener('change', function() {
    const districtId = this.value;
    const talukaSelect = document.getElementById('taluka_id');
    
    // Clear existing options but keep the placeholder
    talukaSelect.innerHTML = '<option value="">Select Taluka</option>';
    
    if (districtId && districtId !== 'add_new') {
        fetch("{{ url('admin/shop/talukas') }}/" + districtId)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                // Check if data is an array
                if (Array.isArray(data)) {
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
                } else {
                    console.error('Expected array but received:', data);
                }
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
    
    const addAmenityUrl = "{{ route('house.amenities.store') }}";
    fetch(addAmenityUrl, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        credentials: 'same-origin' // <--- important!
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        const amenityContainer = document.getElementById('amenities-container');
        const div = document.createElement('div');
        div.className = 'form-check me-3 mb-2';
        div.innerHTML = `
            <input class="form-check-input" type="checkbox" name="amenities[]" value="${data.amenity.id}" id="amenity_${data.amenity.id}" checked>
            <label class="form-check-label" for="amenity_${data.amenity.id}">${data.amenity.name}</label>
        `;
        amenityContainer.appendChild(div);

        // Close modal reliably
        const modalEl = document.getElementById('addAmenityModal');
        const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
        modal.hide();

        // Reset form
        document.getElementById('add-amenity-form').reset();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while adding the amenity. Please try again.');
    })
    .finally(() => {
        submitButton.disabled = false;
        submitButton.textContent = originalText;
    });

});
// Handle district dropdown change in taluka modal
document.addEventListener('DOMContentLoaded', function() {
    const talukaStateSelect = document.getElementById('taluka_state_id');
    if (talukaStateSelect) {
        talukaStateSelect.addEventListener('change', function() {
            const stateId = this.value;
            const districtSelect = document.getElementById('taluka_district_id');
            
            // Clear existing options
            if (districtSelect) {
                districtSelect.innerHTML = '<option value="">Select District</option>';
                
                if (stateId) {
                    fetch("{{ url('admin/shop/districts') }}/" + stateId)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(district => {
                                const option = document.createElement('option');
                                option.value = district.districtid;
                                option.textContent = district.district_title;
                                districtSelect.appendChild(option);
                            });
                        });
                }
            }
        });
    }
});

// Handle photos file selection
document.getElementById('photos').addEventListener('change', function() {
    const files = this.files;
    const sizeElement = document.getElementById('photos_size');
    if (files.length > 0) {
        let totalSize = 0;
        for (let i = 0; i < files.length; i++) {
            totalSize += files[i].size;
        }
        const fileSize = formatFileSize(totalSize);
        sizeElement.textContent = `${files.length} file(s) selected, Total size: ${fileSize}`;
    } else {
        sizeElement.textContent = '';
    }
});

// Format file size for display
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Handle form submission
document.getElementById('shop-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Validate pincode
    const pincode = document.getElementById('pincode').value;
    if (pincode.length !== 6 || isNaN(pincode)) {
        document.getElementById('pincode_error').textContent = 'Pincode must be exactly 6 digits';
        document.getElementById('pincode').classList.add('is-invalid');
        document.getElementById('pincode').scrollIntoView({ behavior: 'smooth', block: 'center' });
        return;
    }
    
    const formData = new FormData(this);
    const submitButton = this.querySelector('button[type="submit"]');
    const originalText = submitButton.textContent;
    
    // Show loading state
    submitButton.disabled = true;
    submitButton.textContent = 'Saving...';
    
    // Clear previous errors
    document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    
    fetch("{{ route('shop.store') }}", {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        // Handle non-JSON responses (like 413 errors)
        const contentType = response.headers.get("content-type");
        if (!contentType || !contentType.includes("application/json")) {
            throw new Error('Server error: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        if (data.errors) {
            // Handle validation errors
            let firstErrorFound = false;
            Object.keys(data.errors).forEach(field => {
                // Handle general errors
                if (field === 'general') {
                    // Display general error at the top of the form
                    const generalError = document.createElement('div');
                    generalError.className = 'alert alert-danger';
                    generalError.textContent = data.errors[field][0];
                    generalError.style.marginBottom = '20px';
                    
                    // Insert at the top of the form
                    const form = document.getElementById('shop-form');
                    if (form.firstChild) {
                        form.insertBefore(generalError, form.firstChild);
                    } else {
                        form.appendChild(generalError);
                    }
                    
                    // Scroll to the error
                    if (!firstErrorFound) {
                        generalError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstErrorFound = true;
                    }
                    return;
                }
                
                const errorElement = document.getElementById(field + '_error');
                if (errorElement) {
                    errorElement.textContent = data.errors[field][0];
                    document.getElementById(field).classList.add('is-invalid');
                    
                    // Scroll to the first error
                    if (!firstErrorFound) {
                        document.getElementById(field).scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstErrorFound = true;
                    }
                }
            });
        } else if (data.success) {
            // Success - redirect to index page
            window.location.href = "{{ route('shop.index') }}";
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Display a user-friendly error message
        const generalError = document.createElement('div');
        generalError.className = 'alert alert-danger';
        generalError.textContent = 'An error occurred while saving the shop record. Please check that your files are under 100MB and try again.';
        generalError.style.marginBottom = '20px';
        
        // Insert at the top of the form
        const form = document.getElementById('shop-form');
        if (form.firstChild) {
            form.insertBefore(generalError, form.firstChild);
        } else {
            form.appendChild(generalError);
        }
        
        // Scroll to the error
        generalError.scrollIntoView({ behavior: 'smooth', block: 'center' });
    })
    .finally(() => {
        // Reset loading state
        submitButton.disabled = false;
        submitButton.textContent = originalText;
    });
});

</script>
@endsection