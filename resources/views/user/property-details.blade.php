@extends('user.layouts.app')

@section('content') 
    
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

    <!-- page-title -->
    <section class="page-title pt_20 pb_18">
        <div class="large-container">
            <ul class="bread-crumb clearfix">
                <li><a href="index.html">Home</a></li>
                <li>Property Details</li>
            </ul>
        </div>
    </section>
    <!-- page-title end -->


    <!-- shop-details -->
    <section class="shop-details pb_70">
        <div class="large-container">
            <div class="product-details-content mb_70 " id="product-details">
                <!-- Content will be loaded dynamically by JavaScript -->
            </div>
        </div>
    </section>
    <!-- shop-details end -->

    <!-- shop-two -->

    <!-- shop-two -->
    <section class="shop-two pb_50">
        <div class="large-container">
            <div class="sec-title">
                <h2>You may also like these</h2>
            </div>
            <div class="shop-carousel owl-carousel owl-theme owl-dots-none owl-nav-none" id="related-properties-carousel">
                <!-- Related properties will be loaded here dynamically -->
                <div class="text-center">Loading related properties...</div>
            </div>
        </div>
    </section>
    <div id="containerId"></div>
    <!-- shop-two end -->

@endsection

@push('scripts')
    <script>
        let userWishlistIds = []; 
        $(document).ready(function() {
            let url = window.location.href;
            let id = url.substring(url.lastIndexOf('/') + 1);

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

            $.ajax({
                url: '/property-details/' + id,
                type: 'GET',
                success: function(property) {
                    console.log(property);
                    
                    // Process photos array - now properly formatted from backend
                    let photos = property.photos || [];
                    
                    // Generate image HTML
                    let imageHtml = '';
                    
                    // Only generate gallery if there are photos
                    if (photos.length > 0) {
                        // Main image slider
                        imageHtml += '<div class="bxslider"><div class="slider-content"><div class="image-inner"><div class="image-box" id="main-image-container">';
                        
                        // Generate main images (all images, but only first one visible by default)
                        for (let i = 0; i < photos.length; i++) {
                            const displayStyle = i === 0 ? 'block' : 'none';
                            const imageUrl = photos[i].startsWith('http') ? photos[i] : '/storage/photos/' + photos[i];
                            imageHtml += `<figure class="image main-image-item" style="display: ${displayStyle};" data-index="${i}"><a href="${imageUrl}" class="lightbox-image" data-fancybox="gallery"><img src="${imageUrl}" alt="${property.owner_name || ''}"></a></figure>`;
                        }
                        
                        imageHtml += '</div><div class="slider-pager"><ul class="thumb-box" id="thumbnail-container">';
                        
                        // Generate thumbnails
                        for (let i = 0; i < photos.length; i++) {
                            const activeClass = i === 0 ? 'active' : '';
                            const imageUrl = photos[i].startsWith('http') ? photos[i] : '/storage/photos/' + photos[i];
                            // Using generic thumbnail path, in real implementation you might want to generate thumbnails
                            const thumbUrl = imageUrl; // You might want to use a thumbnail version here
                            imageHtml += `
                                <li>
                                    <a class="thumb-item ${activeClass}" data-slide-index="${i}" href="#" data-image-index="${i}">
                                        <figure><img src="${thumbUrl}" alt="${property.owner_name || ''}"></figure>
                                    </a>
                                </li>
                            `;
                        }
                        
                        imageHtml += '</ul></div></div></div></div>';
                    } else {
                        // If no photos, show a default image or nothing
                        imageHtml = '<div class="bxslider"><div class="slider-content"><div class="image-inner"><div class="image-box" id="main-image-container"><figure class="image main-image-item" style="display: block;"><img src="/user/assets/images/shop/shop-details-1.png" alt="No image available"></figure></div></div></div></div>';
                    }

                    //amenities goes here
                    let amenitiesHtml = '<div class="size-box mb_40"><h6>Amenities<span>*</span></h6><ul class="size-list">';
                    if (property.amenities && property.amenities.length > 0) {
                        property.amenities.forEach((name, index) => {
                            amenitiesHtml += `
                                <li>
                                    <div class="check-box">
                                        <input class="check" type="radio" name="amenities">
                                        <label for="amenity${index}">${name}</label>
                                    </div>
                                </li>
                            `;
                        });
                    } else {
                        amenitiesHtml += '<li>No amenities available</li>';
                    }
                    amenitiesHtml += '</ul></div>';
                    // amenities end
                    
                    // Update content details
                    let html = `
                        <div class="row clearfix">
                            <div class="col-lg-6 col-md-12 col-sm-12 image-column">
                                ${imageHtml}
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 content-column">
                                <div class="content-box ml_30">
                                    <span class="upper-text">${toTitleCase(property.property_type || '')}</span>
                                    <h2>${property.apartment_name || property.owner_name}</h2>
                                    <div class="text-box mb_30">
                                        <p>${property.first_line || ''}<br>${property.second_line || ''}</p>
                                        <p>${property.village || ''}, ${property.taluka?.name || ''}, ${property.district?.district_title || ''}, ${property.state?.state_title || ''}</p>
                                    </div>
                                    <ul class="discription-box mb_30 clearfix">
                                        <li><strong>Owner :</strong> ${property.owner_name || ''}</li>
                                        <li><strong>Contact Number :</strong> ${property.contact_number || ''}</li>
                                        <li><strong>Availability :</strong><span class="product-stock"><img src="/user/assets/images/icons/icon-1.png" alt=""> ${toTitleCase(property.status || '')}</span></li>
                                    </ul>
                                    <div class="size-box mb_40">
                                        <h6>Details<span>*</span></h6>
                                        <ul class="size-list">
                                            <li><strong>Size:</strong> ${property.size || 'N/A'}</li>
                                            ${property.bhk ? `<li><strong>BHK:</strong> ${property.bhk}</li>` : ''}
                                            ${property.apartment_floor ? `<li><strong>Floor:</strong> ${property.apartment_floor}</li>` : ''}
                                        </ul>
                                    </div>
                                    <div class="size-box mb_40">
                                        ${amenitiesHtml}
                                    </div>
                                    <ul class="discription-box mb_30 clearfix">
                                        <li><strong>State :</strong> ${property.state?.state_title || ''}</li>
                                        <li><strong>District :</strong> ${property.district?.district_title || ''}</li>
                                        <li><strong>Taluka :</strong> ${property.taluka?.name || ''}</li>
                                        ${property.pincode ? `<li><strong>Pincode:</strong> ${property.pincode}</li>` : ''}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#product-details').html(html);
                    
                    // Add event handlers for thumbnail clicks AFTER the HTML is inserted
                    $('#thumbnail-container').on('click', '.thumb-item', function(e) {
                        e.preventDefault();
                        const imageIndex = $(this).data('image-index');
                        
                        // Remove active class from all thumbnails and add to clicked one
                        $('.thumb-item').removeClass('active');
                        $(this).addClass('active');
                        
                        // Hide all main images and show the selected one
                        $('.main-image-item').hide();
                        $(`.main-image-item[data-index="${imageIndex}"]`).show();
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error loading property details:', error);
                    // Handle error case - maybe show a message to the user
                }
            });
        });
        $(document).ready(function() {
            // Only run AJAX enhancement if we have a property
            <?php if(isset($property)): ?>
            // Load related properties
            loadRelatedProperties('<?php echo $property->property_type; ?>', <?php echo $property->id; ?>);
            
            // Add event handlers for thumbnail clicks
            $('#thumbnail-container').on('click', '.thumb-item', function(e) {
                e.preventDefault();
                const imageIndex = $(this).data('image-index');
                
                // Remove active class from all thumbnails and add to clicked one
                $('.thumb-item').removeClass('active');
                $(this).addClass('active');
                
                // Hide all main images and show the selected one
                $('.main-image-item').hide();
                $(`.main-image-item[data-index="${imageIndex}"]`).show();
            });
            <?php endif; ?>
            
            function loadRelatedProperties(propertyType, currentPropertyId) {
                // Map property types to API endpoints
                const apiEndpoints = {
                    'land_jamin': '/api/land-jamin',
                    'plot': '/api/plot',
                    'shad': '/api/shad',
                    'shop': '/api/shop',
                    'house': '/api/house'
                };

                // Fetch user's wishlist on page load
                $.ajax({
                    url: '/wishlist',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log('Wishlist loaded:', response);
                        // Ensure no duplicates in the wishlist array
                        userWishlistIds = [...new Set(response.wishlist || [])];
                        // Reload properties to update the favorite buttons
                        // loadProperties();
                    },
                    error: function(xhr, status, error) {
                        console.error("Error loading wishlist:", error);
                        console.log("Response:", xhr);
                        // Try to get more details about the error
                        if (xhr.responseJSON) {
                            console.log("Error details:", xhr.responseJSON);
                        }
                    }
                });
                
                const apiEndpoint = apiEndpoints[propertyType] || '/api/land-jamin';
                
                $.ajax({
                    url: apiEndpoint,
                    type: 'GET',
                    data: {
                        per_page: 6 // Load 6 related properties
                    },
                    success: function(response) {
                        if (response.data && response.data.data) {
                            // Filter out the current property
                            const relatedProperties = response.data.data.filter(property => property.id != currentPropertyId).slice(0, 5);
                            
                            const carousel = $('#related-properties-carousel');
                            carousel.empty();
                            
                            // Add each property to the carousel
                            relatedProperties.forEach(property => {
                                const propertyHtml = renderRelatedProperty(property);
                                carousel.append(propertyHtml);
                            });
                            
                            // Destroy existing carousel instance if it exists
                            if ($('.shop-carousel').hasClass('owl-loaded')) {
                                $('.shop-carousel').trigger('destroy.owl.carousel');
                            }
                            
                            // Reinitialize the carousel
                            $('.shop-carousel').owlCarousel({
                                loop: relatedProperties.length > 1,
                                margin: 30,
                                nav: false,
                                dots: false,
                                autoplay: true,
                                autoplayTimeout: 3000,
                                autoplayHoverPause: true,
                                responsive: {
                                    0: {
                                        items: 1
                                    },
                                    600: {
                                        items: 2
                                    },
                                    1000: {
                                        items: 4
                                    }
                                }
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading related properties:', error);
                        $('#related-properties-carousel').html('<div class="text-center text-danger">Failed to load related properties.</div>');
                    }
                });
            }
            
            function renderRelatedProperty(property) {
                // Get the first photo or use a default image
                const isFavourite = userWishlistIds.includes(parseInt(property.id));
                let imageUrl = '/user/assets/images/shop/shop-10.png';
                if (property.photos) {
                    try {
                        // Parse the photos JSON string
                        const photos = JSON.parse(property.photos);
                        if (Array.isArray(photos) && photos.length > 0) {
                            imageUrl = '/storage/photos/' + photos[0];
                        }
                    } catch (e) {
                        // If parsing fails, check if it's already an array
                        if (Array.isArray(property.photos) && property.photos.length > 0) {
                            imageUrl = '/storage/photos/' + property.photos[0];
                        }
                    }
                }
                
                // Format property type for display
                const propertyTypeFormatted = property.property_type.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
                
                return `
                <div class="shop-block-two">
                    <div class="inner-box">
                    <div class="image-box">
                            <figure class="image"><img src="${imageUrl}" alt="${property.owner_name || ''}"></figure>
                        </div>
                        <div class="lower-content">
                            <span class="product-stock"><img src="/user/assets/images/icons/icon-1.png" alt=""> ${property.status || ''}</span>
                            <h4><a href="/property-details/${property.id}">${property.owner_name || ''}</a></h4>
                            <p>${property.village || ''}, ${property.taluka?.name || ''}, ${property.district?.district_title || ''}, ${property.state?.state_title || ''}</p>
                            <div class="cart-btn d-flex justify-content-between">
                                <a href="/property-details/${property.id}">
                                    <button type="button" class="theme-btn">View Details<span></span><span></span><span></span><span></span></button>
                                </a>
                                <button class="btn favourite-btn ${isFavourite ? 'active' : ''} rounded-circle" data-property-id="${property.id}">
                                    <i class="icon-6"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>`;
            }

            $(document).on('click', '.favourite-btn', function() {
                // CSRF token setup for all AJAX requests
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                const btn = $(this);
                const propertyId = btn.data('property-id');
                const isActive = btn.hasClass('active');
                const url = `/wishlist${isActive ? '/' + propertyId : ''}`;
                const method = isActive ? 'DELETE' : 'POST';

                console.log('Favorite button clicked:', { propertyId, isActive, url, method });

                $.ajax({
                    url: url,
                    type: method,
                    data: !isActive ? { property_id: propertyId } : {},
                    success: function(res) {
                        console.log('Wishlist update success:', res);
                        btn.toggleClass('active');
                        // Update the userWishlistIds array
                        if (isActive) {
                            // Remove from wishlist (remove all instances in case of duplicates)
                            userWishlistIds = userWishlistIds.filter(id => id != propertyId);
                        } else {
                            // Add to wishlist only if not already present
                            if (!userWishlistIds.includes(parseInt(propertyId))) {
                                userWishlistIds.push(parseInt(propertyId));
                            }
                        }
                        // Ensure the wishlist array is always unique
                        userWishlistIds = [...new Set(userWishlistIds)];
                        console.log('Updated wishlist IDs:', userWishlistIds);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error updating wishlist:", error);
                        console.log("Response:", xhr);
                        // Try to get more details about the error
                        if (xhr.responseJSON) {
                            console.log("Error details:", xhr.responseJSON);
                        }
                        // Show an error message to the user
                        alert('For Add To Wishlist, Please Login.');
                    }
                });
            });
        });
    </script>
@endpush