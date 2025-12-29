<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--favicon-->
    @php
        $faviconPath = \App\Models\Setting::get('general', 'favicon');
    @endphp
    <link rel="icon" href="{{ $faviconPath ? safe_asset('storage/' . $faviconPath, 'assets/images/favicon-32x32.png') : asset('assets/images/favicon-32x32.png') }}" type="image/png" />
    <!--plugins-->
    <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <!-- loader-->
    <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/pace.min.js') }}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
    
    <!-- Set page title with format: Page | title - tagline -->
    @php
        $websiteTitle = \App\Models\Setting::get('general', 'website_title', 'E-Property');
        $tagline = \App\Models\Setting::get('general', 'tagline', 'Find Your property destiny');
        $pageTitle = 'Delete User';
        $fullTitle = $pageTitle ? $pageTitle . ' | ' . $websiteTitle . ' - ' . $tagline : $websiteTitle . ' - ' . $tagline;
    @endphp
    <title>{{ $fullTitle }}</title>
    
    <style>
        body {
            background-color: #f5f5f5;
        }
        .delete-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            flex-direction: column;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo-container img {
            max-width: 200px;
            height: auto;
        }
        .card {
            border: none;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .card-body {
            padding: 40px;
        }
        .form-control:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }
        .btn-danger {
            padding: 10px 30px;
            font-weight: 500;
        }
        .alert {
            border-radius: 8px;
        }
        .warning-icon {
            font-size: 48px;
            color: #dc3545;
            margin-bottom: 20px;
        }
        .warning-text {
            color: #dc3545;
            font-weight: 500;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <!--wrapper-->
    <div class="wrapper">
        <div class="delete-container">
            <div class="logo-container">
                @php
                    $logoPath = \App\Models\Setting::get('general', 'logo');
                @endphp
                @if($logoPath)
                    <img src="{{ safe_asset('storage/' . $logoPath, 'assets/images/logo-img.png') }}" alt="logo">
                @else
                    <img src="{{ asset('assets/images/logo-img.png') }}" alt="logo">
                @endif
            </div>
            
            <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <div class="warning-icon">
                                <i class="bx bx-error-circle"></i>
                            </div>
                            <h4 class="mb-3">Delete User Account</h4>
                            <p class="warning-text">⚠️ Warning: This action cannot be undone!</p>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bx bx-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bx bx-error me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bx bx-error me-2"></i>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('user.delete') }}" id="deleteUserForm">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="{{ old('email', $email ?? '') }}" 
                                       placeholder="Enter email address" required>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" 
                                       value="{{ old('password', $password ?? '') }}" 
                                       placeholder="Enter password" required>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-danger" id="deleteBtn">
                                    <i class="bx bx-trash me-2"></i>Delete User Account
                                </button>
                                <a href="{{ route('login') }}" class="btn btn-light">
                                    <i class="bx bx-arrow-back me-2"></i>Back to Login
                                </a>
                            </div>
                        </form>

                        <div class="mt-4 text-center">
                            <p class="text-muted small">
                                <strong>How to use:</strong><br>
                                Access this page with URL parameters:<br>
                                <code>/delete-user?email=user@example.com&password=userpassword</code>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end wrapper-->

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    
    <script>
        // Confirmation before deletion
        document.getElementById('deleteUserForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            
            if (confirm(`Are you absolutely sure you want to delete the user account: ${email}?\n\nThis action CANNOT be undone!`)) {
                this.submit();
            }
        });

        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>

</html>
