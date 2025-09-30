@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Land/Jamin</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('land-jamin.index') }}">Land/Jamin List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Land/Jamin Details</li>
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
                        <h5 class="mb-1">{{ $land->owner_name }}</h5>
                        <p class="text-muted mb-0">{{ $land->village }}, {{ $land->district ? $land->district->district_title : 'N/A' }}</p>
                    </div>
                    <div>
                        <a href="{{ route('land-jamin.index') }}" class="btn btn-light btn-sm me-2">
                            <i class='bx bx-arrow-back me-1'></i>Back
                        </a>
                        <a href="{{ route('land-jamin.edit', $land->id) }}" class="btn btn-warning btn-sm me-2">
                            <i class='bx bx-edit me-1'></i>Edit
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteLand({{ $land->id }})">
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
                                {{ is_countable($land->getPhotosList()) ? count($land->getPhotosList()) : 0 }}
                            </h6>
                            <p class="text-muted small mb-0">Photos</p>
                        </div>
                    </div>
                    <div class="col-4 col-md-4 text-center p-3 border-end" style="cursor: pointer;" onclick="document.querySelector('#documents-section').scrollIntoView({behavior: 'smooth'});">
                        <div class="text-info">
                            <i class='bx bx-file fs-3'></i>
                        </div>
                        <div class="mt-2">
                            <h6 class="mb-0">
                                {{ ($land->document_7_12 ? 1 : 0) + ($land->document_8a ? 1 : 0) }}
                            </h6>
                            <p class="text-muted small mb-0">Documents</p>
                        </div>
                    </div>
                    <div class="col-4 col-md-4 text-center p-3">
                        <div class="text-warning">
                            <i class='bx bx-purchase-tag fs-3'></i>
                        </div>
                        <div class="mt-2">
                            <h6 class="mb-0">
                                @switch($land->status)
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
                                        <p class="mb-1"><strong>First Line:</strong> {{ $land->first_line }}</p>
                                        @if($land->second_line)
                                        <p class="mb-1"><strong>Second Line:</strong> {{ $land->second_line }}</p>
                                        @endif
                                        <p class="mb-1"><strong>Village:</strong> {{ $land->village }}</p>
                                        <p class="mb-1"><strong>Taluka:</strong> {{ $land->taluka ? $land->taluka->name : 'N/A' }}</p>
                                        <p class="mb-1"><strong>District:</strong> {{ $land->district ? $land->district->district_title : 'N/A' }}</p>
                                        <p class="mb-1"><strong>State:</strong> {{ $land->state ? $land->state->state_title : 'N/A' }}</p>
                                        <p class="mb-1"><strong>Pincode:</strong> {{ $land->pincode }}</p>
                                        <p class="mb-0"><strong>Country:</strong> {{ $land->country ? $land->country->country_name : 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Documents Card -->
                            <div class="card border-0 shadow-sm mb-4" id="documents-section">
                                <div class="card-body">
                                    <h6 class="card-title mb-3 d-flex align-items-center">
                                        <i class='bx bx-file text-primary me-2'></i>
                                        <span>Documents</span>
                                    </h6>
                                    <div class="ps-4">
                                        <div class="row g-3">
                                            @if($land->document_7_12)
                                            <div class="col-12">
                                                <div class="d-flex align-items-center border rounded p-3 bg-light">
                                                    <div class="flex-shrink-0">
                                                        <i class='bx bx-file-blank fs-3 text-primary'></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="mb-0">7/12 Document</h6>
                                                        <p class="text-muted mb-0 small">Property ownership document</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <button type="button" class="btn btn-sm btn-primary" onclick="viewDocument('{{ asset('assets/documents/' . $land->document_7_12) }}')">
                                                            <i class='bx bx-show me-1'></i>View
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                            <div class="col-12">
                                                <div class="d-flex align-items-center border rounded p-3 bg-light">
                                                    <div class="flex-shrink-0">
                                                        <i class='bx bx-file-blank fs-3 text-secondary'></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="mb-0 text-secondary">7/12 Document</h6>
                                                        <p class="text-muted mb-0 small">No document uploaded</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <button type="button" class="btn btn-sm btn-secondary" disabled>
                                                            <i class='bx bx-show me-1'></i>View
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            
                                            @if($land->document_8a)
                                            <div class="col-12">
                                                <div class="d-flex align-items-center border rounded p-3 bg-light">
                                                    <div class="flex-shrink-0">
                                                        <i class='bx bx-file-blank fs-3 text-primary'></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="mb-0">8A Document</h6>
                                                        <p class="text-muted mb-0 small">Property tax document</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <button type="button" class="btn btn-sm btn-primary" onclick="viewDocument('{{ asset('assets/documents/' . $land->document_8a) }}')">
                                                            <i class='bx bx-show me-1'></i>View
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                            <div class="col-12">
                                                <div class="d-flex align-items-center border rounded p-3 bg-light">
                                                    <div class="flex-shrink-0">
                                                        <i class='bx bx-file-blank fs-3 text-secondary'></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="mb-0 text-secondary">8A Document</h6>
                                                        <p class="text-muted mb-0 small">No document uploaded</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <button type="button" class="btn btn-sm btn-secondary" disabled>
                                                            <i class='bx bx-show me-1'></i>View
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
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
                                        @if($land->additional_notes)
                                            <div class="bg-light p-3 rounded">
                                                <p class="mb-0">{{ $land->additional_notes }}</p>
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
                            <!-- Categories Card -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body">
                                    <h6 class="card-title mb-3 d-flex align-items-center">
                                        <i class='bx bx-category text-primary me-2'></i>
                                        <span>Categories</span>
                                    </h6>
                                    <div class="ps-4">
                                        @if(is_array($land->amenities) && count($land->amenities) > 0)
                                            <div class="mb-3">
                                                <strong class="d-block mb-2">Amenities:</strong>
                                                <div>
                                                    @foreach($land->amenities as $amenityId)
                                                        @php $amenity = \App\Models\Amenity::find($amenityId); @endphp
                                                        @if($amenity)
                                                            <span class="badge bg-primary me-1 mb-1">{{ $amenity->name }}</span>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @if(is_array($land->landTypes) && count($land->landTypes) > 0)
                                            <div>
                                                <strong class="d-block mb-2">Type of Land:</strong>
                                                <div>
                                                    @foreach($land->landTypes as $landTypeId)
                                                        @php $landType = \App\Models\LandType::find($landTypeId); @endphp
                                                        @if($landType)
                                                            <span class="badge bg-success me-1 mb-1">{{ $landType->name }}</span>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @if((!is_array($land->amenities) || count($land->amenities) == 0) && (!is_array($land->landTypes) || count($land->landTypes) == 0))
                                            <div class="text-muted">No categories selected</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Additional Information Card -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body">
                                    <h6 class="card-title mb-3 d-flex align-items-center">
                                        <i class='bx bx-info-circle text-primary me-2'></i>
                                        <span>Additional Information</span>
                                    </h6>
                                    <div class="ps-4">
                                        <!-- First row with 3 parts -->
                                        <div class="row mb-3">
                                            @if($land->vavetar)
                                            <div class="col-md-4">
                                                <strong>Vavetar:</strong>
                                                <div class="text-muted">{{ $land->vavetar }}</div>
                                            </div>
                                            @endif
                                            
                                            @if($land->electric_poll)
                                            <div class="col-md-4">
                                                <strong>Electric Poll:</strong>
                                                <div class="text-muted">{{ $land->electric_poll }}

                                                @if($land->electric_poll == 'Yes' && $land->electric_poll_count)
                                                    (<span class="small">{{ $land->electric_poll_count }}</span>)
                                                @endif

                                                </div>
                                                
                                            </div>
                                            @endif
                                            
                                            @if($land->road_distance)
                                            <div class="col-md-4">
                                                <strong>Road Distance:</strong>
                                                <div class="text-muted">{{ $land->road_distance }} feet</div>
                                            </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Second row with 1 part -->
                                        @if($land->any_issue)
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <strong>Any Issue:</strong>
                                                <div class="text-muted">{{ $land->any_issue }}</div>
                                                @if($land->any_issue == 'Yes' && $land->issue_description)
                                                    <div class="text-danger small">{{ $land->issue_description }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <!-- Third row with 1 part -->
                                        @if($land->family_issue)
                                        <div class="row">
                                            <div class="col-12">
                                                <strong>Family Issue:</strong>
                                                <div class="text-muted">{{ $land->family_issue }}</div>
                                                @if($land->family_issue == 'Yes' && $land->family_issue_description)
                                                    <div class="text-danger small">{{ $land->family_issue_description }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Photographs Card -->
                            <div class="card border-0 shadow-sm" id="photos-section">
                                <div class="card-body">
                                    <h6 class="card-title mb-3 d-flex align-items-center">
                                        <i class='bx bx-image text-primary me-2'></i>
                                        <span>Photographs ({{ is_countable($land->getPhotosList()) ? count($land->getPhotosList()) : 0 }})</span>
                                    </h6>
                                    @if(is_countable($land->getPhotosList()) && count($land->getPhotosList()) > 0)
                                        <div class="row g-2">
                                            @foreach($land->getPhotosList() as $index => $photo)
                                                <div class="col-6 col-md-4">
                                                    <div class="card border-0 shadow-sm h-100 overflow-hidden position-relative photo-container">
                                                        <img src="{{ asset('assets/photos/' . $photo['photo_path']) }}" 
                                                             class="card-img-top img-fluid" 
                                                             alt="Land Photo" 
                                                             style="height: 150px; width: 100%; object-fit: cover; cursor: pointer;" 
                                                             onclick="openGallery({{ $index }})">
                                                        <div class="photo-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                                                            <div class="d-flex">
                                                                <div class="bg-white rounded-circle p-2 me-2 photo-action-btn d-flex align-items-center justify-content-center" onclick="openGallery({{ $index }}); event.stopPropagation();" style="width: 35px; height: 35px;">
                                                                    <i class='bx bx-show text-primary fs-6'></i>
                                                                </div>
                                                                <div class="bg-white rounded-circle p-2 photo-action-btn d-flex align-items-center justify-content-center" onclick="deletePhoto({{ $land->id }}, {{ $index }}); event.stopPropagation();" style="width: 35px; height: 35px;">
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

<!-- Document Viewer Modal -->
<div class="modal fade" id="documentViewerModal" tabindex="-1" aria-labelledby="documentViewerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header bg-light">
                <h6 class="modal-title" id="documentViewerModalLabel">Document Viewer</h6>
                <div>
                    <a href="#" id="downloadDocument" class="btn btn-sm btn-outline-primary me-2" download>
                        <i class='bx bx-download'></i> Download
                    </a>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                        <i class='bx bx-x'></i>
                    </button>
                </div>
            </div>
            <div class="modal-body p-0">
                <div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
                    <iframe id="documentViewer" src="" width="100%" height="600px" style="display: none; background: white;"></iframe>
                    <img id="imageViewer" src="" alt="Image Preview" style="max-width: 100%; max-height: 600px; display: none; object-fit: contain;">
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

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.text-muted {
    color: #6c757d !important;
}

/* Photo container styles */
.photo-container {
    transition: all 0.3s ease;
    cursor: pointer;
}

.photo-container:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.photo-overlay {
    background-color: rgba(0, 0, 0, 0.7);
    transition: opacity 0.3s ease;
    opacity: 0;
    cursor: pointer;
}

.photo-container:hover .photo-overlay {
    opacity: 1;
}

.photo-overlay .photo-action-btn {
    cursor: pointer;
    transition: all 0.2s ease;
    opacity: 0;
    transform: translateY(10px);
}

.photo-container:hover .photo-action-btn {
    opacity: 1;
    transform: translateY(0);
}

.photo-overlay .photo-action-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

/* Stagger the animation delays for each button */
.photo-overlay .photo-action-btn:nth-child(1) {
    transition-delay: 0.1s;
}

.photo-overlay .photo-action-btn:nth-child(2) {
    transition-delay: 0.2s;
}
</style>
@endsection

@section('scripts')
<script>
// Initialize gallery with photo data
let galleryPhotos = [];
let currentPhotoIndex = 0;

document.addEventListener('DOMContentLoaded', function() {
    // Collect all photo URLs and data
    @if(is_countable($land->getPhotosList()) && count($land->getPhotosList()) > 0)
        galleryPhotos = [
            @foreach($land->getPhotosList() as $index => $photo)
                {
                    url: '{{ asset('assets/photos/' . $photo['photo_path']) }}',
                    name: 'Photo #{{ $index + 1 }}',
                    index: {{ $index }}
                },
            @endforeach
        ];
    @endif
});

function openGallery(index) {
    currentPhotoIndex = index;
    showPhoto();
    const modal = new bootstrap.Modal(document.getElementById('galleryModal'));
    modal.show();
}

function showPhoto() {
    if (galleryPhotos.length === 0) return;
    
    const photo = galleryPhotos[currentPhotoIndex];
    const galleryImage = document.getElementById('galleryImage');
    const downloadLink = document.getElementById('downloadGalleryImage');
    const photoInfo = document.getElementById('photoInfo');
    const photoCounter = document.getElementById('photoCounter');
    
    galleryImage.src = photo.url;
    galleryImage.alt = photo.name;
    downloadLink.href = photo.url;
    downloadLink.download = photo.name;
    
    photoInfo.textContent = photo.name;
    photoCounter.textContent = (currentPhotoIndex + 1) + ' of ' + galleryPhotos.length;
    
    document.getElementById('galleryModalLabel').textContent = 'Photo Gallery';
}

function nextPhoto() {
    if (galleryPhotos.length === 0) return;
    
    currentPhotoIndex = (currentPhotoIndex + 1) % galleryPhotos.length;
    showPhoto();
}

function prevPhoto() {
    if (galleryPhotos.length === 0) return;
    
    currentPhotoIndex = (currentPhotoIndex - 1 + galleryPhotos.length) % galleryPhotos.length;
    showPhoto();
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    const galleryModal = document.getElementById('galleryModal');
    
    // Handle gallery navigation
    if (galleryModal && galleryModal.classList.contains('show')) {
        if (e.key === 'ArrowRight') {
            nextPhoto();
        } else if (e.key === 'ArrowLeft') {
            prevPhoto();
        }
    }
});

// Button event listeners
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('nextBtn').addEventListener('click', nextPhoto);
    document.getElementById('prevBtn').addEventListener('click', prevPhoto);
});

// Document viewer function
function viewDocument(url) {
    const documentViewer = document.getElementById('documentViewer');
    const imageViewer = document.getElementById('imageViewer');
    const downloadButton = document.getElementById('downloadDocument');
    const modalTitle = document.getElementById('documentViewerModalLabel');
    
    // Hide both viewers initially
    documentViewer.style.display = 'none';
    imageViewer.style.display = 'none';
    
    // Set download link
    downloadButton.href = url;
    
    // Check if it's an image or document
    if (url.match(/\.(jpeg|jpg|png|gif)$/i)) {
        // It's an image
        modalTitle.textContent = 'Image Viewer';
        imageViewer.src = url;
        imageViewer.style.display = 'block';
    } else {
        // It's a document
        modalTitle.textContent = 'Document Viewer';
        documentViewer.src = url;
        documentViewer.style.display = 'block';
    }
    
    new bootstrap.Modal(document.getElementById('documentViewerModal')).show();
}

// Delete land function
function deleteLand(landId) {
    if (confirm('Are you sure you want to delete this land record?')) {
        const form = document.getElementById('delete-form');
        form.action = `/admin/land-jamin/${landId}`;
        form.submit();
    }
}

// Delete photo function
function deletePhoto(propertyId, photoIndex) {
    if (confirm('Are you sure you want to delete this photo?')) {
        fetch(`/admin/land-jamin/${propertyId}/photos/${photoIndex}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the photo element from the DOM
                const photoElements = document.querySelectorAll(`[onclick*="openGallery"][onclick*="deletePhoto(${photoIndex})"], [onclick*="deletePhoto(${photoIndex})"][onclick*="openGallery"]`);
                photoElements.forEach(element => {
                    if (element.closest('.col-md-4, .col-6')) {
                        element.closest('.col-md-4, .col-6').remove();
                    }
                });
                
                // Also try to remove by photo ID if the above doesn't work
                const photoContainers = document.querySelectorAll('.photo-container');
                photoContainers.forEach(container => {
                    if (container.querySelector(`[onclick*="deletePhoto(${photoIndex})"]`)) {
                        container.closest('.col-md-4, .col-6').remove();
                    }
                });
                
                // Update gallery photos array
                galleryPhotos = galleryPhotos.filter(photo => photo.index !== photoIndex);
            } else {
                // Show error message
                alert('Error deleting photo: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting photo: ' + error.message);
        });
    }
}
</script>
@endsection