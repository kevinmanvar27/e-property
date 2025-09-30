@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Shad</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" aria-label="Dashboard"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('shad.index') }}" aria-label="Shad List">Shad List</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Shad Details</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <!-- Header with actions -->
                <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                    <div>
                        <h5 class="mb-1">{{ $property->owner_name }}</h5>
                        <p class="text-muted mb-0">{{ $property->village }}, {{ $property->district ? $property->district->district_title : 'N/A' }}</p>
                    </div>
                    <div>
                        <a href="{{ route('shad.index') }}" class="btn btn-light btn-sm me-2">
                            <i class='bx bx-arrow-back me-1'></i>Back
                        </a>
                        <a href="{{ route('shad.edit', $property->id) }}" class="btn btn-warning btn-sm me-2">
                            <i class='bx bx-edit me-1'></i>Edit
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteShad({{ $property->id }})">
                            <i class='bx bx-trash me-1'></i>Delete
                        </button>
                    </div>
                </div>
                
                <!-- Summary Stats -->
                <div class="row g-0 border-bottom">
                    <div class="col-4 col-md-4 text-center p-3 border-end" style="cursor: pointer;" onclick="document.querySelector('#photos-section').scrollIntoView({behavior: 'smooth'});">
                        <div class="text-success">
                            <i class='bx bx-image fs-3'></i>
                        </div>
                        <div class="mt-2">
                            <h6 class="mb-0">
                                {{ is_countable($property->getPhotosList()) ? count($property->getPhotosList()) : 0 }}
                            </h6>
                            <p class="text-muted small mb-0">Photos</p>
                        </div>
                    </div>
                    <div class="col-4 col-md-4 text-center p-3 border-end">
                        <div class="text-info">
                            <i class='bx bx-category fs-3'></i>
                        </div>
                        <div class="mt-2">
                            <h6 class="mb-0">
                                {{ is_array($property->amenities) ? count($property->amenities) : 0 }}
                            </h6>
                            <p class="text-muted small mb-0">Amenities</p>
                        </div>
                    </div>
                    <div class="col-4 col-md-4 text-center p-3">
                        <div class="text-warning">
                            <i class='bx bx-purchase-tag fs-3'></i>
                        </div>
                        <div class="mt-2">
                            <h6 class="mb-0">
                                @switch($property->status)
                                    @case('active') <span class="badge bg-success">Active</span> @break
                                    @case('inactive') <span class="badge bg-danger">Inactive</span> @break
                                    @case('urgent') <span class="badge bg-danger">Urgent</span> @break
                                    @case('under_offer') <span class="badge bg-warning">Under Offer</span> @break
                                    @case('reserved') <span class="badge bg-info">Reserved</span> @break
                                    @case('sold') <span class="badge bg-secondary">Sold</span> @break
                                    @case('cancelled') <span class="badge bg-dark">Cancelled</span> @break
                                    @case('coming_soon') <span class="badge bg-primary">Coming Soon</span> @break
                                    @case('price_reduced') <span class="badge bg-success">Price Reduced</span> @break
                                    @default <span class="badge bg-secondary">Unknown</span>
                                @endswitch
                            </h6>
                            <p class="text-muted small mb-0">Status</p>
                        </div>
                    </div>
                </div>
                
                <!-- Main Content -->
                <div class="p-4">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-lg-6">
                            <!-- Address Card -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body">
                                    <h6 class="card-title mb-3 d-flex align-items-center">
                                        <i class='bx bx-map-pin text-primary me-2'></i>
                                        <span>Address Information</span>
                                    </h6>
                                    <div class="ps-4">
                                        <p class="mb-1"><strong>First Line:</strong> {{ $property->first_line }}</p>
                                        @if($property->second_line)
                                        <p class="mb-1"><strong>Second Line:</strong> {{ $property->second_line }}</p>
                                        @endif
                                        <p class="mb-1"><strong>Village:</strong> {{ $property->village }}</p>
                                        <p class="mb-1"><strong>Taluka:</strong> {{ $property->taluka ? $property->taluka->name : 'N/A' }}</p>
                                        <p class="mb-1"><strong>District:</strong> {{ $property->district ? $property->district->district_title : 'N/A' }}</p>
                                        <p class="mb-1"><strong>State:</strong> {{ $property->state ? $property->state->state_title : 'N/A' }}</p>
                                        <p class="mb-1"><strong>Pincode:</strong> {{ $property->pincode }}</p>
                                        <p class="mb-0"><strong>Country:</strong> {{ $property->country ? $property->country->country_name : 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Size Information -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body">
                                    <h6 class="card-title mb-3 d-flex align-items-center">
                                        <i class='bx bx-ruler text-primary me-2'></i>
                                        <span>Size Information</span>
                                    </h6>
                                    <div class="ps-4">
                                        <p class="mb-0"><strong>Size:</strong> {{ $property->size }} Square Meters</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Notes Card -->
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="card-title mb-3 d-flex align-items-center">
                                        <i class='bx bx-note text-primary me-2'></i>
                                        <span>Additional Notes</span>
                                    </h6>
                                    <div class="ps-4">
                                        @if($property->additional_notes)
                                            <div class="bg-light p-3 rounded">
                                                <p class="mb-0">{{ $property->additional_notes }}</p>
                                            </div>
                                        @else
                                            <div class="text-muted">No additional notes provided</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Column -->
                        <div class="col-lg-6">
                            <!-- Contact Information -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body">
                                    <h6 class="card-title mb-3 d-flex align-items-center">
                                        <i class='bx bx-phone text-primary me-2'></i>
                                        <span>Contact Information</span>
                                    </h6>
                                    <div class="ps-4">
                                        <p class="mb-1"><strong>Owner Name:</strong> {{ $property->owner_name }}</p>
                                        @if($property->contact_number)
                                        <p class="mb-0"><strong>Contact Number:</strong> {{ $property->contact_number }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Amenities Card -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body">
                                    <h6 class="card-title mb-3 d-flex align-items-center">
                                        <i class='bx bx-category text-primary me-2'></i>
                                        <span>Amenities</span>
                                    </h6>
                                    <div class="ps-4">
                                        @if(is_array($property->amenities) && count($property->amenities) > 0)
                                            <div>
                                                <div>
                                                    @foreach($property->amenities as $amenityId)
                                                        @php $amenity = \App\Models\Amenity::find($amenityId); @endphp
                                                        @if($amenity)
                                                            <span class="badge bg-primary me-1 mb-1">{{ $amenity->name }}</span>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @else
                                            <div class="text-muted">No amenities selected</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Photographs Card -->
                            <div class="card border-0 shadow-sm" id="photos-section">
                                <div class="card-body">
                                    <h6 class="card-title mb-3 d-flex align-items-center">
                                        <i class='bx bx-image text-primary me-2'></i>
                                        <span>Photographs ({{ is_countable($property->getPhotosList()) ? count($property->getPhotosList()) : 0 }})</span>
                                    </h6>
                                    @if(is_countable($property->getPhotosList()) && count($property->getPhotosList()) > 0)
                                        <div class="row g-2">
                                            @foreach($property->getPhotosList() as $index => $photo)
                                                <div class="col-6 col-md-4">
                                                    <div class="card border-0 shadow-sm h-100 overflow-hidden position-relative photo-container">
                                                        <img src="{{ asset('assets/photos/' . $photo['photo_path']) }}" 
                                                             class="card-img-top img-fluid" 
                                                             alt="Shad Photo" 
                                                             style="height: 150px; width: 100%; object-fit: cover; cursor: pointer;" 
                                                             onclick="openGallery({{ $index }})">
                                                        <div class="photo-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                                                            <div class="d-flex">
                                                                <div class="bg-white rounded-circle p-2 me-2 photo-action-btn d-flex align-items-center justify-content-center" onclick="openGallery({{ $index }}); event.stopPropagation();" style="width: 35px; height: 35px;">
                                                                    <i class='bx bx-show text-primary fs-6'></i>
                                                                </div>
                                                                <div class="bg-white rounded-circle p-2 photo-action-btn d-flex align-items-center justify-content-center" onclick="deletePhoto({{ $property->id }}, {{ $index }}); event.stopPropagation();" style="width: 35px; height: 35px;">
                                                                    <i class='bx bx-trash text-danger fs-6'></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class='bx bx-image-alt text-muted fs-1'></i>
                                            <p class="text-muted mt-2 mb-0">No photographs available</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Gallery Modal -->
<div class="modal fade" id="galleryModal" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0">
            <div class="modal-header bg-light">
                <h6 class="modal-title" id="galleryModalLabel">Photo Gallery</h6>
                <div>
                    <a href="#" id="downloadGalleryImage" class="btn btn-sm btn-outline-primary me-2" download>
                        <i class='bx bx-download'></i> Download
                    </a>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                        <i class='bx bx-x'></i>
                    </button>
                </div>
            </div>
            <div class="modal-body p-0 text-center bg-dark">
                <div class="gallery-container position-relative">
                    <img id="galleryImage" src="" alt="Gallery Image" class="img-fluid" style="max-height: 70vh; object-fit: contain;">
                    <div class="gallery-controls">
                        <button type="button" class="btn btn-light btn-sm position-absolute top-50 start-0 translate-middle-y ms-3" id="prevBtn">
                            <i class='bx bx-chevron-left'></i>
                        </button>
                        <button type="button" class="btn btn-light btn-sm position-absolute top-50 end-0 translate-middle-y me-3" id="nextBtn">
                            <i class='bx bx-chevron-right'></i>
                        </button>
                    </div>
                    <div class="gallery-info position-absolute bottom-0 start-0 w-100 bg-dark bg-opacity-75 text-white p-2">
                        <span id="photoInfo"></span>
                        <span id="photoCounter" class="float-end"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('styles')
<style>
.card {
    border: 1px solid #dee2e6;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.badge {
    font-size: 0.75rem;
    padding: 0.25em 0.5em;
}

.photo-container {
    transition: transform 0.2s ease-in-out;
}

.photo-container:hover {
    transform: translateY(-2px);
}

.photo-overlay {
    background: rgba(0, 0, 0, 0.5);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.photo-container:hover .photo-overlay {
    opacity: 1;
}

.photo-action-btn {
    cursor: pointer;
    transition: transform 0.2s ease;
}

.photo-action-btn:hover {
    transform: scale(1.1);
}

.gallery-controls button {
    opacity: 0.7;
    transition: opacity 0.3s ease;
}

.gallery-controls button:hover {
    opacity: 1;
}
</style>
@endsection

@section('scripts')
<script>
let currentPhotoIndex = 0;
let photoList = [];

function deleteShad(id) {
    if (confirm('Are you sure you want to delete this shad record?')) {
        // Create a form element
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ url("admin/shad") }}/' + id;
        
        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // Add method override for DELETE
        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';
        form.appendChild(method);
        
        // Submit the form
        document.body.appendChild(form);
        form.submit();
    }
}

function deletePhoto(propertyId, photoIndex) {
    if (confirm('Are you sure you want to delete this photo?')) {
        // Create a form element for AJAX request
        fetch('{{ url("admin/shad") }}/' + propertyId + '/photos/' + photoIndex, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload the page to reflect changes
                location.reload();
            } else {
                alert('Failed to delete photo');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the photo');
        });
    }
}

// Gallery functions
function openGallery(index) {
    photoList = @json($property->getPhotosList());
    currentPhotoIndex = index;
    showPhoto(index);
    new bootstrap.Modal(document.getElementById('galleryModal')).show();
}

function showPhoto(index) {
    if (photoList.length === 0) return;
    
    const photo = photoList[index];
    const imageUrl = '{{ asset("assets/photos/") }}/' + photo.photo_path;
    
    document.getElementById('galleryImage').src = imageUrl;
    document.getElementById('downloadGalleryImage').href = imageUrl;
    document.getElementById('photoInfo').textContent = 'Photo ' + (index + 1);
    document.getElementById('photoCounter').textContent = (index + 1) + ' of ' + photoList.length;
}

document.addEventListener('DOMContentLoaded', function() {
    // Previous button
    document.getElementById('prevBtn').addEventListener('click', function() {
        if (photoList.length === 0) return;
        currentPhotoIndex = (currentPhotoIndex - 1 + photoList.length) % photoList.length;
        showPhoto(currentPhotoIndex);
    });
    
    // Next button
    document.getElementById('nextBtn').addEventListener('click', function() {
        if (photoList.length === 0) return;
        currentPhotoIndex = (currentPhotoIndex + 1) % photoList.length;
        showPhoto(currentPhotoIndex);
    });
    
    // Keyboard navigation
    document.getElementById('galleryModal').addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            document.getElementById('prevBtn').click();
        } else if (e.key === 'ArrowRight') {
            document.getElementById('nextBtn').click();
        }
    });
});
</script>
@endsection