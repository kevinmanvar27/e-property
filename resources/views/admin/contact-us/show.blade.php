@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Contact Us</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('admin.contact-us.index') }}">Messages</a></li>
                <li class="breadcrumb-item active" aria-current="page">View Message</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Message Details</h5>
                    <a href="{{ route('admin.contact-us.index') }}" class="btn btn-sm btn-secondary">
                        <i class='bx bx-arrow-back'></i> Back to Messages
                    </a>
                </div>
                <hr/>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label"><strong>Name:</strong></label>
                        <p>{{ $contact->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><strong>Email:</strong></label>
                        <p><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label"><strong>Phone:</strong></label>
                        <p>{{ $contact->phone ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><strong>Status:</strong></label>
                        <p>
                            <span class="badge 
                                @if($contact->status == 'pending') bg-warning
                                @elseif($contact->status == 'under_review') bg-primary
                                @elseif($contact->status == 'clear') bg-success
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $contact->status)) }}
                            </span>
                        </p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label"><strong>Subject:</strong></label>
                        <p>{{ $contact->subject }}</p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label"><strong>Message:</strong></label>
                        <div class="bg-light p-3 rounded">
                            <p class="mb-0">{{ $contact->message }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label"><strong>Received:</strong></label>
                        <p>{{ $contact->created_at->format('d M Y, H:i:s') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-3">Update Status</h5>
                <form id="status-form">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <select class="form-select" id="status-select">
                            <option value="pending" {{ $contact->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="under_review" {{ $contact->status == 'under_review' ? 'selected' : '' }}>Under Review</option>
                            <option value="clear" {{ $contact->status == 'clear' ? 'selected' : '' }}>Clear</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#status-form').submit(function(e) {
            e.preventDefault();
            
            var status = $('#status-select').val();
            var originalStatus = $('#status-select option:selected').val();
            
            // Show loading indicator
            $('#status-select').prop('disabled', true);
            $('.btn-primary').prop('disabled', true).text('Updating...');
            
            $.ajax({
                url: "{{ route('admin.contact-us.update-status', $contact->id) }}",
                method: 'PATCH',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    // _method: 'PATCH',
                    status: status
                },
                dataType: 'json',
                success: function(response) {
                    $('#status-select').prop('disabled', false);
                    $('.btn-primary').prop('disabled', false).text('Update Status');
                    
                    if(response.success) {
                        // Update the status badge on the page
                        var statusBadge = $('.badge');
                        statusBadge.removeClass('bg-warning bg-primary bg-success');
                        
                        if(response.status == 'pending') {
                            statusBadge.addClass('bg-warning').text('Pending');
                        } else if(response.status == 'under_review') {
                            statusBadge.addClass('bg-primary').text('Under review');
                        } else if(response.status == 'clear') {
                            statusBadge.addClass('bg-success').text('Clear');
                        }
                        
                        // Update the select element to show the new status
                        $('#status-select').val(response.status);
                    } else {
                        // Revert to original status on failure
                        $('#status-select').val(originalStatus);
                        console.log('Failed to update status.');
                        alert('Failed to update status.');
                    }
                },
                error: function(xhr, status, error) {
                    $('#status-select').prop('disabled', false);
                    $('.btn-primary').prop('disabled', false).text('Update Status');
                    
                    // Revert to original status on error
                    $('#status-select').val(originalStatus);
                    console.log('Error details:', xhr.responseText, status, error);
                    alert('An error occurred while updating status: ' + error);
                }
            });
        });
    });
</script>
@endsection