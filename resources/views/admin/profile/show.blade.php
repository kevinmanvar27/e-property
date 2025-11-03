@extends('admin.layouts.app')

@section('title', 'User Profile')

@section('content')
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">User Profile</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    
    <div class="container">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                @if($user->photo)
                                    <img src="{{ asset('assets/images/avatars/' . $user->photo) }}" alt="Admin" class="rounded-circle p-1 bg-primary" width="110">
                                @else
                                    <div class="rounded-circle p-1 bg-primary d-flex align-items-center justify-content-center" style="width: 110px; height: 110px;">
                                        <span class="text-white fs-1">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </div>
                                @endif
                                <div class="mt-3">
                                    <h4>{{ $user->name }}</h4>
                                    <p class="text-secondary mb-1">{{ $user->role == 'super_admin' ? 'Super Administrator' : ($user->role == 'admin' ? 'Administrator' : 'User') }}</p>
                                    <p class="text-muted font-size-sm">{{ $user->email }}</p>
                                </div>
                            </div>
                            <hr class="my-4" />
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0"><i class='bx bx-user me-2'></i>Full Name</h6>
                                    <span class="text-secondary">{{ $user->name }}</span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0"><i class='bx bx-envelope me-2'></i>Email</h6>
                                    <span class="text-secondary">{{ $user->email }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0"><i class='bx bx-phone me-2'></i>Contact</h6>
                                    <span class="text-secondary">{{ $user->contact ?? 'N/A' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0"><i class='bx bx-calendar me-2'></i>Date of Birth</h6>
                                    <span class="text-secondary">{{ $user->dob ? $user->dob->format('M d, Y') : 'N/A' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0"><i class='bx bx-calendar-check me-2'></i>Member Since</h6>
                                    <span class="text-secondary">{{ $user->created_at->format('M d, Y') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0"><i class='bx bx-user-check me-2'></i>Status</h6>
                                    <span class="text-secondary">
                                        @if($user->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-primary" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#editProfile" role="tab" aria-selected="true">
                                        <div class="d-flex align-items-center">
                                            <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                                            </div>
                                            <div class="tab-title">Edit Profile</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab" aria-selected="false">
                                        <div class="d-flex align-items-center">
                                            <div class="tab-icon"><i class='bx bx-lock-open font-18 me-1'></i>
                                            </div>
                                            <div class="tab-title">Change Password</div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content py-3">
                                <div class="tab-pane fade show active" id="editProfile" role="tabpanel">
                                    <div class="card border-top border-0 border-4 border-primary">
                                        <div class="card-body p-4">
                                            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="row mb-3">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0">Full Name</h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                                        @error('name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0">Email</h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                                        @error('email')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0">Contact</h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        <input type="text" name="contact" class="form-control @error('contact') is-invalid @enderror" value="{{ old('contact', $user->contact) }}">
                                                        @error('contact')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0">Date of Birth</h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        <input type="date" name="dob" class="form-control @error('dob') is-invalid @enderror" value="{{ old('dob', $user->dob ? $user->dob->format('Y-m-d') : '') }}" max="{{ date('Y-m-d') }}">
                                                        @error('dob')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0">Photo</h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                                                        @error('photo')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                        @if($user->photo)
                                                            <div class="mt-2">
                                                                <img src="{{ asset('assets/images/avatars/' . $user->photo) }}" alt="Current Photo" width="100">
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-3"></div>
                                                    <div class="col-sm-9">
                                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="changePassword" role="tabpanel">
                                    <div class="card border-top border-0 border-4 border-primary">
                                        <div class="card-body p-4">
                                            <form method="POST" action="{{ route('profile.password.update') }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="row mb-3">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0">Current Password</h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required autocomplete="current-password">
                                                        @error('current_password')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0">New Password</h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password">
                                                        @error('password')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0">Confirm New Password</h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        <input type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-3"></div>
                                                    <div class="col-sm-9">
                                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                                    </div>
                                                </div>
                                            </form>
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
</div>
@endsection