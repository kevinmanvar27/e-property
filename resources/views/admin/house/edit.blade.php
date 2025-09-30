@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">House</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('house.index') }}">House List</a></li>
                <li class="breadcrumb-item"><a href="{{ route('house.show', $property->id) }}">House Details</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit House</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Main Form Card -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit House Record</h5>
    </div>
    <div class="card-body">
        <form id="shop-form" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="property_type" value="house">
            
            <!-- Section 1: Basic Information -->
            <div class="section-card mb-4">
                <div class="section-header bg-light p-3 mb-3 rounded">
                    <h6 class="mb-0">Basic Information</h6>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="owner_name" class="form-label">Owner Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="owner_name" name="owner_name" value="{{ old('owner_name', $property->owner_name) }}" required>
                        <div class="invalid-feedback" id="owner_name_error"></div>
                    </div>
                    <div class="col-md-4">
                        <label for="contact_number" class="form-label">Contact Number</label>
                        <input type="text" class="form-control" id="contact_number" name="contact_number" value="{{ old('contact_number', $property->contact_number) }}" maxlength="15">
                        <div class="invalid-feedback" id="contact_number_error"></div>
                    </div>
                    <div class="col-md-4">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="active" {{ old('status', $property->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $property->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="urgent" {{ old('status', $property->status) == 'urgent' ? 'selected' : '' }}>Urgent</option>
                            <option value="under_offer" {{ old('status', $property->status) == 'under_offer' ? 'selected' : '' }}>Under Offer</option>
                            <option value="reserved" {{ old('status', $property->status) == 'reserved' ? 'selected' : '' }}>Reserved</option>
                            <option value="sold" {{ old('status', $property->status) == 'sold' ? 'selected' : '' }}>Sold</option>
                            <option value="cancelled" {{ old('status', $property->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="coming_soon" {{ old('status', $property->status) == 'coming_soon' ? 'selected' : '' }}>Coming Soon</option>
                            <option value="price_reduced" {{ old('status', $property->status) == 'price_reduced' ? 'selected' : '' }}>Price Reduced</option>
                        </select>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="apartment_name" class="form-label">Apartment Name</label>
                        <input type="text" class="form-control" id="apartment_name" name="apartment_name" value="{{ old('apartment_name', $property->apartment_name) }}">
                    </div>
                    <div class="col-md-4">
                        <label for="size" class="form-label">Size (in sq ft)</label>
                        <input type="number" class="form-control" id="size" name="size" value="{{ old('size', $property->size) }}" min="0">
                    </div>
                    <div class="col-md-4">
                        <label for="bhk" class="form-label">BHK</label>
                        <input type="number" class="form-control" id="bhk" name="bhk" value="{{ old('bhk', $property->bhk ?? '') }}" min="0">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="property_type_selection" class="form-label">Property Type</label>
                        <select class="form-select" id="property_type_selection" name="property_type_selection">
                            <option value="">Select Property Type</option>
                            <option value="apartment" {{ old('is_apartment', $property->is_apartment ?? 'no') == 'yes' ? 'selected' : '' }}>Apartment</option>
                            <option value="tenament" {{ old('is_tenament', $property->is_tenament ?? 'no') == 'yes' ? 'selected' : '' }}>Tenament</option>
                        </select>
                        <input type="hidden" id="is_apartment" name="is_apartment" value="{{ old('is_apartment', $property->is_apartment ?? 'no') }}">
                        <input type="hidden" id="is_tenament" name="is_tenament" value="{{ old('is_tenament', $property->is_tenament ?? 'no') }}">
                    </div>
                    <div class="col-md-6" id="floor_question_container" style="display: none;">
                        <label id="floor_question_label" class="form-label"></label>
                        <input type="number" class="form-control" id="floor_value" name="floor_value" min="0" value="">
                        <input type="hidden" id="apartment_floor" name="apartment_floor" value="{{ old('apartment_floor', $property->apartment_floor ?? '') }}">
                        <input type="hidden" id="tenament_floors" name="tenament_floors" value="{{ old('tenament_floors', $property->tenament_floors ?? '') }}">
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
                        <input type="text" class="form-control" id="first_line" name="first_line" value="{{ old('first_line', $property->first_line) }}" required>
                        <div class="invalid-feedback" id="first_line_error"></div>
                    </div>
                    <div class="col-md-6">
                        <label for="second_line" class="form-label">Address Second Line</label>
                        <input type="text" class="form-control" id="second_line" name="second_line" value="{{ old('second_line', $property->second_line) }}">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="village" class="form-label">Village <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="village" name="village" value="{{ old('village', $property->village) }}" required>
                        <div class="invalid-feedback" id="village_error"></div>
                    </div>
                    <div class="col-md-4">
                        <label for="state_id" class="form-label">State <span class="text-danger">*</span></label>
                        <select class="form-select" id="state_id" name="state_id" required>
                            <option value="">Select State</option>
                            @foreach($states as $stateId => $stateName)
                            <option value="{{ $stateId }}" {{ old('state_id', $property->state_id) == $stateId ? 'selected' : '' }}>{{ $stateName }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="state_id_error"></div>
                    </div>
                    <div class="col-md-4">
                        <label for="district_id" class="form-label">District <span class="text-danger">*</span></label>
                        <select class="form-select" id="district_id" name="district_id" required>
                            <option value="">Select District</option>
                            @foreach($districts as $districtId => $districtName)
                            <option value="{{ $districtId }}" {{ old('district_id', $property->district_id) == $districtId ? 'selected' : '' }}>{{ $districtName }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="district_id_error"></div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="taluka_id" class="form-label">Taluka</label>
                        <select class="form-select" id="taluka_id" name="taluka_id">
                            <option value="">Select Taluka</option>
                            @foreach($talukas as $talukaId => $talukaName)
                            <option value="{{ $talukaId }}" {{ old('taluka_id', $property->taluka_id) == $talukaId ? 'selected' : '' }}>{{ $talukaName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="pincode" class="form-label">Pincode <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="pincode" name="pincode" value="{{ old('pincode', $property->pincode) }}" required maxlength="6">
                        <div class="invalid-feedback" id="pincode_error"></div>
                    </div>
                    <div class="col-md-4">
                        <label for="country_id" class="form-label">Country <span class="text-danger">*</span></label>
                        <select class="form-select" id="country_id" name="country_id" required>
                            <option value="">Select Country</option>
                            @foreach($countries as $countryId => $countryName)
                            <option value="{{ $countryId }}" {{ old('country_id', $property->country_id) == $countryId ? 'selected' : '' }}>{{ $countryName }}</option>
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
                        
                        <!-- Existing photos gallery -->
                        @if($property->getPhotosList())
                        <div class="mt-3">
                            <h6>Existing Photos:</h6>
                            <div class="row" id="photo-gallery">
                                @foreach($property->getPhotosList() as $index => $photo)
                                <div class="col-md-3 mb-3 photo-item" data-index="{{ $index }}">
                                    <div class="card">
                                        <img src="{{ asset('assets/photos/' . $photo['photo_path']) }}" class="card-img-top" alt="Shop Photo" style="height: 150px; object-fit: cover; cursor: pointer;" onclick="viewImage('{{ asset('assets/photos/' . $photo['photo_path']) }}')">
                                        <div class="card-body p-2">
                                            <div class="d-flex justify-content-between">
                                                <button type="button" class="btn btn-sm btn-view" onclick="viewImage('{{ asset('assets/photos/' . $photo['photo_path']) }}')" title="View"><i class='bx bx-show'></i></button>
                                                <button type="button" class="btn btn-sm btn-delete" onclick="deletePhoto({{ $index }})" title="Delete"><i class='bx bx-trash'></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
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
                                <input class="form-check-input" type="checkbox" name="amenities[]" value="{{ $amenity->id }}" id="amenity_{{ $amenity->id }}" {{ in_array($amenity->id, $property->getAmenitiesList()) ? 'checked' : '' }}>
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
                        <textarea class="form-control" id="additional_notes" name="additional_notes" rows="3">{{ old('additional_notes', $property->additional_notes) }}</textarea>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end">
                <a href="{{ route('house.show', $property->id) }}" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Update House Record</button>
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

<!-- Image Preview Modal -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imagePreviewModalLabel">Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="previewImage" src="" alt="Preview" class="img-fluid" style="max-height: 70vh;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="#" id="downloadImage" class="btn btn-primary" download>Download</a>
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
    
    // Clear existing options
    stateSelect.innerHTML = '<option value="">Select State</option>';
    districtSelect.innerHTML = '<option value="">Select District</option>';
    talukaSelect.innerHTML = '<option value="">Select Taluka</option>';
    
    if (countryId) {
        fetch("{{ url('admin/house/states') }}/" + countryId)
            .then(response => response.json())
            .then(data => {
                // Check if data is an array
                if (Array.isArray(data)) {
                    data.forEach(state => {
                        const option = document.createElement('option');
                        option.value = state.state_id;
                        option.textContent = state.state_title;
                        stateSelect.appendChild(option);
                    });
                } else {
                    console.error('States data is not an array:', data);
                }
            })
            .catch(error => {
                console.error('Error loading states:', error);
            });
    }
});

// Handle cascading dropdowns
document.getElementById('state_id').addEventListener('change', function() {
    const stateId = this.value;
    const districtSelect = document.getElementById('district_id');
    const talukaSelect = document.getElementById('taluka_id');
    
    // Clear existing options
    districtSelect.innerHTML = '<option value="">Select District</option>';
    talukaSelect.innerHTML = '<option value="">Select Taluka</option>';
    
    if (stateId) {
        fetch("{{ url('admin/house/districts') }}/" + stateId)
            .then(response => response.json())
            .then(data => {
                // Check if data is an array
                if (Array.isArray(data)) {
                    data.forEach(district => {
                        const option = document.createElement('option');
                        option.value = district.districtid;
                        option.textContent = district.district_title;
                        districtSelect.appendChild(option);
                    });
                } else {
                    console.error('Districts data is not an array:', data);
                }
            })
            .catch(error => {
                console.error('Error loading districts:', error);
            });
    }
});

document.getElementById('district_id').addEventListener('change', function() {
    const districtId = this.value;
    const talukaSelect = document.getElementById('taluka_id');
    
    // Clear existing options
    talukaSelect.innerHTML = '<option value="">Select Taluka</option>';
    
    if (districtId) {
        fetch("{{ url('admin/house/talukas') }}/" + districtId)
            .then(response => response.json())
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
                    console.error('Talukas data is not an array:', data);
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
                    fetch("{{ url('admin/house/districts') }}/" + stateId)
                        .then(response => response.json())
                        .then(data => {
                            // Check if data is an array
                            if (Array.isArray(data)) {
                                data.forEach(district => {
                                    const option = document.createElement('option');
                                    option.value = district.districtid;
                                    option.textContent = district.district_title;
                                    districtSelect.appendChild(option);
                                });
                            } else {
                                console.error('Districts data is not an array:', data);
                            }
                        })
                        .catch(error => {
                            console.error('Error loading districts:', error);
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
    
    // Sync floor values before submission
    const propertyType = document.getElementById('property_type_selection').value;
    const floorValue = document.getElementById('floor_value').value;
    const apartmentFloorInput = document.getElementById('apartment_floor');
    const tenamentFloorsInput = document.getElementById('tenament_floors');
    
    if (propertyType === 'apartment') {
        apartmentFloorInput.value = floorValue;
    } else if (propertyType === 'tenament') {
        tenamentFloorsInput.value = floorValue;
    }
    
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
    submitButton.textContent = 'Updating...';
    
    // Clear previous errors
    document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    
    fetch("{{ route('house.update', $property->id) }}", {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-HTTP-Method-Override': 'PUT'
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
            // Success - redirect to show page
            window.location.href = "{{ route('house.show', $property->id) }}";
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Display a user-friendly error message
        const generalError = document.createElement('div');
        generalError.className = 'alert alert-danger';
        generalError.textContent = 'An error occurred while updating the shop record. Please check that your files are under 100MB and try again.';
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

// Image viewer function
function viewImage(url) {
    const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
    const previewImage = document.getElementById('previewImage');
    const downloadLink = document.getElementById('downloadImage');
    
    previewImage.src = url;
    previewImage.alt = 'Image Preview';
    downloadLink.href = url;
    downloadLink.download = url.split('/').pop();
    
    document.getElementById('imagePreviewModalLabel').textContent = 'Image Preview';
    modal.show();
}

// Delete photo function
function deletePhoto(photoIndex) {
    if (confirm('Are you sure you want to delete this photo?')) {
        fetch(`/admin/house/{{ $property->id }}/photos/${photoIndex}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the photo from the DOM
                const photoElement = document.querySelector(`[data-index="${photoIndex}"]`);
                if (photoElement) {
                    photoElement.closest('.col-md-3').remove();
                }
            } else {
                alert('Failed to delete photo. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the photo. Please try again.');
        });
    }
}

document.getElementById('property_type_selection').addEventListener('change', function() {
    const floorQuestionContainer = document.getElementById('floor_question_container');
    const floorQuestionLabel = document.getElementById('floor_question_label');
    const floorValueInput = document.getElementById('floor_value');
    const apartmentFloorInput = document.getElementById('apartment_floor');
    const tenamentFloorsInput = document.getElementById('tenament_floors');
    const isApartmentInput = document.getElementById('is_apartment');
    const isTenamentInput = document.getElementById('is_tenament');
    
    if (this.value === 'apartment') {
        floorQuestionContainer.style.display = 'block';
        floorQuestionLabel.textContent = 'Which Floor is Yours?';
        floorValueInput.value = apartmentFloorInput.value;
        isApartmentInput.value = 'yes';
        isTenamentInput.value = 'no';
    } else if (this.value === 'tenament') {
        floorQuestionContainer.style.display = 'block';
        floorQuestionLabel.textContent = 'How Many Floors in Your House?';
        floorValueInput.value = tenamentFloorsInput.value;
        isApartmentInput.value = 'no';
        isTenamentInput.value = 'yes';
    } else {
        floorQuestionContainer.style.display = 'none';
        floorValueInput.value = '';
        isApartmentInput.value = 'no';
        isTenamentInput.value = 'no';
    }
});

// Update hidden inputs when floor value changes
document.getElementById('floor_value').addEventListener('input', function() {
    const propertyType = document.getElementById('property_type_selection').value;
    const apartmentFloorInput = document.getElementById('apartment_floor');
    const tenamentFloorsInput = document.getElementById('tenament_floors');
    
    if (propertyType === 'apartment') {
        apartmentFloorInput.value = this.value;
    } else if (propertyType === 'tenament') {
        tenamentFloorsInput.value = this.value;
    }
});

// Initialize the state on page load based on existing values
document.addEventListener('DOMContentLoaded', function() {
    const propertyTypeSelect = document.getElementById('property_type_selection');
    const floorQuestionContainer = document.getElementById('floor_question_container');
    const floorQuestionLabel = document.getElementById('floor_question_label');
    const floorValueInput = document.getElementById('floor_value');
    const apartmentFloorInput = document.getElementById('apartment_floor');
    const tenamentFloorsInput = document.getElementById('tenament_floors');
    const isApartmentInput = document.getElementById('is_apartment');
    const isTenamentInput = document.getElementById('is_tenament');
    
    if (isApartmentInput.value === 'yes') {
        propertyTypeSelect.value = 'apartment';
        floorQuestionContainer.style.display = 'block';
        floorQuestionLabel.textContent = 'Which Floor is Yours?';
        floorValueInput.value = apartmentFloorInput.value;
    } else if (isTenamentInput.value === 'yes') {
        propertyTypeSelect.value = 'tenament';
        floorQuestionContainer.style.display = 'block';
        floorQuestionLabel.textContent = 'How Many Floors in Your House?';
        floorValueInput.value = tenamentFloorsInput.value;
    }
});
</script>
@endsection
