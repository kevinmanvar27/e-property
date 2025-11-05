@extends('user.layouts.app')

@section('content')
    <!-- page-title -->
    <section class="page-title pt_20 pb_18">
        <div class="large-container">
            <ul class="bread-crumb clearfix">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li>Reset Password</li>
            </ul>
        </div>
    </section>
    <!-- page-title end -->

    <!-- sign-section -->
    <section class="sign-section pb_80">
        <div class="large-container">
            <div class="sec-title centred pb_30">
                <h2>Reset Your Password</h2>
            </div>
            <div class="form-inner">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ request()->email ?? old('email') }}">
                    
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ request()->email ?? old('email') }}" required readonly>
                    </div>
                    
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="password" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" name="password_confirmation" required>
                    </div>
                    
                    <div class="form-group message-btn">
                        <button type="submit" class="theme-btn submit">Reset Password<span></span><span></span><span></span><span></span></button>
                    </div>
                </form>
                <div class="lower-text centred">
                    <p><a href="{{ route('user-login') }}">Back to Login</a></p>
                </div>
            </div>
        </div>
    </section>
    <!-- sign-section end -->
@endsection