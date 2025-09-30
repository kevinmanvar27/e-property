// Global Add New Dropdown functionality
// This script provides a reusable "Add New" option for dropdowns

document.addEventListener('DOMContentLoaded', function() {
    // Initialize add new dropdown functionality
    initializeAddNewDropdowns();
});

function initializeAddNewDropdowns() {
    // Find all dropdowns with add new options
    const dropdowns = document.querySelectorAll('select[data-add-new="true"]');
    
    dropdowns.forEach(dropdown => {
        // Add event listener for change
        dropdown.addEventListener('change', function() {
            if (this.value === 'add_new') {
                const entityType = this.getAttribute('data-entity-type');
                openAddNewModal(entityType, this.id);
                // Reset the dropdown to placeholder value
                this.value = '';
            }
        });
        
        // Ensure "Add New" option exists
        ensureAddNewOptionExists(dropdown);
    });
}

function ensureAddNewOptionExists(dropdown) {
    const entityType = dropdown.getAttribute('data-entity-type');
    if (!entityType) return;
    
    // Check if "Add New" option already exists
    let addNewOption = Array.from(dropdown.options).find(option => option.value === 'add_new');
    if (!addNewOption) {
        const option = document.createElement('option');
        option.value = 'add_new';
        option.textContent = '+ Add New ' + entityType.charAt(0).toUpperCase() + entityType.slice(1);
        dropdown.appendChild(option);
    }
}

function openAddNewModal(entityType, dropdownId) {
    const modal = new bootstrap.Modal(document.getElementById('addNewModal'));
    const modalTitle = document.getElementById('addNewModalLabel');
    const entityTypeInput = document.getElementById('add-new-entity-type');
    const dropdownIdInput = document.getElementById('add-new-dropdown-id');
    const nameInput = document.getElementById('add-new-name');
    const descriptionInput = document.getElementById('add-new-description');
    const additionalFields = document.getElementById('add-new-additional-fields');
    
    // Reset form
    document.getElementById('add-new-form').reset();
    document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    
    // Set modal title and inputs
    modalTitle.textContent = 'Add New ' + entityType.charAt(0).toUpperCase() + entityType.slice(1);
    entityTypeInput.value = entityType;
    dropdownIdInput.value = dropdownId;
    nameInput.value = '';
    descriptionInput.value = '';
    additionalFields.innerHTML = '';
    
    // Add additional fields based on entity type
    addAdditionalFieldsForEntity(entityType, dropdownId);
    
    modal.show();
}

function addAdditionalFieldsForEntity(entityType, dropdownId) {
    const additionalFields = document.getElementById('add-new-additional-fields');
    
    switch (entityType) {
        case 'state':
            additionalFields.innerHTML = `
                <div class="mb-3">
                    <label for="add-new-country-id" class="form-label">Country <span class="text-danger">*</span></label>
                    <select class="form-select" id="add-new-country-id" name="country_id" required>
                        <option value="">Select Country</option>
                    </select>
                    <div class="invalid-feedback" id="add-new-country-id-error"></div>
                </div>
            `;
            populateCountrySelect('add-new-country-id');
            break;
            
        case 'district':
            additionalFields.innerHTML = `
                <div class="mb-3">
                    <label for="add-new-state-id" class="form-label">State <span class="text-danger">*</span></label>
                    <select class="form-select" id="add-new-state-id" name="state_id" required>
                        <option value="">Select State</option>
                    </select>
                    <div class="invalid-feedback" id="add-new-state-id-error"></div>
                </div>
            `;
            populateStateSelect('add-new-state-id');
            break;
            
        case 'city':
            additionalFields.innerHTML = `
                <div class="mb-3">
                    <label for="add-new-district-id" class="form-label">District <span class="text-danger">*</span></label>
                    <select class="form-select" id="add-new-district-id" name="districtid" required>
                        <option value="">Select District</option>
                    </select>
                    <div class="invalid-feedback" id="add-new-district-id-error"></div>
                </div>
                <div class="mb-3">
                    <label for="add-new-city-state-id" class="form-label">State <span class="text-danger">*</span></label>
                    <select class="form-select" id="add-new-city-state-id" name="state_id" required>
                        <option value="">Select State</option>
                    </select>
                    <div class="invalid-feedback" id="add-new-city-state-id-error"></div>
                </div>
            `;
            populateStateSelectForCity('add-new-city-state-id', 'add-new-district-id', dropdownId);
            break;
    }
}

function populateCountrySelect(selectId) {
    const countrySelect = document.querySelector('select[name="country_id"]') || 
                         document.querySelector('select[id="country_id"]');
    const newCountrySelect = document.getElementById(selectId);
    
    if (countrySelect && newCountrySelect) {
        // Copy options, excluding the "Add New" option if it exists
        Array.from(countrySelect.options).forEach(option => {
            if (option.value !== 'add_new') {
                const newOption = new Option(option.text, option.value);
                newCountrySelect.add(newOption);
            }
        });
        
        // Pre-select the current value if it exists
        if (countrySelect.value && countrySelect.value !== 'add_new') {
            newCountrySelect.value = countrySelect.value;
        }
    }
}

function populateStateSelect(selectId) {
    const stateSelect = document.querySelector('select[name="state_id"]') || 
                        document.querySelector('select[id="state_id"]');
    const newStateSelect = document.getElementById(selectId);
    
    if (stateSelect && newStateSelect) {
        // Copy options, excluding the "Add New" option if it exists
        Array.from(stateSelect.options).forEach(option => {
            if (option.value !== 'add_new') {
                const newOption = new Option(option.text, option.value);
                newStateSelect.add(newOption);
            }
        });
        
        // Pre-select the current value if it exists
        if (stateSelect.value && stateSelect.value !== 'add_new') {
            newStateSelect.value = stateSelect.value;
        }
    }
}

function populateStateSelectForCity(stateSelectId, districtSelectId, originalDropdownId) {
    const stateSelect = document.querySelector('select[name="state_id"]') || 
                        document.querySelector('select[id="state_id"]');
    const districtSelect = document.querySelector('select[name="district_id"]') || 
                          document.querySelector('select[id="district_id"]');
    const newCityStateSelect = document.getElementById(stateSelectId);
    const newDistrictSelect = document.getElementById(districtSelectId);
    
    if (stateSelect && newCityStateSelect) {
        // Copy options, excluding the "Add New" option if it exists
        Array.from(stateSelect.options).forEach(option => {
            if (option.value !== 'add_new') {
                const newOption = new Option(option.text, option.value);
                newCityStateSelect.add(newOption);
            }
        });
        
        // Pre-select the current state value if it exists
        if (stateSelect.value && stateSelect.value !== 'add_new') {
            newCityStateSelect.value = stateSelect.value;
            
            // Load districts for the selected state
            loadDistrictsForState(stateSelect.value, districtSelectId, originalDropdownId);
        }
        
        // Set state selection handler
        newCityStateSelect.addEventListener('change', function() {
            const stateId = this.value;
            if (stateId) {
                loadDistrictsForState(stateId, districtSelectId, originalDropdownId);
            } else {
                newDistrictSelect.innerHTML = '<option value="">Select District</option>';
            }
        });
    }
    
    // Pre-select the current district value if it exists
    if (districtSelect && districtSelect.value && districtSelect.value !== 'add_new') {
        // We'll set this after loading districts
        setTimeout(() => {
            if (districtSelect.value && districtSelect.value !== 'add_new') {
                newDistrictSelect.value = districtSelect.value;
            }
        }, 300);
    }
}

function loadDistrictsForState(stateId, districtSelectId, originalDropdownId) {
    const newDistrictSelect = document.getElementById(districtSelectId);
    const originalDistrictSelect = document.getElementById('district_id');
    
    if (stateId && newDistrictSelect) {
        // Determine the correct URL based on the current page
        const baseUrl = document.querySelector('meta[name="base-url"]')?.getAttribute('content') || '';
        let url = baseUrl + "/admin/locations/districts/" + stateId;
        
        // Check if we're on a plot page
        if (window.location.pathname.includes('/admin/plot/')) {
            url = baseUrl + "/admin/plot/districts/" + stateId;
        } else if (window.location.pathname.includes('/admin/land-jamin/')) {
            url = baseUrl + "/admin/land-jamin/districts/" + stateId;
        }
        
        fetch(url)
            .then(response => response.json())
            .then(data => {
                newDistrictSelect.innerHTML = '<option value="">Select District</option>';
                data.forEach(district => {
                    const option = document.createElement('option');
                    option.value = district.districtid;
                    option.textContent = district.district_title;
                    newDistrictSelect.appendChild(option);
                });
                
                // Pre-select the current district if it matches the state
                if (originalDistrictSelect && originalDistrictSelect.value && originalDistrictSelect.value !== 'add_new') {
                    // Check if the current district belongs to this state
                    const currentDistrictOption = Array.from(originalDistrictSelect.options).find(
                        option => option.value === originalDistrictSelect.value
                    );
                    
                    if (currentDistrictOption) {
                        // We could verify the district belongs to this state, but for simplicity,
                        // we'll just select it if it exists in the new dropdown
                        setTimeout(() => {
                            const matchingOption = Array.from(newDistrictSelect.options).find(
                                option => option.textContent === currentDistrictOption.textContent
                            );
                            if (matchingOption) {
                                newDistrictSelect.value = matchingOption.value;
                            }
                        }, 100);
                    }
                }
            })
            .catch(error => {
                console.error('Error loading districts:', error);
            });
    }
}

// Handle add new form submission
document.addEventListener('submit', function(e) {
    if (e.target.id === 'add-new-form') {
        e.preventDefault();
        
        const formData = new FormData(e.target);
        const entityType = document.getElementById('add-new-entity-type').value;
        const dropdownId = document.getElementById('add-new-dropdown-id').value;
        
        // Show loading state
        const submitButton = e.target.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;
        submitButton.disabled = true;
        submitButton.textContent = 'Adding...';
        
        // Clear previous errors
        document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        
        // Get the base URL from meta tag or fallback to relative path
        const baseUrl = document.querySelector('meta[name="base-url"]')?.getAttribute('content') || '';
        
        fetch(baseUrl + "/admin/locations/entities", {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.errors) {
                // Handle validation errors
                Object.keys(data.errors).forEach(field => {
                    const errorElement = document.getElementById('add-new-' + field + '-error');
                    if (errorElement) {
                        errorElement.textContent = data.errors[field][0];
                        document.getElementById('add-new-' + field).classList.add('is-invalid');
                    }
                });
            } else if (data.success) {
                // Success - add new entity to the dropdown and select it
                const dropdown = document.getElementById(dropdownId);
                const option = document.createElement('option');
                let entityId, entityName;
                
                switch (entityType) {
                    case 'state':
                        entityId = data.entity.state_id;
                        entityName = data.entity.state_title;
                        break;
                    case 'district':
                        entityId = data.entity.districtid;
                        entityName = data.entity.district_title;
                        break;
                    case 'city':
                        entityId = data.entity.id;
                        entityName = data.entity.name;
                        break;
                }
                
                option.value = entityId;
                option.textContent = entityName;
                option.selected = true;
                
                // Remove any existing option with the same value to prevent duplicates
                Array.from(dropdown.options).forEach(existingOption => {
                    if (existingOption.value === option.value) {
                        dropdown.remove(existingOption.index);
                    }
                });
                
                // Insert the new option before the "Add New" option
                const addNewOptionIndex = Array.from(dropdown.options).findIndex(option => option.value === 'add_new');
                if (addNewOptionIndex !== -1) {
                    dropdown.insertBefore(option, dropdown.options[addNewOptionIndex]);
                } else {
                    dropdown.appendChild(option);
                }
                
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('addNewModal'));
                modal.hide();
                
                // Trigger change event for cascading dropdowns if needed
                const event = new Event('change');
                dropdown.dispatchEvent(event);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        })
        .finally(() => {
            // Reset loading state
            submitButton.disabled = false;
            submitButton.textContent = originalText;
        });
    }
});