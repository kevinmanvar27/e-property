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
                <li>{{__('Properties')}}</li>
                <li id="current-property-type">Shop</li>
            </ul>
        </div>
    </section>
    <!-- page-title end -->


    <!-- shop-page-section -->
    <section class="shop-page-section pb_80">
        <div class="large-container">
            <div class="row clearfix">
                <div class="col-lg-3 col-md-12 col-sm-12 sidebar-side">
                    <div class="shop-sidebar">
                        <!-- <div class="search-widget sidebar-widget pb_40 mb_30">
                            <form method="post" action="shop.html">
                                <div class="form-group">
                                    <input type="search" name="search-field" placeholder="iPhone 14 pro" required>
                                    <button type="submit"><i class="icon-2"></i></button>
                                </div>
                            </form>
                        </div> -->
                        <div class="country-widget sidebar-widget pb_40 mb_30" style="display: none;">
                            <div class="widget-title mb_30">
                                <h4>Select Country</h4>
                            </div>
                            <div class="widget-content">
                                <ul class="category-list clearfix" id="country-list">
                                </ul>
                            </div>
                        </div>
                        <div class="state-widget sidebar-widget pb_40 mb_30">
                            <div class="widget-title mb_30">
                                <h4>Select State</h4>
                            </div>
                            <div class="widget-content">
                                <ul class="category-list clearfix" id="state-list">
                                    <!-- State checkboxes will be appended here -->
                                </ul>
                            </div>
                        </div>
                        <div class="district-widget sidebar-widget pb_40 mb_30" id="district-widget" style="display: none;">
                            <div class="widget-title mb_30">
                                <h4>Select District</h4>
                            </div>
                            <div class="widget-content">
                                <ul class="district-list clearfix" id="district-list">
                                    <!-- State checkboxes will be appended here -->
                                </ul>
                            </div>
                        </div>
                        <div class="city-widget sidebar-widget pb_40 mb_30" id="city-widget" style="display: none;">
                            <div class="widget-title mb_30">
                                <h4>Select City</h4>
                            </div>
                            <div class="widget-content">
                                <ul class="city-list clearfix" id="city-list">
                                    <!-- State checkboxes will be appended here -->
                                </ul>
                            </div>
                        </div>
                        <div class="property-type sidebar-widget pb_40 mb_30" id="property-type">
                            <div class="widget-title mb_30">
                                <h4>Property Type</h4>
                            </div>
                            <div class="widget-content">
                                <ul class="property-type-list clearfix" id="property-type-list">
                                    <li>
                                        <div class="check-box">
                                            <input class="check property-type-checkbox" type="checkbox" id="shop" value="shop">
                                            <label for="shop">Shop</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="check-box">
                                            <input class="check property-type-checkbox" type="checkbox" id="land_jamin" value="landJamin">
                                            <label for="land_jamin">Land Jamin</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="check-box">
                                            <input class="check property-type-checkbox" type="checkbox" id="plot" value="plot">
                                            <label for="plot">Plot</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="check-box">
                                            <input class="check property-type-checkbox" type="checkbox" id="shad" value="shad">
                                            <label for="shad">Shad</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="check-box">
                                            <input class="check property-type-checkbox" type="checkbox" id="house" value="house">
                                            <label for="house">House</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-12 col-sm-12 content-side">
                    <div class="our-shop">
                        <div class="item-shorting">
                            <div class="left-column">
                                <div class="text"><p>Showing <span>1-10</span> of <span>0</span> results</p></div>
                            </div>
                            <div class="right-column">
                                <div class="short-box mr_30">
                                    <p>Results Per Page:</p>
                                    <div class="select-box">
                                        <select class="wide" id="per-page-select">
                                            <option value="2">2</option>
                                            <option value="10" selected>10</option>
                                            <option value="20">20</option>
                                            <option value="30">30</option>
                                            <option value="50">50</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="short-box mr_30">
                                    <p>Sort:</p>
                                    <div class="select-box">
                                        <select class="wide">
                                            <option data-type="shop">Shop</option>
                                            <option data-type="landJamin">Land Jamin</option>
                                            <option data-type="plot">Plot</option>
                                            <option data-type="shad">Shad</option>
                                            <option data-type="house">House</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="menu-box">
                                    <p>Show:</p>
                                    <button class="list-view on mr_10"><img src="{{ asset('user/assets/images/icons/icon-5.png') }}" alt=""></button>
                                    <button class="grid-view"><img src="{{ asset('user/assets/images/icons/icon-4.png') }}" alt=""></button>
                                </div>
                            </div>
                        </div>
                        <div class="wrapper list">
                            <!-- Grid container -->
                            <div class="shop-grid-content">
                                <div class="inner-container clearfix" id="property-container-grid">
                                    <!-- Ajax inserts grid items here -->
                                </div>
                            </div>

                            <!-- List container -->
                            <div class="shop-list-content">
                                <div class="inner-container clearfix" id="property-container-list">
                                    <!-- Ajax inserts list items here -->
                                </div>
                            </div>
                        </div>
                        <div class="pagination-wrapper centred pt_20" id="pagination-container">
                            <ul class="pagination clearfix" id="pagination-list">
                                <!-- Pagination will be dynamically generated here -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- shop-page-section end -->
     
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Set up CSRF token for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            const apiUrls = {
                shop: '/api/shop',
                landJamin: '/api/land-jamin',
                plot: '/api/plot',
                shad: '/api/shad',
                house: '/api/house',
            };

            const propertyDetailsBaseUrl = "{{ url('property-details') }}";
            const wrapper = $('div.wrapper');
            let currentType = 'shop';
            let viewType = localStorage.getItem('viewMode') || 'list';
            let currentPage = 1;
            let currentPerPage = 10;
            let userWishlistIds = []; // Initialize the wishlist array

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

            const selectedCountries = new Set();
            const selectedStates = new Set();
            const selectedDistricts = new Set();
            const selectedCities = new Set();

            function getFilterParams() {
                return {
                    country_ids: Array.from(selectedCountries).join(','),
                    state_ids: Array.from(selectedStates).join(','),
                    district_ids: Array.from(selectedDistricts).join(','),
                    city_ids: Array.from(selectedCities).join(','),
                    page: currentPage,
                    per_page: currentPerPage
                };
            }
            
            function updateBreadcrumb() {
                const formattedType = currentType.charAt(0).toUpperCase() + currentType.slice(1);
                $('#current-property-type').text(formattedType);
            }

            function updatePaginationInfo(paginationData) {
                const from = paginationData.from || 0;
                const to = paginationData.to || 0;
                const total = paginationData.total || 0;
                
                $('.text span:first').text(`${from}-${to}`);
                $('.text span:last').text(total);
            }

            function renderPagination(paginationData) {
                const paginationList = $('#pagination-list');
                paginationList.empty();
                
                if (paginationData.last_page <= 1) {
                    $('#pagination-container').hide();
                    return;
                }
                
                $('#pagination-container').show();
                
                // Previous button
                if (paginationData.current_page > 1) {
                    paginationList.append(`<li><a href="#" data-page="${paginationData.current_page - 1}"><i class="fal fa-angle-left"></i></a></li>`);
                }
                
                // Page numbers
                let startPage = Math.max(1, paginationData.current_page - 2);
                let endPage = Math.min(paginationData.last_page, paginationData.current_page + 2);
                
                if (startPage > 1) {
                    paginationList.append(`<li><a href="#" data-page="1">1</a></li>`);
                    if (startPage > 2) {
                        paginationList.append(`<li><span>...</span></li>`);
                    }
                }
                
                for (let i = startPage; i <= endPage; i++) {
                    if (i === paginationData.current_page) {
                        paginationList.append(`<li><a href="#" class="current" data-page="${i}">${i}</a></li>`);
                    } else {
                        paginationList.append(`<li><a href="#" data-page="${i}">${i}</a></li>`);
                    }
                }
                
                if (endPage < paginationData.last_page) {
                    if (endPage < paginationData.last_page - 1) {
                        paginationList.append(`<li><span>...</span></li>`);
                    }
                    paginationList.append(`<li><a href="#" data-page="${paginationData.last_page}">${paginationData.last_page}</a></li>`);
                }
                
                // Next button
                if (paginationData.current_page < paginationData.last_page) {
                    paginationList.append(`<li><a href="#" data-page="${paginationData.current_page + 1}"><i class="fal fa-angle-right"></i></a></li>`);
                }
            }

            function loadProperties() {
                const containerId = viewType === 'grid' ? '#property-container-grid' : '#property-container-list';
                const otherContainer = viewType === 'grid' ? '#property-container-list' : '#property-container-grid';

                $(containerId).empty();
                $(otherContainer).hide();
                $(containerId).show();

                console.log('Loading properties with wishlist:', userWishlistIds);

                const filters = getFilterParams();
                const query = $.param(filters);
                const url = apiUrls[currentType] + (query ? `?${query}` : '');

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (!response.data || !response.data.data.length) {
                            $(containerId).html('<p class="text-center text-danger">No properties found.</p>');
                            $('#pagination-container').hide();
                            updatePaginationInfo({from: 0, to: 0, total: 0});
                            return;
                        }

                        // Update pagination info
                        updatePaginationInfo({
                            from: response.data.from,
                            to: response.data.to,
                            total: response.data.total
                        });
                        
                        // Render pagination
                        renderPagination(response.data);
                        
                        response.data.data.forEach(property => {
                            const html = viewType === 'grid' ? renderGrid(property) : renderList(property);
                            $(containerId).append(html);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error loading properties:", error);
                        $(containerId).html('<p class="text-center text-danger">Error loading properties. Please try again.</p>');
                    }
                });
            }

            function renderGrid(property) {
                let imageUrl = '{{ asset("user/assets/images/shop/shop-10.png") }}'; // default image
                const isFavourite = userWishlistIds.includes(parseInt(property.id));
                console.log('Rendering grid item:', { propertyId: property.id, isFavourite, userWishlistIds });
                if (property.photos) {
                    try {
                        // Parse JSON string into array
                        const photosArray = JSON.parse(property.photos);
                        if (Array.isArray(photosArray) && photosArray.length > 0) {
                            imageUrl = '{{ asset("storage/photos") }}/' + photosArray[0]; // first photo
                        }
                    } catch (e) {
                        console.error("Invalid photo format:", property.photos);
                    }
                }
                
                return `
                <div class="shop-block-two">
                    <div class="inner-box">
                        <div class="image-box">
                            <ul class="option-list">
                                <li>
                                </li>
                            </ul>
                            <figure class="image"><img src="${imageUrl}" alt="${property.owner_name || ''}"></figure>
                        </div>
                        <div class="lower-content">
                            <span class="product-stock"><img src="{{ asset('user/assets/images/icons/icon-1.png') }}" alt=""> ${property.status || ''}</span>
                            <h4><a href="shop-details.html">${property.owner_name || ''}</a></h4>
                            <p>${property.village || ''}, ${property.taluka?.name || ''}, ${property.district?.district_title || ''}, ${property.state?.state_title || ''}</p>
                            <div class="cart-btn d-flex justify-content-between">
                                <a href="${propertyDetailsBaseUrl}/${property.id}">
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

            function renderList(property) {
                let imageUrl = '{{ asset("user/assets/images/shop/shop-10.png") }}'; // default image
                const isFavourite = userWishlistIds.includes(parseInt(property.id));
                console.log('Rendering list item:', { propertyId: property.id, isFavourite, userWishlistIds });
                console.log(property);
                if (property.photos) {
                    try {
                        // Parse JSON string into array
                        const photosArray = JSON.parse(property.photos);
                        if (Array.isArray(photosArray) && photosArray.length > 0) {
                            imageUrl = '{{ asset("storage/photos") }}/' + photosArray[0]; // first photo
                        }
                    } catch (e) {
                        console.error("Invalid photo format:", property.photos);
                    }
                }
                return `
                <div class="shop-block-seven">
                    <div class="inner-box">
                        <div class="image-box">
                            <figure class="image"><img src="${imageUrl}" alt="${property.owner_name || ''}"></figure>
                        </div>
                        <div class="content-box">
                            <span class="product-stock"><img src="{{ asset('user/assets/images/icons/icon-1.png') }}" alt=""> ${property.status || ''}</span>
                            <h4><a href="shop-details.html">${property.owner_name || ''}</a></h4>
                            <p class="mb_30">${property.village || ''}, ${property.taluka?.name || ''}, ${property.district?.district_title || ''}, ${property.state?.state_title || ''}</p>
                            <div class="cart-btn d-flex align-items-center">
                                <a href="${propertyDetailsBaseUrl}/${property.id}">
                                    <button type="button" class="theme-btn">View Details<span></span><span></span><span></span><span></span></button>
                                </a>
                                <a href="#" class="ms-3">
                                    <button class="btn favourite-btn ${isFavourite ? 'active' : ''} rounded-circle" data-property-id="${property.id}">
                                        <i class="icon-6"></i>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>`;
            }

            wrapper.removeClass('list grid').addClass(viewType);
            loadProperties();

            // Handle pagination clicks
            $(document).on('click', '#pagination-list a', function(e) {
                e.preventDefault();
                const page = $(this).data('page');
                if (page) {
                    currentPage = page;
                    loadProperties();
                }
            });

            // Handle per page selection
            $('#per-page-select').on('change', function() {
                currentPerPage = $(this).val();
                currentPage = 1; // Reset to first page when changing per page
                loadProperties();
            });

            $('button.list-view').on('click', function() {
                viewType = 'list';
                wrapper.removeClass('grid').addClass('list');
                localStorage.setItem('viewMode', viewType);
                loadProperties();
            });

            $('button.grid-view').on('click', function() {
                viewType = 'grid';
                wrapper.removeClass('list').addClass('grid');
                localStorage.setItem('viewMode', viewType);
                loadProperties();
            });

            $('a[data-type]').on('click', function() {
                currentType = $(this).data('type');
                currentPage = 1; // Reset to first page when changing property type
                updateBreadcrumb();
                loadProperties();
            });

            $('select').not('#per-page-select').on('change', function() {
                currentType = $(this).find(':selected').data('type');
                currentPage = 1; // Reset to first page when changing property type
                updateBreadcrumb();
                loadProperties();
            });

            $(document).on('change', '.property-type-checkbox', function() {
                $('.property-type-checkbox').not(this).prop('checked', false);
                currentType = $(this).val();
                currentPage = 1; // Reset to first page when changing property type
                updateBreadcrumb();
                loadProperties();
            });
            
            function reloadWithDelay() {
                clearTimeout(window._filterTimer);
                window._filterTimer = setTimeout(function() {
                    currentPage = 1; // Reset to first page when applying filters
                    loadProperties();
                }, 300);
            }

            fetch("/api/countries")
                .then(res => res.json())
                .then(data => {
                    const $countryList = $("#country-list");
                    data.data.forEach((c, i) => {
                        const id = c.country_id;
                        const checkboxId = `countryCheckbox${i+1}`;
                        const checked = i === 0 ? 'checked' : '';
                        $countryList.append(`
                            <li>
                                <div class="check-box">
                                    <input class="check country-checkbox" type="checkbox" id="${checkboxId}" value="${id}" ${checked}>
                                    <label for="${checkboxId}">${c.country_name}</label>
                                </div>
                            </li>`);
                        if (i === 0) selectedCountries.add(id);
                        if (i === 0) fetchStates(id);
                    });
                });

            $(document).on('change', '.country-checkbox', function() {
                const id = $(this).val();
                if ($(this).is(':checked')) { selectedCountries.add(id); fetchStates(id); }
                else { selectedCountries.delete(id); $(`#state-list li[data-country-id="${id}"]`).remove(); }
                reloadWithDelay();
            });

            $(document).on('change', '.state-checkbox', function() {
                const id = $(this).val();
                if ($(this).is(':checked')) { selectedStates.add(id); fetchDistricts(id); }
                else { selectedStates.delete(id); $(`#district-list li[data-state-id="${id}"]`).remove(); }
                reloadWithDelay();
            });

            $(document).on('change', '.district-checkbox', function() {
                const id = $(this).val();
                if ($(this).is(':checked')) { selectedDistricts.add(id); fetchCities(id); }
                else { selectedDistricts.delete(id); $(`#city-list li[data-district-id="${id}"]`).remove(); }
                reloadWithDelay();
            });

            $(document).on('change', '.city-checkbox', function() {
                const id = $(this).val();
                $(this).is(':checked') ? selectedCities.add(id) : selectedCities.delete(id);
                reloadWithDelay();
            });

            function fetchStates(countryId) {
                fetch(`/api/locations/states/${countryId}`)
                    .then(res => res.json())
                    .then(data => {
                        const $stateList = $("#state-list");
                        data.data.forEach((s, i) => {
                            const checkboxId = `stateCheckbox${countryId}_${i+1}`;
                            if ($stateList.find(`#${checkboxId}`).length) return; // avoid duplicates
                            $stateList.append(`
                                <li data-country-id="${countryId}">
                                    <div class="check-box">
                                        <input class="check state-checkbox" type="checkbox" id="${checkboxId}" value="${s.state_id}">
                                        <label for="${checkboxId}">${s.state_title}</label>
                                    </div>
                                </li>`);
                        });
                    });
            }

            function fetchDistricts(stateId) {
                fetch(`/api/locations/districts/${stateId}`)
                    .then(res => res.json())
                    .then(data => {
                        const $districtList = $("#district-list");
                        data.data.forEach((d, i) => {
                            const checkboxId = `districtCheckbox${stateId}_${i+1}`;
                            if ($districtList.find(`#${checkboxId}`).length) return;
                            $districtList.append(`
                                <li data-state-id="${stateId}">
                                    <div class="check-box">
                                        <input class="check district-checkbox" type="checkbox" id="${checkboxId}" value="${d.districtid}">
                                        <label for="${checkboxId}">${d.district_title}</label>
                                    </div>
                                </li>`);
                        });
                        $("#district-widget").show();
                    });
            }

            function fetchCities(districtId) {
                fetch(`/api/locations/cities/${districtId}`)
                    .then(res => res.json())
                    .then(data => {
                        const $cityList = $("#city-list");
                        data.data.forEach((c, i) => {
                            const checkboxId = `cityCheckbox${districtId}_${i+1}`;
                            if ($cityList.find(`#${checkboxId}`).length) return;
                            $cityList.append(`
                                <li data-district-id="${districtId}">
                                    <div class="check-box">
                                        <input class="check city-checkbox" type="checkbox" id="${checkboxId}" value="${c.id}">
                                        <label for="${checkboxId}">${c.name}</label>
                                    </div>
                                </li>`);
                        });
                        $("#city-widget").show();
                    });
            }
            $(document).on('click', '.favourite-btn', function() {
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