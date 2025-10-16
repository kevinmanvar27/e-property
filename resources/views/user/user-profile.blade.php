@extends('user.layouts.app')

@section('content') 

    <!-- page-title -->
    <section class="page-title pt_20 pb_18">
        <div class="large-container">
            <ul class="bread-crumb clearfix">
                <li><a href="index.html">Home</a></li>
                <li>My Account</li>
            </ul>
        </div>
    </section>
    <!-- page-title end -->


    <!-- account-section -->
    <section class="account-section pb_80">
        <div class="large-container">
            <div class="sec-title centred pb_20">
                <h2>My Account</h2>
            </div>
            <div class="inner-container">
                <div class="tabs-box">
                    <div class="account-info">
                        <div class="upper-box centred mb_40">
                            <figure class="image-box"><img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="{{ Auth::user()->name ?? '' }}" style="max-width: 200px; max-height: 200px;"></figure>
                            <h4>{{ ucwords(Auth::user()->name) ?? '' }}</h4>
                            <a href="mailto:rodiyrock11@gmail.com">{{ Auth::user()->email ?? '' }}</a>
                        </div>
                        <ul class="tab-btns tab-buttons clearfix">
                            <li class="tab-btn active-btn" data-tab="#tab-1">Personal Information</li>
                            <li class="tab-btn" data-tab="#tab-2">Change Password</li>
                            <li class="tab-btn" data-tab="#tab-4">Wishlist</li>
                        </ul>
                    </div>
                    <div class="tabs-content">
                        <div class="tab active-tab" id="tab-1">
                            <div class="personal-info">
                                <h3>Personal Information</h3>
                                <p>Manage your personal information, including phone numbers and email adress where you can be contacted</p>
                                <form id="editUserForm" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group row mb-4">
                                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="username" name="username" value="{{ Auth::user()->username ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label for="dob" class="col-sm-2 col-form-label">DOB</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" id="dob" name="dob" value="{{ Auth::user()->dob ? Auth::user()->dob->format('Y-m-d') : '' }}">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label for="contact" class="col-sm-2 col-form-label">Contact</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" id="contact" name="contact" value="{{ Auth::user()->contact ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4 d-flex align-items-center">
                                        <label for="address" class="col-sm-2 col-form-label">Old Photo</label>
                                        <div class="col-sm-10">
                                            @if(Auth::user()->photo)
                                                <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="{{ Auth::user()->name ?? '' }}" style="max-width: 200px; max-height: 200px;">
                                            @else
                                                <p>No photo uploaded</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label for="photo" class="col-sm-2 col-form-label">Photo</label>
                                        <div class="col-sm-10">
                                            <input type="file" class="form-control" id="photo" name="photo">
                                        </div>
                                    </div>
                                    <div>
                                        <button type="submit" class="theme-btn" id="updateProfileBtn">Update Profile</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab" id="tab-2">
                            <div class="personal-info">
                                <h3>Change Password</h3>
                                <p>Update your password regularly to keep your account secure</p>
                                <form id="changePasswordForm">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group row mb-4">
                                        <label for="current_password" class="col-sm-2 col-form-label">Current Password</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="current_password" name="current_password">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label for="password" class="col-sm-2 col-form-label">New Password</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="password" name="password">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label for="password_confirmation" class="col-sm-2 col-form-label">Confirm New Password</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                        </div>
                                    </div>
                                    <div>
                                        <button type="submit" class="theme-btn" id="changePasswordBtn">Change Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab" id="tab-4">
                            <h3>Wishlist</h3>   
                            <p>No Wishlist</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- account-section end -->
     
@endsection

@push('scripts')
<script>
    
$(document).ready(function() {

    // Profile update form
    $('#editUserForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var formData = new FormData(this);
        
        $.ajax({
            url: '{{ route("user.profile.update") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-HTTP-Method-Override': 'PUT'
            },
            success: function(response) {
                // Check if toastr is available, otherwise use alert
                if (typeof toastr !== 'undefined') {
                    toastr.success('Profile updated successfully');
                } else {
                    alert('Profile updated successfully');
                }
                // Reload the page to show updated information
                location.reload();
            },
            error: function(xhr) {
                // Check if toastr is available, otherwise use alert
                if (typeof toastr !== 'undefined') {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        var errorMsg = '';
                        $.each(errors, function(key, value) {
                            errorMsg += value[0] + '\n';
                        });
                        toastr.error(errorMsg);
                    } else {
                        toastr.error('Error updating profile');
                    }
                } else {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        var errorMsg = '';
                        $.each(errors, function(key, value) {
                            errorMsg += value[0] + '\n';
                        });
                        alert('Error: ' + errorMsg);
                    } else {
                        alert('Error updating profile');
                    }
                }
            }
        });
    });

    // Password change form
    $('#changePasswordForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var formData = form.serialize();
        
        $.ajax({
            url: '{{ route("user.profile.password.update") }}',
            type: 'POST',
            data: formData,
            headers: {
                'X-HTTP-Method-Override': 'PUT'
            },
            success: function(response) {
                // Check if toastr is available, otherwise use alert
                if (typeof toastr !== 'undefined') {
                    toastr.success('Password updated successfully');
                } else {
                    alert('Password updated successfully');
                }
                // Reset form
                form[0].reset();
            },
            error: function(xhr) {
                // Check if toastr is available, otherwise use alert
                if (typeof toastr !== 'undefined') {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        var errorMsg = '';
                        $.each(errors, function(key, value) {
                            errorMsg += value[0] + '\n';
                        });
                        toastr.error(errorMsg);
                    } else {
                        toastr.error('Error updating password');
                    }
                } else {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        var errorMsg = '';
                        $.each(errors, function(key, value) {
                            errorMsg += value[0] + '\n';
                        });
                        alert('Error: ' + errorMsg);
                    } else {
                        alert('Error updating password');
                    }
                }
            }
        });
    });
});
</script>
@endpush