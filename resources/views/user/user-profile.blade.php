@extends('user.layouts.app')

@section('content') 
    <style>
        .favourite-btn.active {
            background-color: #003085 !important;
            color: #F5B020 !important;
        }
        .favourite-btn {
            border: none !important;
            background: none !important;
        }
    </style>
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
                            <figure class="image-box"><img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('assets/images/products/placeholder.png') }}" alt="{{ Auth::user()->name ?? '' }}" style="max-width: 200px; max-height: 200px;"></figure>
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
                                <div class="d-flex align-items-center justify-content-between">
                                    <h3>Personal Information </h3>
                                    <button id="editProfileBtn"><i class="fas fa-pen" id="editProfileIcon"></i></button>
                                </div>
                                <p>Manage your personal information, including phone numbers and email adress where you can be contacted</p>
                                <form id="editUserForm" enctype="multipart/form-data" class="d-none">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group row mb-4">
                                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name ?? '' }}">
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
                                                <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('assets/images/products/placeholder.png') }}" alt="{{ Auth::user()->name ?? '' }}" style="max-width: 200px; max-height: 200px;">
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
                                <div class="form-group row mb-4 info" id="profileInfo"> 
                                    <div class="row clearfix">
                                        <div class="col-lg-6 col-md-6 col-sm-12 single-column">
                                            <div class="single-item">
                                                <h6>Name</h6>
                                                <span>{{ Auth::user()->name ?? '' }}</span>
                                            </div>
                                        </div>



                                        <div class="col-lg-6 col-md-6 col-sm-12 single-column">
                                            <div class="single-item">
                                                <h6>Email</h6>
                                                <span><a href="#">{{ Auth::user()->email ?? '—' }}</a></span>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-12 single-column">
                                            <div class="single-item">
                                                <h6>Date of Birth</h6>
                                                <span>{{ Auth::user()->dob ? Auth::user()->dob->format('d F Y') : '' }}</span>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-12 single-column">
                                            <div class="single-item">
                                                <h6>Contact</h6>
                                                <span>{{ Auth::user()->contact ?? '' }}</span>
                                            </div>
                                        </div>

                                        <!-- Photo full width -->
                                        <div class="col-12 single-column text-center mt-3">
                                            <div class="single-item">
                                                <h6>Photo</h6>
                                                <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('assets/images/products/placeholder.png') }}" 
                                                    alt="{{ Auth::user()->name ?? '' }}" 
                                                    class="rounded img-fluid mt-2" 
                                                    style="max-width: 150px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                            <div class="wrapper grid">
                                <!-- Grid container -->
                                <div class="shop-grid-content">
                                    <div class="row clearfix" id="property-container-grid">
                                        @if(isset($wishlistItems) && $wishlistItems->count() > 0)
                                            @foreach($wishlistItems as $property)
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="shop-block-two">
                                                        <div class="inner-box">
                                                            <div class="image-box">
                                                                <figure class="image">
                                                                    @if(!empty($property->photos) && count($property->photos) > 0)
                                                                        <img src="{{ asset('storage/photos/' . $property->photos[0]) }}" alt="{{ $property->owner_name ?? '' }}">
                                                                    @else
                                                                        <img src="{{ asset('user/assets/images/property/property-1.jpg') }}" alt="Default Property Image">
                                                                    @endif
                                                                </figure>
                                                            </div>
                                                            <div class="lower-content">
                                                                <span class="product-stock">
                                                                    <img src="{{ asset('user/assets/images/icons/icon-1.png') }}" alt=""> {{ $property->status ?? '' }}
                                                                </span>
                                                                <h4>
                                                                    <a href="{{ route('property-details', $property->id) }}">
                                                                        {{ $property->owner_name ?? ucfirst(str_replace('_',' ',$property->property_type)) }}
                                                                    </a>
                                                                </h4>
                                                                <ul class="property-info clearfix">
                                                                    <li>{{ $property->village ?? '' }}</li>
                                                                    <li>{{ $property->taluka->name ?? '' }}</li>
                                                                    <li>{{ $property->district->district_title ?? '' }}</li>
                                                                    <li>{{ $property->state->state_title ?? '' }}</li>
                                                                </ul>
                                                                <div class="cart-btn d-flex justify-content-between align-items-center">
                                                                    <a href="{{ route('property-details', $property->id) }}">
                                                                        <button type="button" class="theme-btn">
                                                                            View Details<span></span><span></span><span></span><span></span>
                                                                        </button>
                                                                    </a>
                                                                    {{-- Favourite Button --}}
                                                                    <button class="btn favourite-btn active rounded-circle p_15" data-property-id="{{ $property->id }}">
                                                                        <i class="icon-6"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="col-12">
                                                <div class="inner-box text-center p-5">
                                                    <h4>No Wishlist Items Found</h4>
                                                    <p>Start adding properties to your wishlist to see them here.</p>
                                                </div>
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

    $('#editProfileBtn').on('click', function (e) {
        e.preventDefault();

        const isEditing = !$('#editUserForm').hasClass('d-none');

        if (isEditing) {
            // Hide form, show info
            $('#editUserForm').addClass('d-none');
            $('#profileInfo').removeClass('d-none');
            $('#editProfileIcon').removeClass('fa-times').addClass('fa-pen');
        } else {
            // Show form, hide info
            $('#editUserForm').removeClass('d-none');
            $('#profileInfo').addClass('d-none');
            $('#editProfileIcon').removeClass('fa-pen').addClass('fa-times');
        }
    });

    $(document).on('click', '.favourite-btn', function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const btn = $(this);
        const propertyId = btn.data('property-id');
        const isActive = btn.hasClass('active');
        const url = `/wishlist${isActive ? '/' + propertyId : ''}`;
        const method = isActive ? 'DELETE' : 'POST';

        $.ajax({
            url: url,
            type: method,
            data: !isActive ? { property_id: propertyId } : {},
            success: function (res) {
                console.log('Wishlist updated:', res);
                btn.toggleClass('active');

                // Optional: remove from grid if on wishlist page
                if (isActive) {
                    btn.closest('.col-lg-4').fadeOut(300, function () {
                        $(this).remove();
                        // Optionally show "no items" message if grid becomes empty
                        if ($('#property-container-grid').children().length === 0) {
                            $('#property-container-grid').html(`
                                <div class="col-12">
                                    <div class="inner-box text-center p-5">
                                        <h4>No Wishlist Items Found</h4>
                                        <p>Start adding properties to your wishlist to see them here.</p>
                                    </div>
                                </div>
                            `);
                        }
                    });
                }
            },
            error: function (xhr, status, error) {
                alert('Please login to manage your wishlist.');
                console.error('Error:', error);
            }
        });
    });
});

</script>
@endpush

@push('styles')
<style>
    #tab-4 .property-info {
        list-style: none;
        padding: 0;
        margin: 15px 0;
    }
    
    #tab-4 .property-info li {
        display: block;
        margin-bottom: 5px;
        font-size: 14px;
    }
    
    #tab-4 .property-info li i {
        margin-right: 5px;
        color: #003EAC;
    }
    
    #tab-4 .inner-box {
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    #tab-4 .lower-content {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    #tab-4 .cart-btn {
        margin-top: auto;
    }
    
    #tab-4 .product-stock img {
        width: 16px;
        height: 16px;
    }
    
    #tab-4 .shop-block-two {
        margin-bottom: 30px;
    }
</style>
@endpush