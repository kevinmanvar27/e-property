@extends('user.layouts.app')

@section('content')
        
        <!-- page-title -->
        <section class="page-title pt_20 pb_18">
            <div class="large-container">
                <ul class="bread-crumb clearfix">
                    <li><a href="index.html">Home</a></li>
                    <li>Contact</li>
                </ul>
            </div>
        </section>
        <!-- page-title end -->


        <!-- contact-section -->
        <section class="contact-section  pb_80">
            <div class="large-container">
                <div class="row clearfix">
                    <div class="col-lg-6 col-md-12 col-sm-12 content-column">
                        <div class="form-inner">
                            <form method="post" action="sendemail.php" id="contact-form">
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                        <label>Name</label>
                                        <input type="text" name="username" placeholder="" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                        <label>E-mail</label>
                                        <input type="email" name="email" placeholder="" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                        <label>Phone</label>
                                        <input type="text" name="phone" placeholder="" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                        <label>Subject</label>
                                        <input type="text" name="subject" placeholder="" required>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                        <label>Write Message *</label>
                                        <textarea name="message" placeholder=""></textarea>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                        <button type="submit" class="theme-btn" name="submit-form">Send Message<span></span><span></span><span></span><span></span></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 map-column">
                        <div class="large-container">
                            <div class="sec-title centred pb_2">
                                <h2>Contact Information</h2>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12  info-column">
                                    <div class="info-block-one">
                                        <div class="inner-box">
                                            <div class="icon-box"><i class="icon-50"></i></div>
                                            <h4>Corporate Office</h4>
                                            <p id="address"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12  info-column">
                                    <div class="info-block-one">
                                        <div class="inner-box">
                                            <div class="icon-box"><i class="icon-51"></i></div>
                                            <h4>Email Address</h4>
                                            <p id="emailAddress"><a href=""></a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12  info-column">
                                    <div class="info-block-one">
                                        <div class="inner-box">
                                            <div class="icon-box"><i class="icon-52"></i></div>
                                            <h4>Phone Number</h4>
                                            <p id="phoneNumber">Emergency Cases <br><a href=""></a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- contact-section end -->

@endsection

@push('scripts')
    <script>
        fetch("/api/settings")
            .then((res) => res.json())
            .then((data) => {
                const email = data.email_address || "";
                const phoneNumber = data.phone_number || "";
                const physicalAddress = data.physical_address || "";

                const emailContainer = document.getElementById("emailAddress");
                const phoneNumberContainer = document.getElementById("phoneNumber");
                const addressContainer = document.getElementById("address");

                if (email && emailContainer)
                {
                    emailContainer.innerHTML = '<a href="mailto:' + email + '">' + email + '</a>';    
                }
                if (phoneNumber && phoneNumberContainer)
                {
                    phoneNumberContainer.innerHTML = '<a href="tel:' + phoneNumber + '">' + phoneNumber + '</a> (24/7)';    
                }
                if (physicalAddress && addressContainer)
                {
                    addressContainer.innerHTML = physicalAddress;    
                }
            });
    </script>
@endpush
