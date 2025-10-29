@extends('user.layouts.app')

@section('content')
  <!-- Hero Slider -->
    <section class="banner-style-six pt_30">
      <div class="large-container">
        <div class="banner-carousel owl-theme owl-carousel owl-nav-none dots-style-one">

          <div class="slide-item p_relative">
            <div class="bg-layer" style="background-image: url('{{ asset('assets/images/slider-images/slider-1.jpg') }}');"></div>
            <div class="content-box">
              <span class="upper-text text-white">Featured Property</span>
              <h2 class="text-white"><span class="text-white">Discover Premium Living</span> in Every Corner</h2>
              <h3 class="text-white">Explore top-rated homes & spaces across the city</h3>
              <div class="btn-box"><a href="{{ route('properties') }}" class="theme-btn btn-one">Explore Now<span></span><span></span><span></span><span></span></a></div>
            </div>
          </div>

          <div class="slide-item p_relative">
            <div class="bg-layer" style="background-image: url('{{ asset('assets/images/slider-images/slider-2.jpg') }}');"></div>
            <div class="content-box">
              <span class="upper-text text-white">Property Insights</span>
              <h2 class="text-white"><span class="text-white">Find Your Perfect Space</span> to Call Home</h2>
              <h3 class="text-white">From apartments to villas — we cover it all</h3>
              <div class="btn-box"><a href="{{ route('about-us') }}" class="theme-btn btn-one">Learn More<span></span><span></span><span></span><span></span></a></div>
            </div>
          </div>

          <div class="slide-item p_relative">
            <div class="bg-layer" style="background-image: url('{{ asset('assets/images/slider-images/slider-3.jpg') }}');"></div>
            <div class="content-box">
              <span class="upper-text text-white">RProperty Guide</span>
              <h2 class="text-white"><span class="text-white">Trusted Property Information</span> You Can Rely On</h2>
              <h3 class="text-white">Detailed insights, locations, and trends — all in one place</h3>
              <div class="btn-box"><a href="{{ route('contact') }}" class="theme-btn btn-one">Get in Touch<span></span><span></span><span></span><span></span></a></div>
            </div>
          </div>

        </div>
      </div>
    </section>
  <!-- Hero Slider -->

  <!-- Property Types -->
    <section class="shop-page-section py-5 bg-light">
      <div class="container text-center">
        <h2 class="mb-4 fw-bold">Property Types</h2>
        <div class="row justify-content-center g-4">
          @php
            $properties = [
              ['img' => 'shop.jpeg', 'name' => 'Shop', 'type' => 'shop'],
              ['img' => 'land-jamin.jpeg', 'name' => 'Land Jamin', 'type' => 'landJamin'],
              ['img' => 'plot-3.jpeg', 'name' => 'Plot', 'type' => 'plot'],
              ['img' => 'shad.jpeg', 'name' => 'Shad', 'type' => 'shad'],
              ['img' => 'house.jpeg', 'name' => 'House', 'type' => 'house'],
            ];
          @endphp

          @foreach ($properties as $property)
          <div class="col-6 col-md-4 col-lg-2">
            <div class="card border-0 shadow-sm h-100">
              <img src="{{ asset('assets/images/products/' . $property['img']) }}" class="card-img-top rounded" alt="{{ $property['name'] }}">
              <div class="card-body text-center">
                <h5 class="fw-semibold mb-0">
                  <a href="{{ route('properties') }}?property_type={{ $property['type'] }}" class="stretched-link text-decoration-none text-dark">
                    {{ $property['name'] }}
                  </a>
                </h5>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </section>
  <!-- Property Types -->

  <!-- Display Properties -->
    <section class="clients-section pt_70 pb_80">
        <div class="large-container">
            <div class="sec-title">
                <h2>Latest Properties</h2>
            </div>
            <div id="properties-container" class="row">
                <!-- Properties will be loaded here via AJAX -->
                <div class="col-12 text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
  <!-- Display Properties -->

  <!-- Contact Section -->
        <!-- video-style-two -->
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
  <!-- Contact Section -->

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
                                <circle cx="32" cy="24" r="12" fill="#fcd7b6"/>
                                <path d="M32 38c-10 0-18 6-18 14h36c0-8-8-14-18-14z" fill="#0288d1"/>
                                <circle cx="32" cy="24" r="12" fill="#fcd7b6"/>
                                <path d="M44 22c0-6.6-5.4-12-12-12s-12 5.4-12 12v2h24v-2z" fill="#5d4037"/>
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
                                    <circle cx="32" cy="24" r="12" fill="#fcd7b6"/>
                                    <path d="M32 38c-10 0-18 6-18 14h36c0-8-8-14-18-14z" fill="#0288d1"/>
                                    <circle cx="32" cy="24" r="12" fill="#fcd7b6"/>
                                    <path d="M44 22c0-6.6-5.4-12-12-12s-12 5.4-12 12v2h24v-2z" fill="#5d4037"/>
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
                                    <circle cx="32" cy="24" r="12" fill="#fcd7b6"/>
                                    <path d="M32 38c-10 0-18 6-18 14h36c0-8-8-14-18-14z" fill="#0288d1"/>
                                    <circle cx="32" cy="24" r="12" fill="#fcd7b6"/>
                                    <path d="M44 22c0-6.6-5.4-12-12-12s-12 5.4-12 12v2h24v-2z" fill="#5d4037"/>
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
  
  <style>
    .favourite-btn.active {
        background-color: #003085 !important;
        color: #F5B020 !important;
    }
    .favourite-btn{
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
    }
  </style>
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

    // Fetch latest properties from each property type
    document.addEventListener('DOMContentLoaded', async () => {
      const types = ['shop', 'land-jamin', 'plot', 'shad', 'house'];
      const typeNames = {
        'shop': 'Shop',
        'land-jamin': 'Land/Jamin',
        'plot': 'Plot',
        'shad': 'Shad',
        'house': 'House'
      };
      const container = document.getElementById('properties-container');
      container.innerHTML = '';

      const defaultImg = "{{ asset('assets/images/products/default-property.jpg') }}";
      
      // Create a container for all property types
      let htmlContent = '';

      // Initialize wishlist array
      let userWishlistIds = [];

      // Fetch user's wishlist on page load
      try {
        const wishlistRes = await fetch('/wishlist');
        if (wishlistRes.ok) {
          const wishlistData = await wishlistRes.json();
          userWishlistIds = [...new Set(wishlistData.wishlist || [])];
        }
      } catch (e) {
        console.log('Could not load wishlist:', e);
      }

      // Helper function to convert string to title case
      function toTitleCase(str) {
        if (!str) return '';
        return str
          .toLowerCase()
          .replace(/[_-]+/g, ' ') // replace underscores or hyphens with space
          .split(' ')
          .filter(Boolean) // remove empty parts
          .map(word => word.charAt(0).toUpperCase() + word.slice(1))
          .join(' ');
      }

      for (const type of types) {
        try {
          const res = await fetch(`/api/${type}?per_page=4`);
          const data = await res.json();
          const properties = data?.data?.data || [];

          if (properties.length) {
            // Special handling for Land Jamin link parameter
            const linkPropertyType = type === 'land-jamin' ? 'landJamin' : type;
            
            // Add type heading
            htmlContent += `
              <div class="mb-5">
                <div class="d-flex justify-content-between border-bottom">
                  <h3 class="mb-4 pb-2">${typeNames[type] || toTitleCase(type)}</h3>
                  <a href="/properties?property_type=${linkPropertyType}">
                    <button type="button" class="theme-btn">View ${typeNames[type] || toTitleCase(type)}<span></span><span></span><span></span><span></span></button>
                  </a>
                </div>
                <div class="row clearfix">
            `;

            // Add properties for this type using the shop-block-two design
            properties.slice(0, 4).forEach(property => {
              let imageUrl = defaultImg;
              const isFavourite = userWishlistIds.includes(parseInt(property.id));

              if (property.photos) {
                try {
                  const photosArray = JSON.parse(property.photos);
                  if (Array.isArray(photosArray) && photosArray.length > 0) {
                    imageUrl = '{{ asset("storage/photos") }}/' + photosArray[0];
                  }
                } catch (e) {
                  console.error("Invalid photo format:", property.photos);
                }
              }

              const propertyDetailsUrl = `/property-details/${property.id}`;

              htmlContent += `
                <div class="col-lg-3 col-md-6 col-sm-12 shop-block">
                  <div class="shop-block-two">
                    <div class="inner-box">
                      <div class="image-box">
                        <figure class="image property-img-home"><img src="${imageUrl}" alt="${property.owner_name || 'Property'}" ></figure>
                      </div>
                      <div class="lower-content">
                        <span class="product-stock"><img src="{{ asset('user/assets/images/icons/icon-1.png') }}" alt=""> ${toTitleCase(property.status) || ''}</span>
                        <h4><a href="${propertyDetailsUrl}">${property.owner_name || 'Unnamed Property'}</a></h4>
                        <p>${property.village || ''}, ${property.taluka?.name || ''}, ${property.district?.district_title || ''}, ${property.state?.state_title || ''}</p>
                        <div class="cart-btn d-flex justify-content-between">
                          <a href="${propertyDetailsUrl}">
                            <button type="button" class="theme-btn">View Details<span></span><span></span><span></span><span></span></button>
                          </a>
                          <button class="btn favourite-btn ${isFavourite ? 'active' : ''} rounded-circle" data-property-id="${property.id}">
                            <i class="icon-6"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              `;
            });

            // Close the row and type section
            htmlContent += `
                </div>
              </div>
            `;
          }
        } catch (e) {
          console.error(`Error loading ${type}:`, e);
        }
      }

      if (!htmlContent) {
        container.innerHTML = '<div class="text-center text-muted">No properties available at the moment.</div>';
        return;
      }

      container.innerHTML = htmlContent;

      // Add event listener for wishlist buttons
      document.querySelectorAll('.favourite-btn').forEach(button => {
        button.addEventListener('click', function() {
          const propertyId = this.getAttribute('data-property-id');
          const isActive = this.classList.contains('active');
          const url = `/wishlist${isActive ? '/' + propertyId : ''}`;
          const method = isActive ? 'DELETE' : 'POST';
          
          // Get CSRF token from meta tag
          const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

          fetch(url, {
            method: method,
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': csrfToken,
              'Accept': 'application/json'
            },
            body: !isActive ? JSON.stringify({ property_id: propertyId }) : undefined
          })
          .then(response => {
            if (response.ok) {
              return response.json();
            } else if (response.status === 401) {
              throw new Error('Unauthorized');
            } else {
              throw new Error('Network response was not ok');
            }
          })
          .then(data => {
            this.classList.toggle('active');
            // Update the userWishlistIds array
            if (isActive) {
              // Remove from wishlist
              userWishlistIds = userWishlistIds.filter(id => id != propertyId);
            } else {
              // Add to wishlist only if not already present
              if (!userWishlistIds.includes(parseInt(propertyId))) {
                userWishlistIds.push(parseInt(propertyId));
              }
            }
            // Ensure the wishlist array is always unique
            userWishlistIds = [...new Set(userWishlistIds)];
          })
          .catch(error => {
            console.error('Error updating wishlist:', error);
            if (error.message === 'Unauthorized') {
              alert('For Add To Wishlist, Please Login.');
            } else {
              alert('An error occurred. Please try again.');
            }
          });
        });
      });
    });

  </script>
@endpush