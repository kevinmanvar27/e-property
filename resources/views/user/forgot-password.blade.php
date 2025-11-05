@extends('user.layouts.app')

@section('content')
    <!-- page-title -->
    <section class="page-title pt_20 pb_18">
        <div class="large-container">
            <ul class="bread-crumb clearfix">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li>Forgot Password</li>
            </ul>
        </div>
    </section>
    <!-- page-title end -->

    <!-- sign-section -->
    <section class="sign-section pb_80">
        <div class="large-container">
            <div class="sec-title centred pb_30">
                <h2>Reset Your Password</h2>
                <p>Enter your email address and we'll send you a link to reset your password.</p>
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

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group message-btn">
                        <button type="submit" class="theme-btn submit">Send Password Reset Link<span></span><span></span><span></span><span></span></button>
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