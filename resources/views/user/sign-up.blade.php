@extends('user.layouts.app')

@section('content')
<!-- page-title -->
<section class="page-title pt_20 pb_18">
    <div class="large-container">
        <ul class="bread-crumb clearfix">
            <li><a href="index.html">Home</a></li>
            <li>Signup</li>
        </ul>
    </div>
</section>
<!-- page-title end -->


<!-- sign-section -->
<section class="sign-section pb_80">
    <div class="large-container">
        <div class="sec-title centred pb_30">
            <h2>Create Your Account</h2>
        </div>
        <div class="form-inner">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
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
            <form method="post" action="{{ route('register.post') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="contact" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" required>
                </div>
                <div class="form-group message-btn">
                    <button type="submit" class="theme-btn">Sign Up<span></span><span></span><span></span><span></span></button>
                </div>
            </form>
            <div class="other-option">
                <div class="check-box">
                    <input class="check" type="checkbox" id="checkbox1">
                    <label for="checkbox1">Remember me</label>
                </div>
            </div>
            <div class="lower-text centred"><p>Already have an account? <a href="{{ url('/login') }}">Login Here</a></p></div>
        </div>
    </div>
</section>
<!-- sign-section end -->

@endsection