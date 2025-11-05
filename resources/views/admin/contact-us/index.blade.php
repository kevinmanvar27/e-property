@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Contact Us</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Messages</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Contact Messages</h5>
        </div>
        <hr/>
        
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="contactTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contacts as $contact)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ $contact->subject }}</td>
                        <td>
                            <span class="badge 
                                @if($contact->status == 'pending') bg-warning
                                @elseif($contact->status == 'under_review') bg-primary
                                @elseif($contact->status == 'clear') bg-success
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $contact->status)) }}
                            </span>
                        </td>
                        <td>{{ $contact->created_at->format('d M Y, H:i') }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('admin.contact-us.show', $contact->id) }}" class="btn btn-sm btn-info me-2">
                                    View
                                </a>
                                <select class="form-select form-select-sm status-select" data-id="{{ $contact->id }}" style="width: auto;">
                                    <option value="pending" {{ $contact->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="under_review" {{ $contact->status == 'under_review' ? 'selected' : '' }}>Under Review</option>
                                    <option value="clear" {{ $contact->status == 'clear' ? 'selected' : '' }}>Clear</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No contact messages found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('styles')
<!-- DataTables CSS -->
<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endsection

@section('scripts')
<!-- DataTables JS -->
<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#contactTable').DataTable({
            "order": [[ 0, "asc" ]], // Sort by Sr. No by default
            "pageLength": 10,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "columnDefs": [
                { "orderable": false, "targets": [6] } // Disable ordering on Actions column
            ]
        });
        
        // Handle status change
        $('.status-select').change(function() {
            var contactId = $(this).data('id');
            var status = $(this).val();
            var selectElement = $(this);
            // Store original state in case we need to revert
            var originalStatus = selectElement.find('option:selected').val();
            
            // Show loading indicator
            selectElement.prop('disabled', true);
            
            $.ajax({
                url: "{{ route('admin.contact-us.update-status', ':id') }}".replace(':id', contactId),
                method: 'PATCH',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    status: status
                },
                dataType: 'json',
                success: function(response) {
                    selectElement.prop('disabled', false);
                    if(response.success) {
                        // Update the status badge in the table row
                        var statusCell = selectElement.closest('tr').find('td:eq(4) .badge');
                        
                        if (statusCell.length > 0) {
                            statusCell.removeClass('bg-warning bg-primary bg-success');
                            
                            if(response.status == 'pending') {
                                statusCell.addClass('bg-warning').text('Pending');
                            } else if(response.status == 'under_review') {
                                statusCell.addClass('bg-primary').text('Under review');
                            } else if(response.status == 'clear') {
                                statusCell.addClass('bg-success').text('Clear');
                            }
                        }
                        
                        // No page reload - UI is updated in real-time
                    } else {
                        // Revert to original status on failure
                        selectElement.val(originalStatus);
                        alert('Failed to update status.');
                    }
                },
                error: function(xhr, status, error) {
                    selectElement.prop('disabled', false);
                    // Revert to original status on error
                    selectElement.val(originalStatus);
                    alert('An error occurred while updating status: ' + error);
                }
            });
        });
    });
</script>
@endsection