@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">House</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">House List</li>
            </ol>
        </nav>
    </div>
    <div class="ms-auto">
        <div class="btn-group">
            <a href="{{ route('house.create') }}" class="btn btn-primary">Add New House</a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="houseTable">
                <thead>
                    <tr>
                        <th>Sr. No</th>
                        <th>Owner Name</th>
                        <th>Property Type</th>
                        <th>Location</th>
                        <th>District</th>
                        <th>State</th>
                        <th class="status-column">Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($properties as $index => $property)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $property->owner_name }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $property->property_type)) }}</td>
                        <td>{{ $property->village }}, {{ $property->taluka ? $property->taluka->name : 'N/A' }}</td>
                        <td>{{ $property->district ? $property->district->district_title : 'N/A' }}</td>
                        <td>{{ $property->state ? $property->state->state_title : 'N/A' }}</td>
                        <td class="status-column">
                            <select class="form-select status-select" data-id="{{ $property->id }}" style="width: 150px;">
                                <option value="active" {{ $property->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $property->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="urgent" {{ $property->status == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                <option value="under_offer" {{ $property->status == 'under_offer' ? 'selected' : '' }}>Under Offer</option>
                                <option value="reserved" {{ $property->status == 'reserved' ? 'selected' : '' }}>Reserved</option>
                                <option value="sold" {{ $property->status == 'sold' ? 'selected' : '' }}>Sold</option>
                                <option value="cancelled" {{ $property->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="coming_soon" {{ $property->status == 'coming_soon' ? 'selected' : '' }}>Coming Soon</option>
                                <option value="price_reduced" {{ $property->status == 'price_reduced' ? 'selected' : '' }}>Price Reduced</option>
                            </select>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <a href="{{ route('house.show', $property->id) }}" class="btn btn-sm btn-info me-2">View</a>
                                <a href="{{ route('house.edit', $property->id) }}" class="btn btn-sm btn-warning me-2">Edit</a>
                                <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{{ $property->id }}">Delete</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('styles')
<!-- DataTables CSS -->
<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
<!-- Select2 CSS -->
<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />
<!-- Toastr CSS -->
<link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
<style>
    /* Ensure status column is always visible */
    .status-column {
        white-space: nowrap;
    }
    
    /* Ensure status dropdown is visible on all screen sizes */
    .status-select {
        min-width: 120px;
    }
    
    /* DataTables responsive fix for status column */
    table.dataTable.dtr-inline.collapsed > tbody > tr > td.status-column:before {
        display: none !important;
    }
</style>
@endsection

@section('scripts')
<!-- DataTables JS -->
<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
<!-- Select2 JS -->
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<!-- Toastr JS -->
<script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

<script>
$(document).ready(function() {
    // Debug: Log when document is ready
    console.log('Document ready for shop index page');
    // Initialize DataTable
    var table = $('#houseTable').DataTable({
        // Debug: Log DataTables initialization
        initComplete: function() {
            console.log('DataTables initialized for house table');
        },
        "order": [[ 0, "asc" ]],
        "pageLength": 10,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "columnDefs": [
            { "responsivePriority": 1, "targets": -1 }, // Make the last column (Actions) have the highest priority
            { "responsivePriority": 2, "targets": 0 }, // Sr. No
            { "responsivePriority": 3, "targets": 1 }, // Owner Name
            { "responsivePriority": 4, "targets": 6 }  // Status
        ]
    });
    
    // Initialize Select2
    $('.status-select').select2({
        theme: 'bootstrap4',
        width: '100%',
        minimumResultsForSearch: Infinity // Hide search box for status dropdown
    });
    
    // Debug: Log Select2 initialization
    console.log('Select2 initialized for status dropdowns');
    
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
    }
    
    // AJAX Delete functionality with better error handling
    $(document).on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        var url = '{{ url("admin/house") }}/' + id;
        
        if (confirm('Are you sure you want to delete this shop record?')) {
            // Show loading state
            var button = $(this);
            var originalText = button.text();
            button.prop('disabled', true).text('Deleting...');
            
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    '_token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success('House record deleted successfully.');
                        // Remove the row from the table
                        table.row(button.closest('tr')).remove().draw();
                    } else {
                        toastr.error('Failed to delete house record.');
                    }
                },
                error: function(xhr) {
                    toastr.error('An error occurred while deleting the house record.');
                },
                complete: function() {
                    // Restore button state
                    button.prop('disabled', false).text(originalText);
                }
            });
        }
    });
    
    // Status update functionality with better feedback
    $(document).on('change', '.status-select', function() {
        var id = $(this).data('id');
        var status = $(this).val();
        var url = '{{ url("admin/house") }}/' + id + '/update-status';
        var select = $(this);
        
        // Show loading state
        select.prop('disabled', true);
        
        $.ajax({
            url: url,
            type: 'PATCH',
            data: {
                '_token': '{{ csrf_token() }}',
                'status': status
            },
            success: function(response) {
                if (response.success) {
                    toastr.success('Status updated successfully.');
                    // Update the status display if needed
                    if (response.status_text) {
                        // This would be used if we were displaying the status text directly
                    }
                } else {
                    toastr.error('Failed to update status.');
                    // Revert the select to previous value
                    select.val(select.data('previous-value'));
                }
            },
            error: function(xhr) {
                toastr.error('An error occurred while updating the status.');
                // Revert the select to previous value
                select.val(select.data('previous-value'));
            },
            complete: function() {
                // Restore select state
                select.prop('disabled', false);
            }
        });
    });
    
    // Store previous value for status select
    $('.status-select').each(function() {
        $(this).data('previous-value', $(this).val());
    });
    
    $('.status-select').on('change', function() {
        $(this).data('previous-value', $(this).val());
    });
});
</script>
@endsection