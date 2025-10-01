@extends('admin.layouts.app')

@section('title', 'Test Auto Logout')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-xl-12 mx-auto">
            <h6 class="mb-0 text-uppercase">Auto Logout Test</h6>
            <hr/>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Auto Logout Feature Test</h5>
                    <p class="card-text">
                        This page is for testing the auto logout functionality. 
                        The auto logout timeout is currently set to <strong>{{ \App\Models\Setting::get('general', 'auto_logout_timeout', 30) }}</strong> minutes.
                    </p>
                    <p class="card-text">
                        If you don't perform any activity (mouse movement, keyboard input, etc.) for the specified time, 
                        you should be automatically logged out.
                    </p>
                    <p class="card-text">
                        To test this feature, you can:
                    </p>
                    <ul>
                        <li>Set a short timeout (e.g., 1 minute) in the General Settings</li>
                        <li>Come back to this page and remain inactive</li>
                        <li>Observe if you're automatically logged out after the specified time</li>
                    </ul>
                    <a href="{{ route('settings.index') }}" class="btn btn-primary">Go to Settings to Adjust Timeout</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection