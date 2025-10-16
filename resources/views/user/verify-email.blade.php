<!DOCTYPE html>
<html>
<head>
    <title>Verify Your Email</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Verify Your Email Address</h1>

        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <p>Thanks for registering! Before proceeding, please check your email for a verification link.</p>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <input type="email" name="email" placeholder="Enter your email" required>
            <button type="submit">Resend Verification Email</button>
        </form>
    </div>
</body>
</html>
