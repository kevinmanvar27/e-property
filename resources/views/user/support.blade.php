@extends('user.layouts.app')

@section('content')
<section class="support-section py-5">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8 text-center">
                <h1 class="mb-3">R Property Hub – Support</h1>
                <p class="text-muted mb-0">
                    Welcome to the official support page for the <strong>R Property Hub</strong> app and website.
                    R Property Hub is developed and maintained by <strong>RekTech</strong>. 
                    If you have any questions, issues, or feedback, you can reach our support team using the options below.
                </p>
            </div>
        </div>

        <!-- Contact methods -->
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-3">Email Support</h5>
                        <p class="card-text">
                            For general questions, technical issues, or account help, email us:
                        </p>
                        <p class="fw-semibold mb-0">
                            <a href="mailto:rektech.uk@gmail.com">rektech.uk@gmail.com</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-3">Phone / WhatsApp</h5>
                        <p class="card-text">
                            For urgent support during working hours, you can contact:
                        </p>
                        <p class="fw-semibold mb-0">
                            +91&nbsp;78789&nbsp;59565
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-3">Help & FAQs</h5>
                        <p class="card-text">
                            Visit our FAQ and help pages for quick answers to common questions about using R Property Hub.
                        </p>
                        <a href="{{ route('faq') }}" class="btn btn-primary btn-sm">View FAQ</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account / data help -->
        <div class="row justify-content-center mt-5">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="mb-3">Account, Login, and Data Requests</h4>
                        <p class="mb-2">
                            If you need help with your account, login, or property enquiries in the app, please include the
                            phone number or email address you used to register so we can quickly locate your account.
                        </p>
                        <p class="mb-2">
                            To request deletion of your account or personal data, you can:
                        </p>
                        <ul class="mb-2">
                            <li>Use the in-app <strong><a href="{{ route('user.delete.form') }}">Delete Account / Delete My Data</a></strong> option (if available), or</li>
                            <li>
                                Email us at 
                                <a href="mailto:rektech.uk@gmail.com">rektech.uk@gmail.com</a> 
                                with the subject line “Account Deletion Request”.
                            </li>
                        </ul>
                        <p class="mb-0">
                            Once we verify your identity, we will process your request and delete or anonymize your data 
                            within a reasonable timeframe, except where we are required to keep certain information for 
                            legal or security reasons. For more details, please review our 
                            <a href="{{ route('privacy-policy') }}">Privacy Policy</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- About the app -->
        <div class="row justify-content-center mt-5">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="mb-3">About R Property Hub</h4>
                        <p class="mb-2">
                            R Property Hub is a real estate platform that helps users browse, list, and enquire about 
                            properties in a simple and convenient way. The app and website are operated for our client 
                            brand “R Property Hub” and technically developed and maintained by RekTech.
                        </p>
                        <p class="mb-0">
                            For more information about our services, you can also visit the 
                            <a href="{{ route('about-us') }}">About Us</a> page or our 
                            <a href="{{ route('terms-conditions') }}">Terms &amp; Conditions</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
