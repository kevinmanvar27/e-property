@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Shad</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('shad.index') }}">Shad List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Shad</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Main Form Card -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Shad Record</h5>
    </div>
    <div class="card-body">
        <form id="shad-form" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="property_type" value="shad">
            
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
                        <label for="size" class="form-label">Size (Square Meters) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="size" name="size" step="0.01" min="0" value="{{ old('size', $property->size ?? '') }}" required>
                        <div class="invalid-feedback" id="size_error"></div>
                    </div>
                </div>
                
                <div class="row mb-3">
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
                        @if(isset($property->photos) && is_array($property->getPhotosList()) && count($property->getPhotosList()) > 0)
                        <div class="mt-3">
                            <h6>Existing Photos:</h6>
                            <div class="row" id="photo-gallery">
                                @php
                                    // Sort photos by position if it exists
                                    $sortedPhotos = collect($property->getPhotosList())->sortBy(function($photo) {
                                        return isset($photo['position']) ? $photo['position'] : 0;
                                    });
                                @endphp
                                @foreach($sortedPhotos as $index => $photo)
                                <div class="col-md-3 mb-3 photo-item" data-position="{{ $index }}">
                                    <div class="card">
                                        <img src="{{ asset('assets/photos/' . $photo['photo_path']) }}" class="card-img-top" alt="Shad Photo" style="height: 150px; object-fit: cover; cursor: pointer;" onclick="viewImage('{{ asset('assets/photos/' . $photo['photo_path']) }}')">
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
                                <input class="form-check-input" type="checkbox" name="amenities[]" value="{{ $amenity->id }}" id="amenity_{{ $amenity->id }}"
                                    {{ in_array($amenity->id, old('amenities', $selectedAmenities)) ? 'checked' : '' }}>
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
                <a href="{{ route('shad.index') }}" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Shad Record</button>
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
            <form id="add-amenity-form">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="amenity-name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="amenity-name" name="name" required>
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
    
    // Clear existing options but keep the placeholder
    districtSelect.innerHTML = '<option value="">Select District</option>';
    talukaSelect.innerHTML = '<option value="">Select Taluka</option>';
    
    if (stateId) {
        fetch("{{ url('admin/shad/districts') }}/" + stateId)
            .then(response => response.json())
            .then(data => {
                data.forEach(district => {
                    const option = document.createElement('option');
                    option.value = district.districtid;
                    option.textContent = district.district_title;
                    districtSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading districts:', error);
            });
    }
});

document.getElementById('district_id').addEventListener('change', function() {
    const districtId = this.value;
    const talukaSelect = document.getElementById('taluka_id');
    
    // Clear existing options but keep the placeholder
    talukaSelect.innerHTML = '<option value="">Select Taluka</option>';
    
    if (districtId) {
        fetch("{{ url('admin/shad/talukas') }}/" + districtId)
            .then(response => response.json())
            .then(data => {
                data.forEach(taluka => {
                    const option = document.createElement('option');
                    option.value = taluka.id;
                    option.textContent = taluka.name;
                    talukaSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading talukas:', error);
            });
    }
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
                <img src="${photo.url}" alt="Preview" onclick="viewImage('${photo.url}')">
                <div class="photo-info">
                    <small class="text-muted">${photo.name.substring(0, 20)}${photo.name.length > 20 ? '...' : ''}</small>
                </div>
                <div class="photo-actions">
                    <button type="button" class="btn-move" title="Drag to reposition"><i class='bx bx-move'></i></button>
                    <button type="button" class="btn-view" onclick="viewImage('${photo.url}')" title="View"><i class='bx bx-show'></i></button>
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

function viewImage(url) {
    const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
    const previewImage = document.getElementById('previewImage');
    const downloadLink = document.getElementById('downloadImage');
    
    previewImage.src = url;
    downloadLink.href = url;
    
    modal.show();
}

function deletePhoto(photoIndex) {
    if (confirm('Are you sure you want to delete this photo?')) {
        fetch(`/admin/shad/{{ $property->id }}/photos/${photoIndex}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the photo from the DOM
                const photoElement = document.querySelector(`[data-position="${photoIndex}"]`);
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

// Handle form submission
document.getElementById('shad-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Show loading state
    const submitButton = this.querySelector('button[type="submit"]');
    const originalText = submitButton.textContent;
    submitButton.disabled = true;
    submitButton.textContent = 'Updating...';
    
    // Clear previous errors
    document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    
    // Create FormData object
    const formData = new FormData(this);
    
    // Add selected photos to form data
    selectedPhotos.forEach((photo, index) => {
        formData.append('photos[]', photo.file);
    });
    
    fetch("{{ route('shad.update', $property->id) }}", {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-HTTP-Method-Override': 'PUT'
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
        alert('An error occurred while updating the shad record. Please try again.');
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