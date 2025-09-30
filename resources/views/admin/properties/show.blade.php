@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Properties</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" aria-label="Dashboard"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('land-jamin.index') }}" aria-label="Properties List">Properties List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Property Details</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <!-- Header with actions -->
                <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                    <div>
                        <h5 class="mb-1">{{ $property->owner_name }}</h5>
                        <p class="text-muted mb-0">{{ $property->village }}, {{ $property->district ? $property->district->district_title : 'N/A' }}</p>
                    </div>
                    <div>
                        <a href="{{ route('land-jamin.index') }}" class="btn btn-light btn-sm me-2" aria-label="Back to Properties List">
                            <i class='bx bx-arrow-back me-1'></i>Back
                        </a>
                        <a href="{{ route('land-jamin.edit', $property->id) }}" class="btn btn-warning btn-sm me-2" aria-label="Edit Property">
                            <i class='bx bx-edit me-1'></i>Edit
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteProperty({{ $property->id }})" aria-label="Delete Property">
                            <i class='bx bx-trash me-1'></i>Delete
                        </button>
                    </div>
                </div>
                
                <!-- Summary Stats -->
                <div class="row g-0 border-bottom">
                    <div class="col-6 col-md-6 text-center p-3 border-end" style="cursor: pointer;" onclick="document.querySelector('#photos-section').scrollIntoView({behavior: 'smooth'});" role="button" tabindex="0" aria-label="View Photos">
                        <div class="text-success">
                            <i class='bx bx-image fs-3' aria-hidden="true"></i>
                        </div>
                        <div class="mt-2">
                            <h6 class="mb-0">
                                {{ count($property->getPhotosList()) }}
                            </h6>
                            <p class="text-muted small mb-0">Photos</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-6 text-center p-3" style="cursor: pointer;" onclick="document.querySelector('#documents-section').scrollIntoView({behavior: 'smooth'});" role="button" tabindex="0" aria-label="View Documents">
                        <div class="text-info">
                            <i class='bx bx-file fs-3' aria-hidden="true"></i>
                        </div>
                        <div class="mt-2">
                            <h6 class="mb-0">
                                {{ ($property->document_7_12 ? 1 : 0) + ($property->document_8a ? 1 : 0) }}
                            </h6>
                            <p class="text-muted small mb-0">Documents</p>
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
                            
                            <!-- Documents Card -->
                            <div class="card border-0 shadow-sm mb-4" id="documents-section">
                                <div class="card-body">
                                    <h6 class="card-title mb-3 d-flex align-items-center">
                                        <i class='bx bx-file text-primary me-2'></i>
                                        <span>Documents</span>
                                    </h6>
                                    <div class="ps-4">
                                        <div class="row g-3">
                                            @if($property->document_7_12)
                                            <div class="col-12">
                                                <div class="d-flex align-items-center border rounded p-3 bg-light">
                                                    <div class="flex-shrink-0">
                                                        <i class='bx bx-file-blank fs-3 text-primary' aria-hidden="true"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="mb-0">7/12 Document</h6>
                                                        <p class="text-muted mb-0 small">Property ownership document</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <button type="button" class="btn btn-sm btn-primary" onclick="viewDocument('{{ asset('assets/documents/' . $property->document_7_12) }}')" aria-label="View 7/12 Document">
                                                            <i class='bx bx-show me-1' aria-hidden="true"></i>View
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
                                            
                                            @if($property->document_8a)
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
                                                        <button type="button" class="btn btn-sm btn-primary" onclick="viewDocument('{{ asset('assets/documents/' . $property->document_8a) }}')">
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
                            <!-- Categories Card -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body">
                                    <h6 class="card-title mb-3 d-flex align-items-center">
                                        <i class='bx bx-category text-primary me-2'></i>
                                        <span>Property Details</span>
                                    </h6>
                                    <div class="ps-4">
                                        <p class="mb-1"><strong>Property Type:</strong> {{ ucfirst(str_replace('_', ' ', $property->property_type)) }}</p>
                                        <p class="mb-1"><strong>Contact Number:</strong> {{ $property->contact_number ?? 'N/A' }}</p>
                                        <p class="mb-1"><strong>Status:</strong> 
                                            @if($property->status == 'active')
                                                <span class="badge bg-success">Active</span>
                                            @elseif($property->status == 'inactive')
                                                <span class="badge bg-danger">Inactive</span>
                                            @elseif($property->status == 'urgent')
                                                <span class="badge bg-danger">Urgent</span>
                                            @elseif($property->status == 'under_offer')
                                                <span class="badge bg-warning">Under Offer</span>
                                            @elseif($property->status == 'reserved')
                                                <span class="badge bg-info">Reserved</span>
                                            @elseif($property->status == 'sold')
                                                <span class="badge bg-secondary">Sold</span>
                                            @elseif($property->status == 'cancelled')
                                                <span class="badge bg-dark">Cancelled</span>
                                            @elseif($property->status == 'coming_soon')
                                                <span class="badge bg-primary">Coming Soon</span>
                                            @elseif($property->status == 'price_reduced')
                                                <span class="badge bg-success">Price Reduced</span>
                                            @else
                                                <span class="badge bg-secondary">Unknown</span>
                                            @endif
                                        </p>
                                        <p class="mb-1"><strong>Vavetar:</strong> {{ $property->vavetar ?? 'N/A' }}</p>
                                        <p class="mb-1"><strong>Any Issue:</strong> {{ $property->any_issue ?? 'N/A' }}</p>
                                        @if($property->any_issue == 'Yes' && $property->issue_description)
                                        <p class="mb-1"><strong>Issue Description:</strong> {{ $property->issue_description }}</p>
                                        @endif
                                        <p class="mb-1"><strong>Electric Poll:</strong> {{ $property->electric_poll ?? 'N/A' }}</p>
                                        @if($property->electric_poll == 'Yes' && $property->electric_poll_count)
                                        <p class="mb-1"><strong>Electric Poll Count:</strong> {{ $property->electric_poll_count }}</p>
                                        @endif
                                        <p class="mb-1"><strong>Family Issue:</strong> {{ $property->family_issue ?? 'N/A' }}</p>
                                        @if($property->family_issue == 'Yes' && $property->family_issue_description)
                                        <p class="mb-1"><strong>Family Issue Description:</strong> {{ $property->family_issue_description }}</p>
                                        @endif
                                        <p class="mb-1"><strong>Road Distance:</strong> {{ $property->road_distance ? $property->road_distance . ' feet' : 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Amenities Card -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body">
                                    <h6 class="card-title mb-3 d-flex align-items-center">
                                        <i class='bx bx-check-square text-primary me-2'></i>
                                        <span>Amenities</span>
                                    </h6>
                                    <div class="ps-4">
                                        @if(count($property->getAmenitiesList()) > 0)
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach($property->getAmenitiesList() as $amenityId)
                                                    @php
                                                        $amenity = \App\Models\Amenity::find($amenityId);
                                                    @endphp
                                                    @if($amenity)
                                                        <span class="badge bg-primary">{{ $amenity->name }}</span>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-muted">No amenities selected</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Land Types Card -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body">
                                    <h6 class="card-title mb-3 d-flex align-items-center">
                                        <i class='bx bx-map text-primary me-2'></i>
                                        <span>Land Types</span>
                                    </h6>
                                    <div class="ps-4">
                                        @if(count($property->getLandTypesList()) > 0)
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach($property->getLandTypesList() as $landTypeId)
                                                    @php
                                                        $landType = \App\Models\LandType::find($landTypeId);
                                                    @endphp
                                                    @if($landType)
                                                        <span class="badge bg-info">{{ $landType->name }}</span>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-muted">No land types selected</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Photos Card -->
                            <div class="card border-0 shadow-sm" id="photos-section">
                                <div class="card-body">
                                    <h6 class="card-title mb-3 d-flex align-items-center">
                                        <i class='bx bx-images text-primary me-2'></i>
                                        <span>Photos</span>
                                    </h6>
                                    <div class="ps-4">
                                        @if(count($property->getPhotosList()) > 0)
                                            <div class="row g-3">
                                                @foreach($property->getPhotosList() as $photo)
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="card border-0 shadow-sm">
                                                        <img src="{{ asset('assets/photos/' . $photo['photo_path']) }}" class="card-img-top" alt="Property Photo" style="height: 150px; object-fit: cover; cursor: pointer;" onclick="viewImage('{{ asset('assets/photos/' . $photo['photo_path']) }}')" role="button" tabindex="0" aria-label="View Photo">
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-muted">No photos uploaded</div>
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
</div>

<!-- Image Viewer Modal -->
<div class="modal fade" id="imageViewerModal" tabindex="-1" aria-labelledby="imageViewerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageViewerModalLabel">Photo Viewer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modal-image" src="" alt="Property Photo" class="img-fluid" aria-describedby="imageViewerModalLabel">
            </div>
        </div>
    </div>
</div>

<!-- Document Viewer Modal -->
<div class="modal fade" id="documentViewerModal" tabindex="-1" aria-labelledby="documentViewerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="documentViewerModalLabel">Document Viewer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <iframe id="modal-document" src="" class="w-100" style="height: 500px;"></iframe>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// View image function
function viewImage(imageUrl) {
    document.getElementById('modal-image').src = imageUrl;
    var imageModal = new bootstrap.Modal(document.getElementById('imageViewerModal'));
    imageModal.show();
    // Focus the modal for accessibility
    document.getElementById('imageViewerModal').focus();
}

// View document function
function viewDocument(documentUrl) {
    document.getElementById('modal-document').src = documentUrl;
    var documentModal = new bootstrap.Modal(document.getElementById('documentViewerModal'));
    documentModal.show();
    // Focus the modal for accessibility
    document.getElementById('documentViewerModal').focus();
}

// Delete property function
function deleteProperty(propertyId) {
    if (confirm('Are you sure you want to delete this property record?')) {
        // Create a form dynamically
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ url("admin/properties") }}/' + propertyId;
        
        // Add CSRF token
        var csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // Add method spoofing
        var method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';
        form.appendChild(method);
        
        // Submit the form
        document.body.appendChild(form);
        form.submit();
    }
}

// Keyboard accessibility for summary stats
document.addEventListener('DOMContentLoaded', function() {
    var photoSection = document.querySelector('[aria-label="View Photos"]');
    var documentSection = document.querySelector('[aria-label="View Documents"]');
    
    if (photoSection) {
        photoSection.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                document.querySelector('#photos-section').scrollIntoView({behavior: 'smooth'});
            }
        });
    }
    
    if (documentSection) {
        documentSection.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                document.querySelector('#documents-section').scrollIntoView({behavior: 'smooth'});
            }
        });
    }
});
</script>
@endsection