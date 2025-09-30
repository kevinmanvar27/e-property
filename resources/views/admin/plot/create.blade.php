@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Plot</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" aria-label="Dashboard"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('plot.index') }}" aria-label="Plot List">Plot List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add New Plot</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Main Form Card -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Add New Plot Record</h5>
    </div>
    <div class="card-body">
        <form id="plot-form" enctype="multipart/form-data" aria-label="Plot Form">
            @csrf
            <input type="hidden" name="property_type" value="plot">
            
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
                    <h6 class="mb-0">Plot Images</h6>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="photos" class="form-label">Plot Images (Multiple uploads supported)</label>
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
                <a href="{{ route('plot.index') }}" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Plot Record</button>
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
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="amenity_name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="amenity_name" name="name" required>
                        <div class="invalid-feedback" id="amenity_name_error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="amenity_description" class="form-label">Description</label>
                        <textarea class="form-control" id="amenity_description" name="description" rows="3"></textarea>
                        <div class="invalid-feedback" id="amenity_description_error"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Amenity</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Image Preview Modal -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imagePreviewModalLabel">Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="previewImage" src="" alt="Preview" class="img-fluid" style="max-height: 70vh;">
            </div>
            <div class="modal-footer">
                <a href="#" id="downloadImage" class="btn btn-primary" download>Download</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.photo-item {
    position: relative;
    transition: transform 0.2s ease;
}

.photo-info {
    padding: 0.25rem 0.5rem;
    background: #f8f9fa;
    border-top: 1px solid #dee2e6;
    font-size: 0.75rem;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.btn-view, .btn-delete {
    background: rgba(255, 255, 255, 0.8);
    border: none;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.btn-view {
    color: #17a2b8;
}

.btn-delete {
    color: #dc3545;
}

.btn-view:hover, .btn-delete:hover {
    transform: scale(1.1);
}

.file-size-info {
    font-size: 0.875rem;
}
</style>
@endsection

@section('scripts')
<script>
// Handle photo selection preview with repositioning
let selectedPhotos = [];
let draggedItem = null;

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
    
    // Handle photo preview
    const filesArray = Array.from(this.files);
    if (filesArray.length > 0) {
        // Add new files to the existing array
        filesArray.forEach(file => {
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

// Format file size for display
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Photo preview functionality
function displaySelectedPhotos() {
    const previewContainer = document.getElementById('preview-container');
    const photoPreview = document.getElementById('photo-preview');
    
    if (selectedPhotos.length > 0) {
        photoPreview.style.display = 'block';
        previewContainer.innerHTML = '';
        
        selectedPhotos.forEach((photo, index) => {
            const col = document.createElement('div');
            col.className = 'col-md-3 mb-3 photo-item';
            col.setAttribute('data-index', index);
            
            col.innerHTML = `
                <div class="card">
                    <img src="${photo.url}" class="card-img-top" alt="Preview" style="height: 150px; object-fit: cover; cursor: pointer;" onclick="viewImage(${index})">
                    <div class="card-body p-2">
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-sm btn-view" onclick="viewImage(${index})" title="View"><i class='bx bx-show'></i></button>
                            <button type="button" class="btn btn-sm btn-delete" onclick="deletePhoto(${index})" title="Delete"><i class='bx bx-trash'></i></button>
                        </div>
                    </div>
                    <div class="photo-info">
                        <small class="text-muted">${photo.name.substring(0, 20)}${photo.name.length > 20 ? '...' : ''}</small>
                    </div>
                </div>
            `;
            
            previewContainer.appendChild(col);
        });
    } else {
        photoPreview.style.display = 'none';
    }
}

function handleDragStart(e) {
    draggedItem = this;
    setTimeout(() => {
        this.classList.add('dragging');
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
    this.classList.remove('dragging');
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
        fetch("{{ url('admin/plot/states') }}/" + countryId)
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

// Handle state change to load districts
document.getElementById('state_id').addEventListener('change', function() {
    const stateId = this.value;
    const districtSelect = document.getElementById('district_id');
    const talukaSelect = document.getElementById('taluka_id');
    
    // Clear existing options but keep the placeholder
    districtSelect.innerHTML = '<option value="">Select District</option>';
    talukaSelect.innerHTML = '<option value="">Select Taluka</option>';
    
    if (stateId && stateId !== 'add_new') {
        fetch("{{ url('admin/plot/districts') }}/" + stateId)
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
        fetch("{{ url('admin/plot/talukas') }}/" + districtId)
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

// Handle add amenity form submission
document.getElementById('add-amenity-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch("{{ route('plot.amenities.store') }}", {
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
                const errorElement = document.getElementById('amenity_' + field + '_error');
                if (errorElement) {
                    errorElement.textContent = data.errors[field][0];
                }
            });
        } else if (data.success) {
            // Success - add new amenity to the list and select it
            const container = document.getElementById('amenities-container');
            const div = document.createElement('div');
            div.className = 'form-check me-3 mb-2';
            const amenityId = data.amenity.id;
            const amenityName = data.amenity.name;
            div.innerHTML = `
                <input class="form-check-input" type="checkbox" name="amenities[]" value="${amenityId}" id="amenity_${amenityId}" checked>
                <label class="form-check-label" for="amenity_${amenityId}">${amenityName}</label>
            `;
            container.appendChild(div);
            
            // Reset form and close modal
            document.getElementById('add-amenity-form').reset();
            const modal = bootstrap.Modal.getInstance(document.getElementById('addAmenityModal'));
            modal.hide();
            
            // Clear any previous errors
            document.getElementById('amenity_name_error').textContent = '';
            document.getElementById('amenity_description_error').textContent = '';
        }
    })
    .catch(error => {
        console.error('Error adding amenity:', error);
    });
});

// Handle form submission
document.getElementById('plot-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitButton = this.querySelector('button[type="submit"]');
    const originalText = submitButton.textContent;
    
    // Append selected photos to formData
    selectedPhotos.forEach((photo, index) => {
        formData.append('photos[]', photo.file);
    });
    
    // Show loading state
    submitButton.disabled = true;
    submitButton.textContent = 'Saving...';
    
    fetch("{{ route('plot.store') }}", {
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
                }
            });
            
            // Scroll to first error
            const firstError = document.querySelector('.invalid-feedback:not(:empty)');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        } else if (data.success) {
            // Success - redirect to index page
            window.location.href = "{{ route('plot.index') }}";
        }
    })
    .catch(error => {
        console.error('Error saving plot:', error);
        // Show a generic error message
        alert('An error occurred while saving the plot record. Please try again.');
    })
    .finally(() => {
        // Restore button state
        submitButton.disabled = false;
        submitButton.textContent = originalText;
    });
});

// Open add new modal function
function openAddNewModal(entityType, targetSelectId) {
    // Set the entity type and target select in the modal
    document.getElementById('add-new-entity-type').value = entityType;
    document.getElementById('add-new-target-select').value = targetSelectId;
    
    // Open the modal
    const modal = new bootstrap.Modal(document.getElementById('addNewModal'));
    modal.show();
}
</script>
@endsection