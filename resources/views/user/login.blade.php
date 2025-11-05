@extends('user.layouts.app')

@section('content')
    <!-- page-title -->
    <section class="page-title pt_20 pb_18">
        <div class="large-container">
            <ul class="bread-crumb clearfix">
                <li><a href="index.html">Home</a></li>
                <li>Login</li>
            </ul>
        </div>
    </section>
    <!-- page-title end -->


    <!-- sign-section -->
    <section class="sign-section pb_80">
        <div class="large-container">
            <div class="sec-title centred pb_30">
                <h2>Login to your account</h2>
            </div>
            <div class="form-inner">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {!! session('error') !!} <br>
                        <a href="#" id="sendVerificationEmail">Click here for verification mail sent</a>
                    </div>
                @endif

                <div id="verificationMessage"></div> <!-- add this -->

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
                <form method="post" action="{{ url('/login') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" id="email" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" required>
                    </div>
                    <div class="form-group message-btn">
                        <button type="submit" class="theme-btn submit">Log In<span></span><span></span><span></span><span></span></button>
                    </div>
                </form>
                <div class="other-option">
                    <div class="check-box">
                        <input class="check" type="checkbox" id="checkbox1">
                        <label for="checkbox1">Remember me</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="forgot-password">Forget password?</a>
                </div>
                <div class="lower-text centred"><p>Not registered yet? <a href="{{ url('/sign-up') }}">Create an Account</a></p></div>
            </div>
        </div>
    </section>
    <!-- sign-section end -->
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#sendVerificationEmail').on('click', function(e) {
            e.preventDefault();

            const email = $('#email').val().trim();
            const token = '{{ csrf_token() }}';

            if (email === '') {
                $('#verificationMessage').html('<div class="alert alert-danger">Please enter your email first.</div>');
                $('#email').focus();
                return;
            }

            if (!email) {
                $('#verificationMessage').html('<div class="alert alert-danger">No email found.</div>');
                return;
            }

             $('#verificationMessage').html('<div class="alert alert-info">Sending verification email... <span class="spinner-border spinner-border-sm"></span></div>');

            $.ajax({
                url: "{{ route('verification.send') }}",
                type: "POST",
                data: {
                    _token: token,
                    email: email
                },
                success: function(response) {
                    $('#verificationMessage').html('<div class="alert alert-success">' + response.message + '</div>');
                }
            });
        });

    });
</script>
@endpush