@extends('user.layouts.app')

@section('content')
<!-- page-title -->
<section class="page-title pt_20 pb_18">
    <div class="large-container">
        <ul class="bread-crumb clearfix">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li>About Us</li>
        </ul>
    </div>
</section>
<!-- page-title end -->

<!-- about-section -->
<section class="about-section pb_80">
    <div class="large-container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12 col-sm-12 image-column">
                <div class="image_block_one">
                    <div class="image-box">
                        <div class="row clearfix">
                            <div class="col-lg-6 col-md-6 col-sm-12 single-column">
                                <figure class="image image-hov-one">
                                    <img src="{{ asset('assets/images/products/house1.jpeg') }}" alt="RProperty Office">
                                </figure>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 single-column">
                                <figure class="image image-hov-two">
                                    <img src="{{ asset('assets/images/products/land-jamin1.jpeg') }}" alt="Property Deals">
                                </figure>
                            </div>
                        </div>
                        <div class="experience-box">
                            <div class="inner">
                                <h2>20</h2>
                                <span>Years of <br />Experience</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 content-column">
                <div class="content_block_two">
                    <div class="content-box ml_30">
                        <div class="text-box mb_55">
                            <h2>Your Trusted Real Estate Partner</h2>
                            <p>
                                At RProperty, we help you discover not just a property — but your true property destiny. With over 20 years of local market expertise, our dedicated team of real estate professionals is committed to making your property search, buying, and selling journey smooth, transparent, and stress-free.
                            </p>
                            <p>
                                Based in Rajkot, Gujarat, we’ve built our reputation on trust, integrity, and personalized service, proudly serving thousands of happy clients across the region and beyond. Whether you’re a first-time homebuyer, an investor, or a business owner looking for the perfect commercial space, we’re here to guide you every step of the way.
                            </p>
                            <p>
                            <p>
                                Our platform offers verified property listings — from dream homes and premium plots to high-potential commercial and investment properties. Each listing is carefully vetted to ensure authenticity and value, giving you confidence in every decision you make.
                            </p>
                            <p>
                                What sets RProperty apart is our end-to-end support — from your first inquiry to property visits, negotiation, legal documentation, and final closing. But our relationship doesn’t end there; we continue to assist you beyond the sale, offering advice, after-sale services, and market insights to help you make the most of your investment.
                            </p>
                            <p>
                                With RProperty, you’re not just finding a property — you’re finding peace of mind. Experience real estate the way it should be: simple, honest, and empowering.
                            </p>
                        </div>
                        <div class="inner-box">
                            <div class="single-item">
                                <div class="count-outer">
                                    <span class="odometer" data-count="2500">00</span><span class="symble">+</span>
                                </div>
                                <p>Properties Listed</p>
                            </div>
                            <div class="single-item">
                                <div class="count-outer">
                                    <span class="odometer" data-count="1200">00</span><span class="symble">+</span>
                                </div>
                                <p>Happy Clients</p>
                            </div>
                            <div class="single-item">
                                <div class="count-outer">
                                    <span class="odometer" data-count="24">00</span><span class="symble">/7</span>
                                </div>
                                <p>Support Available</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- about-section end -->

<!-- video intro (optional, can use for "property video tours" if available) -->
<section class="video-style-two">
    <div class="bg-layer parallax-bg" data-parallax='{"y": 100}' style="background-image: url('{{ asset('assets/images/slider-images/slider-4.jpg') }}');"></div>
    <span class="big-text">RProperty</span>
    <div class="auto-container">
        <div class="inner-container">
            <div class="content-box">
                <h2>Contact Information</h2>
                <h5 class="text-white mb-4">Have questions or want to work together? Let’s start a conversation!</h5>
                <a href="{{ route('contact') }}" class="theme-btn btn-one">Contact Us<span></span><span></span><span></span><span></span></a>
            </div>
        </div>
    </div>
</section>
<!-- video-style-two end -->

<!-- testimonial-style-two -->
<section class="testimonial-style-two pt_70 pb_80">
    <div class="large-container">
        <div class="sec-title pb_10">
            <h2>Love from Customers</h2>
        </div>
        <div class="three-item-carousel owl-carousel owl-theme owl-dots-none nav-style-one">
            <div class="testimonial-block-two">
                <div class="inner-box">
                    <div class="icon-box"><i class="icon-39"></i></div>
                    <ul class="rating">
                        <li><i class="icon-11"></i></li>
                        <li><i class="icon-11"></i></li>
                        <li><i class="icon-11"></i></li>
                        <li><i class="icon-11"></i></li>
                        <li class="light"><i class="icon-11"></i></li>
                    </ul>
                    <p>“Suspendisse est imperdiet pellentesque nulla vulputa te eu pharetra pharetra massa amet ac semper et pelle ntesque dolor tincidunt sodales”</p>
                    <div class="author-box">
                        <figure class="thumb-box">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="70" height="70">
                                <circle cx="32" cy="24" r="12" fill="#fcd7b6" />
                                <path d="M32 38c-10 0-18 6-18 14h36c0-8-8-14-18-14z" fill="#0288d1" />
                                <circle cx="32" cy="24" r="12" fill="#fcd7b6" />
                                <path d="M44 22c0-6.6-5.4-12-12-12s-12 5.4-12 12v2h24v-2z" fill="#5d4037" />
                            </svg>
                        </figure>
                        <h4>Floyd Miles</h4>
                        <span class="designation">UI Designer</span>
                    </div>
                </div>
            </div>
            <div class="testimonial-block-two">
                <div class="inner-box">
                    <div class="icon-box"><i class="icon-39"></i></div>
                    <ul class="rating">
                        <li><i class="icon-11"></i></li>
                        <li><i class="icon-11"></i></li>
                        <li><i class="icon-11"></i></li>
                        <li><i class="icon-11"></i></li>
                        <li class="light"><i class="icon-11"></i></li>
                    </ul>
                    <p>“Suspendisse est imperdiet pellentesque nulla vulputa te eu pharetra pharetra massa amet ac semper et pelle ntesque dolor tincidunt sodales”</p>
                    <div class="author-box">
                        <figure class="thumb-box">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="70" height="70">
                                <circle cx="32" cy="24" r="12" fill="#fcd7b6" />
                                <path d="M32 38c-10 0-18 6-18 14h36c0-8-8-14-18-14z" fill="#0288d1" />
                                <circle cx="32" cy="24" r="12" fill="#fcd7b6" />
                                <path d="M44 22c0-6.6-5.4-12-12-12s-12 5.4-12 12v2h24v-2z" fill="#5d4037" />
                            </svg>
                        </figure>
                        <h4>Cody Fisher</h4>
                        <span class="designation">UI Designer</span>
                    </div>
                </div>
            </div>
            <div class="testimonial-block-two">
                <div class="inner-box">
                    <div class="icon-box"><i class="icon-39"></i></div>
                    <ul class="rating">
                        <li><i class="icon-11"></i></li>
                        <li><i class="icon-11"></i></li>
                        <li><i class="icon-11"></i></li>
                        <li><i class="icon-11"></i></li>
                        <li class="light"><i class="icon-11"></i></li>
                    </ul>
                    <p>“Suspendisse est imperdiet pellentesque nulla vulputa te eu pharetra pharetra massa amet ac semper et pelle ntesque dolor tincidunt sodales”</p>
                    <div class="author-box">
                        <figure class="thumb-box">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="70" height="70">
                                <circle cx="32" cy="24" r="12" fill="#fcd7b6" />
                                <path d="M32 38c-10 0-18 6-18 14h36c0-8-8-14-18-14z" fill="#0288d1" />
                                <circle cx="32" cy="24" r="12" fill="#fcd7b6" />
                                <path d="M44 22c0-6.6-5.4-12-12-12s-12 5.4-12 12v2h24v-2z" fill="#5d4037" />
                            </svg>
                        </figure>
                        <h4>Courtney Henry</h4>
                        <span class="designation">UI Designer</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- testimonial-style-two end -->

<!-- apps-section -->
<section class="apps-section mb-5">
    <div class="large-container">
        <div class="inner-container d-flex justify-content-between align-items-center">
            <div class="bg-layer" style="background-image: url('{{ asset('assets/images/slider-images/slider-3.jpg') }}');"></div>
            <!-- <figure class="image-layer p_absolute r_170 b_0"><img src="{{ asset('assets/images/slider-images/slider-3.jpg') }}" alt=""></figure> -->
            <div class="content-box">
                <h2>Download the RProperty Mobile App</h2>
                <!-- <div class="btn-box">
                    <a href="#" class="apple-store">
                        <img src="{{ asset('assets/images/icons/mac.png') }}" alt="">
                        <span>Download on</span>
                        App Store
                    </a>
                </div> -->
            </div>
            <div class="content-box">
                <div class="btn-box">
                    <a href="#" class="play-store">
                        <img src="{{ asset('assets/images/icons/play.png') }}" alt="">
                        <span>Get it on</span>
                        Google Play
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- apps-section end -->

<!-- instagram-section -->
<section class="instagram-section">
    <div class="outer-container">
        <div class="instagram-carousel owl-carousel owl-theme owl-dots-none owl-nav-none">
            @php
            $imgName = array('house.jpeg', 'shop.jpeg', 'shad.jpeg', 'land-jamin.jpeg', 'plot-3.jpeg');
            @endphp
            @foreach ($imgName as $image)
            <div class="instagram-block-one">
                <div class="inner-box">
                    <figure class="image-box"><img src="{{ asset('assets/images/products/'.$image) }}" alt="Instagram"></figure>
                    <div class="text-box">
                        <a href="{{ url('https://instagram.com/yourpropertybrand') }}">
                            <img src="{{ asset('assets/images/app/icon-10.svg') }}" alt="Instagram">
                            Follow us on Instagram
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- instagram-section end -->
@endsection

@push('scripts')
<script>
fetch("/api/settings")
    .then((res) => res.json())
    .then((data) => {
        const appStoreLink = data.app_store_link || "";
        const playStoreLink = data.google_play_link || "";
        
        const appStoreBtn = document.querySelector(".apple-store");
        const playStoreBtn = document.querySelector(".play-store");

        if (appStoreLink && appStoreBtn) {
            appStoreBtn.setAttribute("href", appStoreLink);
        }
        if (playStoreLink && playStoreBtn) {
            playStoreBtn.setAttribute("href", playStoreLink);
        }
    })
    .catch((err) => console.error("Error loading settings:", err));
</script>
@endpush
