@extends('admin.layouts.auth')

@section('title', 'Login')

@section('content')
<div class="col-xl-6 mx-auto">
    <div class="card">
        <div class="card-body p-4">
            <div class="text-center">
                <h5 class="mt-3 mb-4">Login</h5>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                @if(session('error'))
                    <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
                        <div class="text-white">{{ session('error') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"  required autocomplete="current-password">
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="bx bx-hide"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const icon = togglePassword.querySelector('i');

        togglePassword.addEventListener('click', function() {
            // Toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Toggle the eye icon
            if (type === 'password') {
                icon.classList.remove('bx-show');
                icon.classList.add('bx-hide');
            } else {
                icon.classList.remove('bx-hide');
                icon.classList.add('bx-show');
            }
        });
    });
</script>
@endsection
