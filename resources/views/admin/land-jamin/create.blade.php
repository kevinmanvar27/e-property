@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Land / Jamin</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" aria-label="Dashboard"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('land-jamin.index') }}" aria-label="Land List">Land List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add New Land</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Main Form Card -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Add New Land/Jamin Record</h5>
    </div>
    <div class="card-body">
        <form id="shop-form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="property_type" value="land_jamin">
            
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
            
            <div class="section-card mb-4">
                <div class="section-header bg-light p-3 mb-3 rounded">
                    <h6 class="mb-0">Documents</h6>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="document_7_12" class="form-label">7/12 Document (PDF, JPG, PNG) - Max 100MB</label>
                        <input type="file" class="form-control" id="document_7_12" name="document_7_12" accept=".pdf,.jpg,.jpeg,.png" aria-describedby="document_7_12_size document_7_12_error">
                        <div class="file-size-info text-muted small mt-1" id="document_7_12_size"></div>
                        <div class="invalid-feedback" id="document_7_12_error" role="alert"></div>
                    </div>
                    <div class="col-md-6">
                        <label for="document_8a" class="form-label">8A Document (PDF, JPG, PNG) - Max 100MB</label>
                        <input type="file" class="form-control" id="document_8a" name="document_8a" accept=".pdf,.jpg,.jpeg,.png">
                        <div class="file-size-info text-muted small mt-1" id="document_8a_size"></div>
                        <div class="invalid-feedback" id="document_8a_error"></div>
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
                
                <!-- Type of Land -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label">Type of Land</label>
                        <div class="d-flex flex-wrap" id="land-types-container">
                            @foreach($landTypes as $landType)
                            <div class="form-check me-3 mb-2">
                                <input class="form-check-input" type="checkbox" name="land_types[]" value="{{ $landType->id }}" id="land_type_{{ $landType->id }}">
                                <label class="form-check-label" for="land_type_{{ $landType->id }}">{{ $landType->name }}</label>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" data-bs-toggle="modal" data-bs-target="#addLandTypeModal">Add New Land Type</button>
                    </div>
                </div>
            </div>

            <div class="section-card mb-4">
                <div class="section-header bg-light p-3 mb-3 rounded">
                    <h6 class="mb-0">Issues and Conditions</h6>
                </div>
                
                <!-- Vavetar -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="vavetar" class="form-label">Vavetar</label>
                        <select class="form-select" id="vavetar" name="vavetar">
                            <option value="">Select</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="col-md-6" id="vavetar_name_container" style="display: none;">
                        <label for="electric_poll_count" class="form-label">Vavetar Name</label>
                        <input type="text" class="form-control" id="vavetar" name="vavetar_name" value="{{ $property->vavetar_name ?? '' }}">
                        <div class="invalid-feedback" id="vavetar_name_error"></div>
                    </div>
                </div>

                <!-- Any Issue in Land -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="any_issue" class="form-label">Any Issue in Land</label>
                        <select class="form-select" id="any_issue" name="any_issue">
                            <option value="">Select</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="family_issue" class="form-label">Any Family Issue in Land</label>
                        <select class="form-select" id="family_issue" name="family_issue">
                            <option value="">Select</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                </div>
                
                <!-- Second Row: Descriptions -->
                <div class="row mb-3">
                    <div class="col-md-6" id="issue_description_container" style="visibility:hidden; height:0; overflow:hidden;">
                        <label for="issue_description" class="form-label">Issue Description (Max 500 characters)</label>
                        <textarea class="form-control" id="issue_description" name="issue_description" rows="3" maxlength="500"></textarea>
                        <div class="invalid-feedback" id="issue_description_error"></div>
                    </div>
                    <div class="col-md-6" id="family_issue_description_container" style="visibility:hidden; height:0; overflow:hidden;">
                        <label for="family_issue_description" class="form-label">Family Issue Description (Max 500 characters)</label>
                        <textarea class="form-control" id="family_issue_description" name="family_issue_description" rows="3" maxlength="500"></textarea>
                        <div class="invalid-feedback" id="family_issue_description_error"></div>
                    </div>
                </div>

                <!-- Any Electric Poll in Land -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="electric_poll" class="form-label">Any Electric Poll in Land</label>
                        <select class="form-select" id="electric_poll" name="electric_poll">
                            <option value="">Select</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="col-md-6" id="electric_poll_count_container" style="display: none;">
                        <label for="electric_poll_count" class="form-label">Number of Electric Polls</label>
                        <input type="number" class="form-control" id="electric_poll_count" name="electric_poll_count" min="1">
                        <div class="invalid-feedback" id="electric_poll_count_error"></div>
                    </div>
                </div>
                
                <!-- Any Road Near to Land -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="road_distance" class="form-label">Distance of Road from Land (in feet)</label>
                        <input type="number" class="form-control" id="road_distance" name="road_distance" step="0.01" min="0">
                        <div class="invalid-feedback" id="road_distance_error"></div>
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
                <a href="{{ route('land-jamin.index') }}" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Land/Jamin Record</button>
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

<!-- Add Land Type Modal -->
<div class="modal fade" id="addLandTypeModal" tabindex="-1" aria-labelledby="addLandTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLandTypeModalLabel">Add New Land Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add-land-type-form" aria-label="Add Land Type Form">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="land-type-name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="land-type-name" name="name" required aria-describedby="land-type-name-error">
                        <div class="invalid-feedback" id="land-type-name-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="land-type-description" class="form-label">Description</label>
                        <textarea class="form-control" id="land-type-description" name="description" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Land Type</button>
                </div>
            </form>
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
        fetch("{{ url('admin/land-jamin/states') }}/" + countryId)
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
        fetch("{{ url('admin/land-jamin/districts') }}/" + stateId)
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
        fetch("{{ url('admin/land-jamin/talukas') }}/" + districtId)
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

document.addEventListener('DOMContentLoaded', function() { 
    $('#any_issue').change(function() {
        const c = $('#issue_description_container');
        if ($(this).val() === 'Yes') {
        c.css({ visibility: 'visible', height: 'auto', overflow: 'visible' });
        } else {
        c.css({ visibility: 'hidden', height: '0', overflow: 'hidden' });
        $('#issue_description').val('');
        }
    });

    $('#family_issue').change(function() {
        const c = $('#family_issue_description_container');
        if ($(this).val() === 'Yes') {
        c.css({ visibility: 'visible', height: 'auto', overflow: 'visible' });
        } else {
        c.css({ visibility: 'hidden', height: '0', overflow: 'hidden' });
        $('#family_issue_description').val('');
        }
    });
    
    $('#electric_poll').change(function() {
        if ($(this).val() === 'Yes') {
            $('#electric_poll_count_container').show();
        } else {
            $('#electric_poll_count_container').hide();
            $('#electric_poll_count').val('');
        }
    });
    
    $('#vavetar').change(function() {
        if ($(this).val() === 'Yes') {
            $('#vavetar_name_container').show();
        } else {
            $('#vavetar_name_container').hide();
            $('#vavetar_name_container').val('');
        }
    });
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
    
    const addAmenityUrl = "{{ route('land-jamin.amenities.store') }}";
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

// Handle add land type form submission
document.getElementById('add-land-type-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch("{{ route('land-jamin.land-types.store') }}", {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        // Success - add new land type to the list and select it
        const container = document.getElementById('land-types-container');
        const div = document.createElement('div');
        div.className = 'form-check me-3 mb-2';
        const landTypeId = data.landType.id;
        const landTypeName = data.landType.name;
        div.innerHTML = `
            <input class="form-check-input" type="checkbox" name="land_types[]" value="${landTypeId}" id="land_type_${landTypeId}" checked>
            <label class="form-check-label" for="land_type_${landTypeId}">${landTypeName}</label>
        `;
        container.appendChild(div);
        
        // Close modal and reset form
        const modal = bootstrap.Modal.getInstance(document.getElementById('addLandTypeModal'));
        modal.hide();
        this.reset();
    })
    .catch(error => {
        console.error('Error:', error);
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
                    fetch("{{ url('admin/land-jamin/districts') }}/" + stateId)
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
    
    fetch("{{ route('land-jamin.store') }}", {
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
            window.location.href = "{{ route('land-jamin.index') }}";
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Display a user-friendly error message
        const generalError = document.createElement('div');
        generalError.className = 'alert alert-danger';
        generalError.textContent = 'An error occurred while saving the land/jamin record. Please check that your files are under 100MB and try again.';
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