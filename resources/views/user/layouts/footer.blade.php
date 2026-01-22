<!-- highlights-section -->
<section class="highlights-section inner-highlights">
    <div class="large-container">
        <div class="inner-container clearfix d-flex flex-wrap justify-content-center justify-content-lg-between">
            <div class="shape" style="background-image: url({{ asset('user/assets/images/shape/shape-5.png') }});"></div>
            <div class="highlights-block-one">
                <div class="inner-box">
                    <div class="icon-box"><i class="icon-17"></i></div>
                    <h5>100% Customer Satisfaction</h5>
                </div>
            </div>
            <div class="highlights-block-one">
                <div class="inner-box">
                    <div class="icon-box"><i class="icon-25"></i></div>
                    <h5>Help and access is our mission</h5>
                </div>
            </div>
            <div class="highlights-block-one">
                <div class="inner-box">
                    <div class="icon-box"><i class="icon-27"></i></div>
                    <h5>24/7 Support for Clients</h5>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- highlights-section end -->

<!-- main-footer -->
<footer class="main-footer">
    <div class="large-container">
        <div class="footer-bottom">
            <div class="bottom-inner d-flex flex-column flex-md-row justify-content-center justify-content-md-between align-items-center gap-3">

                <!-- LEFT SIDE: COPYRIGHT / DEVELOPER INFO -->
                <div class="copyright">
                    <p class="footer-text mb-0">
                        © 2025-26 R Property Hub. All rights reserved. 
                        Developed and maintained by <strong>RekTech</strong>.
                    </p>
                </div>

                <!-- RIGHT SIDE: IMPORTANT LINKS -->
                <ul class="footer-card d-flex flex-wrap justify-content-center gap-2 gap-md-3 list-unstyled mb-0">
                    <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('terms-conditions') }}">Terms &amp; Conditions</a></li>
                    <li><a href="{{ route('about-us') }}">About Us</a></li>
                    <li><a href="{{ route('faq') }}">FAQ</a></li>
                    <li><a href="mailto:support@rproperty.com">Contact Support</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<!-- main-footer end -->

<style>
/* Footer Responsive Styles */
.highlights-section .inner-container {
    gap: 20px;
}

.highlights-block-one {
    margin-bottom: 15px;
}

@media (max-width: 991px) {
    .highlights-section .inner-container {
        padding: 20px 15px;
    }
    
    .highlights-block-one {
        flex: 0 0 45%;
        text-align: center;
    }
    
    .highlights-block-one .inner-box {
        justify-content: center;
    }
}

@media (max-width: 575px) {
    .highlights-block-one {
        flex: 0 0 100%;
    }
    
    .highlights-block-one h5 {
        font-size: 14px;
    }
    
    .footer-card {
        text-align: center;
    }
    
    .footer-card li {
        padding: 5px 10px;
    }
    
    .footer-card li a {
        font-size: 13px;
    }
}
</style>
