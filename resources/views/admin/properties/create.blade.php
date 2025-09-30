@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Properties</div>
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
        <h5 class="mb-0">Add New Property Record</h5>
    </div>
    <div class="card-body">
        <form id="property-form" enctype="multipart/form-data" aria-label="Property Form">
            @csrf
            
            <!-- Section 1: Basic Information -->
            <div class="section-card mb-4">
                <div class="section-header bg-light p-3 mb-3 rounded">
                    <h6 class="mb-0">Basic Information</h6>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="owner_name" class="form-label">Owner Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="owner_name" name="owner_name" required aria-describedby="owner_name_error">
                        <div class="invalid-feedback" id="owner_name_error" role="alert"></div>
                    </div>
                    <div class="col-md-6">
                        <label for="contact_number" class="form-label">Contact Number</label>
                        <input type="text" class="form-control" id="contact_number" name="contact_number" maxlength="15">
                        <div class="invalid-feedback" id="contact_number_error"></div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="property_type" class="form-label">Property Type <span class="text-danger">*</span></label>
                        <select class="form-select" id="property_type" name="property_type" required aria-describedby="property_type_error">
                            <option value="">Select Property Type</option>
                            <option value="land_jamin">Land/Jamin</option>
                            <option value="shop">Shop</option>
                            <option value="plot">Plot</option>
                            <option value="shade">Shade</option>
                            <option value="flat">Flat</option>
                        </select>
                        <div class="invalid-feedback" id="property_type_error" role="alert"></div>
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
            
            <!-- Section 3: Documents -->
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
            
            <!-- Section 4: Photographs -->
            <div class="section-card mb-4">
                <div class="section-header bg-light p-3 mb-3 rounded">
                    <h6 class="mb-0">Photographs</h6>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="photos" class="form-label">Photographs (Multiple uploads supported)</label>
                        <input type="file" class="form-control" id="photos" name="photos[]" multiple accept=".jpg,.jpeg,.png" aria-describedby="photos_error">
                        <div class="invalid-feedback" id="photos_error" role="alert"></div>
                        
                        <!-- Preview area for selected photos with repositioning -->
                        <div class="row mt-3" id="photo-preview" style="display: none;" aria-live="polite">
                            <div class="col-12">
                                <h6>Selected Photos:</h6>
                                <div class="row" id="preview-container"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Section 5: Property Details -->
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
                </div>
            </div>
            
            <!-- Section 6: Issues and Conditions -->
            <div class="section-card mb-4">
                <div class="section-header bg-light p-3 mb-3 rounded">
                    <h6 class="mb-0">Issues and Conditions</h6>
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
                    <div class="col-md-6" id="issue_description_container" style="display: none;">
                        <label for="issue_description" class="form-label">Issue Description (Max 500 characters)</label>
                        <textarea class="form-control" id="issue_description" name="issue_description" rows="3" maxlength="500"></textarea>
                        <div class="invalid-feedback" id="issue_description_error"></div>
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
                
                <!-- Any Family Issue in Land -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="family_issue" class="form-label">Any Family Issue in Land</label>
                        <select class="form-select" id="family_issue" name="family_issue">
                            <option value="">Select</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="col-md-6" id="family_issue_description_container" style="display: none;">
                        <label for="family_issue_description" class="form-label">Family Issue Description (Max 500 characters)</label>
                        <textarea class="form-control" id="family_issue_description" name="family_issue_description" rows="3" maxlength="500"></textarea>
                        <div class="invalid-feedback" id="family_issue_description_error"></div>
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
            
            <!-- Section 7: Additional Information -->
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
                <button type="submit" class="btn btn-primary">Save Property Record</button>
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
                        <div class="invalid-feedback" id="amenity-name-error" role="alert"></div>
                    </div>
                    <div class="mb-3">
                        <label for="amenity-description" class="form-label">Description</label>
                        <textarea class="form-control" id="amenity-description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button type="submit" class="btn btn-primary" id="save-amenity-btn" aria-label="Save Amenity">Save Amenity</button>
                </div>
            </form>
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
            <form id="add-land-type-form">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="land-type-name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="land-type-name" name="name" required>
                        <div class="invalid-feedback" id="land-type-name-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="land-type-description" class="form-label">Description</label>
                        <textarea class="form-control" id="land-type-description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="save-land-type-btn">Save Land Type</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<!-- Select2 CSS -->
<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />
<!-- Toastr CSS -->
<link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
@endsection

@section('scripts')
<!-- Select2 JS -->
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<!-- Toastr JS -->
<script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
<!-- jQuery Validation -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2
    $('#state_id, #district_id, #taluka_id, #country_id, #property_type').select2({
        theme: 'bootstrap4',
        width: '100%'
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
    };
    
    // Cascading dropdowns
    $('#country_id').change(function() {
        var countryId = $(this).val();
        if (countryId) {
            $.ajax({
                url: '{{ url("admin/properties/states") }}/' + countryId,
                type: 'GET',
                success: function(data) {
                    $('#state_id').empty().append('<option value="">Select State</option>');
                    $.each(data, function(key, value) {
                        $('#state_id').append('<option value="' + key + '">' + value + '</option>');
                    });
                    $('#state_id').trigger('change');
                }
            });
        } else {
            $('#state_id').empty().append('<option value="">Select State</option>');
            $('#district_id').empty().append('<option value="">Select District</option>');
            $('#taluka_id').empty().append('<option value="">Select Taluka</option>');
        }
    });
    
    $('#state_id').change(function() {
        var stateId = $(this).val();
        if (stateId) {
            $.ajax({
                url: '{{ url("admin/properties/districts") }}/' + stateId,
                type: 'GET',
                success: function(data) {
                    $('#district_id').empty().append('<option value="">Select District</option>');
                    $.each(data, function(key, value) {
                        $('#district_id').append('<option value="' + key + '">' + value + '</option>');
                    });
                    $('#district_id').trigger('change');
                }
            });
        } else {
            $('#district_id').empty().append('<option value="">Select District</option>');
            $('#taluka_id').empty().append('<option value="">Select Taluka</option>');
        }
    });
    
    $('#district_id').change(function() {
        var districtId = $(this).val();
        if (districtId) {
            $.ajax({
                url: '{{ url("admin/properties/talukas") }}/' + districtId,
                type: 'GET',
                success: function(data) {
                    $('#taluka_id').empty().append('<option value="">Select Taluka</option>');
                    $.each(data, function(key, value) {
                        $('#taluka_id').append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        } else {
            $('#taluka_id').empty().append('<option value="">Select Taluka</option>');
        }
    });
    
    // Conditional fields
    $('#any_issue').change(function() {
        if ($(this).val() === 'Yes') {
            $('#issue_description_container').show();
        } else {
            $('#issue_description_container').hide();
            $('#issue_description').val('');
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
    
    $('#family_issue').change(function() {
        if ($(this).val() === 'Yes') {
            $('#family_issue_description_container').show();
        } else {
            $('#family_issue_description_container').hide();
            $('#family_issue_description').val('');
        }
    });
    
    // File size display
    $('#document_7_12').change(function() {
        var file = this.files[0];
        if (file) {
            var size = (file.size / (1024 * 1024)).toFixed(2);
            $('#document_7_12_size').text('File size: ' + size + ' MB');
        } else {
            $('#document_7_12_size').text('');
        }
    });
    
    $('#document_8a').change(function() {
        var file = this.files[0];
        if (file) {
            var size = (file.size / (1024 * 1024)).toFixed(2);
            $('#document_8a_size').text('File size: ' + size + ' MB');
        } else {
            $('#document_8a_size').text('');
        }
    });
    
    // Photo preview
    $('#photos').change(function() {
        var files = this.files;
        if (files.length > 0) {
            $('#photo-preview').show();
            $('#preview-container').empty();
            
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var reader = new FileReader();
                
                reader.onload = (function(file, index) {
                    return function(e) {
                        var col = $('<div class="col-md-3 mb-3"></div>');
                        var card = $('<div class="card"></div>');
                        var img = $('<img src="' + e.target.result + '" class="card-img-top" style="height: 150px; object-fit: cover;">');
                        var cardBody = $('<div class="card-body text-center"></div>');
                        var fileName = $('<p class="card-text small mb-0">' + file.name.substring(0, 20) + (file.name.length > 20 ? '...' : '') + '</p>');
                        var fileSize = $('<p class="card-text small text-muted mb-0">' + (file.size / (1024 * 1024)).toFixed(2) + ' MB</p>');
                        
                        cardBody.append(fileName, fileSize);
                        card.append(img, cardBody);
                        col.append(card);
                        $('#preview-container').append(col);
                    };
                })(file, i);
                
                reader.readAsDataURL(file);
            }
        } else {
            $('#photo-preview').hide();
        }
    });
    
    // Add Amenity Form Submission
    $('#add-amenity-form').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '{{ route("land-jamin.amenities.store") }}',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    // Add the new amenity to the list
                    var newAmenity = `
                        <div class="form-check me-3 mb-2">
                            <input class="form-check-input" type="checkbox" name="amenities[]" value="${response.amenity.id}" id="amenity_${response.amenity.id}">
                            <label class="form-check-label" for="amenity_${response.amenity.id}">${response.amenity.name}</label>
                        </div>
                    `;
                    $('#amenities-container').append(newAmenity);
                    
                    // Reset form and close modal
                    $('#add-amenity-form')[0].reset();
                    $('#addAmenityModal').modal('hide');
                    
                    toastr.success('Amenity added successfully.');
                }
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        $('#amenity-' + key + '-error').text(value[0]);
                    });
                    toastr.error('Please correct the errors in the form.');
                } else {
                    toastr.error('An error occurred while adding the amenity.');
                }
            }
        });
    });
    
    // Add Land Type Form Submission
    $('#add-land-type-form').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '{{ route("land-jamin.land-types.store") }}',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    // Add the new land type to the list
                    var newLandType = `
                        <div class="form-check me-3 mb-2">
                            <input class="form-check-input" type="checkbox" name="land_types[]" value="${response.landType.id}" id="land_type_${response.landType.id}">
                            <label class="form-check-label" for="land_type_${response.landType.id}">${response.landType.name}</label>
                        </div>
                    `;
                    $('#land-types-container').append(newLandType);
                    
                    // Reset form and close modal
                    $('#add-land-type-form')[0].reset();
                    $('#addLandTypeModal').modal('hide');
                    
                    toastr.success('Land type added successfully.');
                }
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        $('#land-type-' + key + '-error').text(value[0]);
                    });
                    toastr.error('Please correct the errors in the form.');
                } else {
                    toastr.error('An error occurred while adding the land type.');
                }
            }
        });
    });
    
    // Main Form Submission with better performance and accessibility
    $('#property-form').submit(function(e) {
        e.preventDefault();
        
        // Show loading state
        var submitButton = $(this).find('button[type="submit"]');
        var originalText = submitButton.text();
        submitButton.prop('disabled', true).text('Saving...');
        
        // Create FormData object
        var formData = new FormData(this);
        
        // Clear previous error messages
        $('.invalid-feedback').text('');
        $('.form-control, .form-select').removeClass('is-invalid');
        
        // Add performance monitoring
        var startTime = performance.now();
        
        $.ajax({
            url: '{{ route("land-jamin.store") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                var endTime = performance.now();
                var duration = endTime - startTime;
                
                if (response.success) {
                    toastr.success('Property record saved successfully in ' + duration.toFixed(2) + 'ms.');
                    window.location.href = '{{ route("properties.index") }}';
                }
            },
            error: function(xhr) {
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        var errorKey = key.replace(/\./g, '_');
                        $('#' + errorKey + '_error').text(value[0]);
                        $('#' + errorKey).addClass('is-invalid');
                        // Focus first error field for accessibility
                        if (!$('#' + errorKey).is(':focus')) {
                            $('#' + errorKey).focus();
                        }
                    });
                    toastr.error('Please correct the errors in the form.');
                } else {
                    toastr.error('An error occurred while saving the property record.');
                }
            },
            complete: function() {
                // Restore button state
                submitButton.prop('disabled', false).text(originalText);
            }
        });
    });
});
</script>
@endsection