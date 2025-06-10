<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Pickup - B Laundry</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container navbar-container">
            <a href="{{ route('home') }}" class="logo">
                <i class="fas fa-tshirt"></i>
                B Laundry
            </a>
            <ul class="nav-links">
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('orders') }}">My Orders</a></li>
                <li><a href="{{ route('schedule.create') }}" class="active">Schedule Pickup</a></li>
                <li><a href="{{ route('payment.methods') }}"><i class="fas fa-credit-card"></i> Payment Methods</a></li>
                <li><a href="{{ route('support') }}">Support</a></li>
            </ul>
            <div class="user-menu">
                <div class="dropdown">
                    <div class="user-avatar">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="dropdown-content">
                        <a href="{{ route('profile.show') }}"><i class="fas fa-user"></i> My Profile</a>
                        <a href="{{ route('settings') }}"><i class="fas fa-cog"></i> Settings</a>
                        <a href="{{ route('payment.methods') }}"><i class="fas fa-credit-card"></i> Payment Methods</a>
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" style="background: none; border: none; color: inherit; cursor: pointer; width: 100%; text-align: left; padding: 0.5rem 1rem;">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Dashboard Layout -->
    <div class="dashboard">
        <!-- Sidebar -->
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="{{ route('orders') }}"><i class="fas fa-clipboard-list"></i> My Orders</a></li>
                <li><a href="{{ route('schedule.create') }}" class="active"><i class="fas fa-calendar-alt"></i> Schedule Pickup</a></li>
                <li><a href="{{ route('addresses') }}"><i class="fas fa-map-marker-alt"></i> My Addresses</a></li>
                <li><a href="{{ route('payment.methods') }}"><i class="fas fa-credit-card"></i> Payment Methods</a></li>
                <li><a href="{{ route('profile.show') }}"><i class="fas fa-user"></i> My Profile</a></li>
                <li><a href="{{ route('support') }}"><i class="fas fa-headset"></i> Support</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content schedule-content">
            <div class="page-header">
                <h1 class="page-title"><i class="fas fa-calendar-plus"></i> Schedule New Pickup</h1>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Check if user has addresses -->
            @if($pickupAddresses->isEmpty() || $deliveryAddresses->isEmpty())
                <div class="alert alert-warning">
                    <p><strong>You need addresses to schedule a pickup!</strong></p>
                    <p>Please add at least one pickup address and one delivery address.</p>
                    <a href="{{ route('addresses.add') }}" class="btn btn-primary">Add Address</a>
                </div>
            @else
                <div class="schedule-layout">
                    <form class="schedule-form" action="{{ route('schedule.store') }}" method="POST">
                        @csrf
                        
                        <!-- Pickup Details Section -->
                        <div class="form-section">
                            <h2 class="section-title"><i class="fas fa-truck-pickup"></i> Pickup Details</h2>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="pickup-address">Pickup Address</label>
                                    <select id="pickup-address" name="pickup_address_id" class="form-control" required>
                                        <option value="">Select an address</option>
                                        @foreach($pickupAddresses as $address)
                                            <option value="{{ $address->id }}" {{ $address->is_default ? 'selected' : '' }}>
                                                {{ $address->full_address }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="pickup-date">Pickup Date</label>
                                    <input type="date" id="pickup-date" name="pickup_date" class="form-control" required>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Pickup Time Window</label>
                                    <div class="radio-group">
                                        <div class="radio-option">
                                            <input type="radio" name="pickup_time" id="morning" value="8AM-12PM" class="radio-input" checked>
                                            <label for="morning" class="radio-label">
                                                <i class="fas fa-sun"></i>
                                                8AM - 12PM
                                            </label>
                                        </div>
                                        <div class="radio-option">
                                            <input type="radio" name="pickup_time" id="afternoon" value="12PM-4PM" class="radio-input">
                                            <label for="afternoon" class="radio-label">
                                                <i class="fas fa-cloud-sun"></i>
                                                12PM - 4PM
                                            </label>
                                        </div>
                                        <div class="radio-option">
                                            <input type="radio" name="pickup_time" id="evening" value="4PM-8PM" class="radio-input">
                                            <label for="evening" class="radio-label">
                                                <i class="fas fa-moon"></i>
                                                4PM - 8PM
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="special-instructions">Special Instructions</label>
                                <textarea id="special-instructions" name="special_instructions" class="form-control" rows="3" placeholder="Any special instructions for our team..."></textarea>
                            </div>
                        </div>

                        <!-- Service Selection Section -->
                        <div class="form-section">
                            <h2 class="section-title"><i class="fas fa-concierge-bell"></i> Service Selection</h2>
                            
                            <div class="form-group">
                                <label>Select Services</label>
                                <div class="checkbox-group">
                                    <div class="checkbox-option">
                                        <input type="checkbox" id="wash-fold" name="services[]" value="wash-fold" class="checkbox-input" checked>
                                        <label for="wash-fold" class="checkbox-label">
                                            <i class="fas fa-tshirt"></i>
                                            <div>
                                                <strong>Wash & Fold</strong>
                                                <span>$2.50/lb</span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="checkbox-option">
                                        <input type="checkbox" id="dry-clean" name="services[]" value="dry-clean" class="checkbox-input">
                                        <label for="dry-clean" class="checkbox-label">
                                            <i class="fas fa-spray-can"></i>
                                            <div>
                                                <strong>Dry Cleaning</strong>
                                                <span>$8.00/item</span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="checkbox-option">
                                        <input type="checkbox" id="ironing" name="services[]" value="ironing" class="checkbox-input">
                                        <label for="ironing" class="checkbox-label">
                                            <i class="fas fa-iron"></i>
                                            <div>
                                                <strong>Ironing</strong>
                                                <span>$3.00/item</span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="checkbox-option">
                                        <input type="checkbox" id="stain-removal" name="services[]" value="stain-removal" class="checkbox-input">
                                        <label for="stain-removal" class="checkbox-label">
                                            <i class="fas fa-magic"></i>
                                            <div>
                                                <strong>Stain Removal</strong>
                                                <span>$5.00/item</span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="checkbox-option">
                                        <input type="checkbox" id="delicates" name="services[]" value="delicates" class="checkbox-input">
                                        <label for="delicates" class="checkbox-label">
                                            <i class="fas fa-feather"></i>
                                            <div>
                                                <strong>Delicates</strong>
                                                <span>$4.00/item</span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="checkbox-option">
                                        <input type="checkbox" id="bulky-items" name="services[]" value="bulky-items" class="checkbox-input">
                                        <label for="bulky-items" class="checkbox-label">
                                            <i class="fas fa-bed"></i>
                                            <div>
                                                <strong>Bulky Items</strong>
                                                <span>$15.00/item</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="detergent">Detergent Preference</label>
                                    <select id="detergent" name="detergent" class="form-control">
                                        <option value="standard">Standard (Free)</option>
                                        <option value="hypoallergenic">Hypoallergenic (+$2.00)</option>
                                        <option value="eco-friendly">Eco-Friendly (+$3.00)</option>
                                        <option value="scent-free">Scent-Free (+$1.50)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="fabric-softener">Fabric Softener</label>
                                    <select id="fabric-softener" name="fabric_softener" class="form-control">
                                        <option value="none">None</option>
                                        <option value="standard">Standard (+$1.00)</option>
                                        <option value="scent-free">Scent-Free (+$1.50)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Delivery Details Section -->
                        <div class="form-section">
                            <h2 class="section-title"><i class="fas fa-truck"></i> Delivery Details</h2>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="delivery-address">Delivery Address</label>
                                    <select id="delivery-address" name="delivery_address_id" class="form-control" required>
                                        <option value="">Select an address</option>
                                        @foreach($deliveryAddresses as $address)
                                            <option value="{{ $address->id }}" {{ $address->is_default ? 'selected' : '' }}>
                                                {{ $address->full_address }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="delivery-date">Delivery Date</label>
                                    <input type="date" id="delivery-date" name="delivery_date" class="form-control" required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Delivery Time Window</label>
                                <div class="radio-group">
                                    <div class="radio-option">
                                        <input type="radio" name="delivery_time" id="delivery-morning" value="8AM-12PM" class="radio-input">
                                        <label for="delivery-morning" class="radio-label">
                                            <i class="fas fa-sun"></i>
                                            8AM - 12PM
                                        </label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" name="delivery_time" id="delivery-afternoon" value="12PM-4PM" class="radio-input" checked>
                                        <label for="delivery-afternoon" class="radio-label">
                                            <i class="fas fa-cloud-sun"></i>
                                            12PM - 4PM
                                        </label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" name="delivery_time" id="delivery-evening" value="4PM-8PM" class="radio-input">
                                        <label for="delivery-evening" class="radio-label">
                                            <i class="fas fa-moon"></i>
                                            4PM - 8PM
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <button type="button" class="btn btn-outline">Save as Draft</button>
                            <button type="submit" class="btn btn-primary">Schedule Pickup</button>
                        </div>
                    </form>

                    <!-- Order Summary -->
                    <div class="order-summary">
                        <h2 class="summary-title"><i class="fas fa-receipt"></i> Order Summary</h2>
                        
                        <div class="summary-item">
                            <span class="summary-label">Service Type</span>
                            <span class="summary-value" id="selected-services">Wash & Fold</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Estimated Weight</span>
                            <span class="summary-value">10-15 lbs</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Pickup Date</span>
                            <span class="summary-value" id="pickup-summary">Not selected</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Delivery Date</span>
                            <span class="summary-value" id="delivery-summary">Not selected</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Detergent</span>
                            <span class="summary-value" id="detergent-summary">Standard</span>
                        </div>
                        
                        <div class="summary-item summary-total">
                            <span class="summary-label">Estimated Total</span>
                            <span class="summary-value" id="total-price">$25.00</span>
                        </div>
                        
                        <div class="summary-note">
                            <p><small>*Final price will be calculated based on actual weight and items.</small></p>
                        </div>
                    </div>
                </div>
            @endif
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set minimum pickup date to tomorrow
            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);
            
            const pickupDateInput = document.getElementById('pickup-date');
            const deliveryDateInput = document.getElementById('delivery-date');
            
            if (pickupDateInput && deliveryDateInput) {
                // Format date as YYYY-MM-DD
                const formattedDate = tomorrow.toISOString().split('T')[0];
                pickupDateInput.value = formattedDate;
                pickupDateInput.min = formattedDate;
                
                // Set delivery date to 2 days after pickup
                const deliveryDate = new Date(tomorrow);
                deliveryDate.setDate(deliveryDate.getDate() + 2);
                const formattedDeliveryDate = deliveryDate.toISOString().split('T')[0];
                deliveryDateInput.value = formattedDeliveryDate;
                deliveryDateInput.min = formattedDeliveryDate;
                
                // Update pickup date minimum when delivery date changes
                pickupDateInput.addEventListener('change', function() {
                    const selectedPickupDate = new Date(this.value);
                    const minDeliveryDate = new Date(selectedPickupDate);
                    minDeliveryDate.setDate(minDeliveryDate.getDate() + 1);
                    deliveryDateInput.min = minDeliveryDate.toISOString().split('T')[0];
                    
                    // If current delivery date is before new minimum, update it
                    if (new Date(deliveryDateInput.value) < minDeliveryDate) {
                        deliveryDateInput.value = minDeliveryDate.toISOString().split('T')[0];
                    }
                    
                    updateSummary();
                });
                
                deliveryDateInput.addEventListener('change', updateSummary);
            }
            
            // Update order summary when form changes
            const form = document.querySelector('.schedule-form');
            if (form) {
                form.addEventListener('change', updateSummary);
                updateSummary(); // Initial update
            }
            
            function updateSummary() {
                // Update selected services
                const selectedServices = [];
                document.querySelectorAll('input[name="services[]"]:checked').forEach(checkbox => {
                    const label = document.querySelector(`label[for="${checkbox.id}"] strong`);
                    if (label) {
                        selectedServices.push(label.textContent);
                    }
                });
                
                const servicesElement = document.getElementById('selected-services');
                if (servicesElement) {
                    servicesElement.textContent = selectedServices.length > 0 ? selectedServices.join(', ') : 'None selected';
                }
                
                // Update pickup summary
                const pickupDate = pickupDateInput ? pickupDateInput.value : '';
                const pickupTime = document.querySelector('input[name="pickup_time"]:checked');
                const pickupSummary = document.getElementById('pickup-summary');
                if (pickupSummary) {
                    if (pickupDate && pickupTime) {
                        const date = new Date(pickupDate);
                        const formattedDate = date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                        pickupSummary.textContent = `${formattedDate}, ${pickupTime.value}`;
                    } else {
                        pickupSummary.textContent = 'Not selected';
                    }
                }
                
                // Update delivery summary
                const deliveryDate = deliveryDateInput ? deliveryDateInput.value : '';
                const deliveryTime = document.querySelector('input[name="delivery_time"]:checked');
                const deliverySummary = document.getElementById('delivery-summary');
                if (deliverySummary) {
                    if (deliveryDate && deliveryTime) {
                        const date = new Date(deliveryDate);
                        const formattedDate = date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                        deliverySummary.textContent = `${formattedDate}, ${deliveryTime.value}`;
                    } else {
                        deliverySummary.textContent = 'Not selected';
                    }
                }
                
                // Update detergent summary
                const detergentSelect = document.getElementById('detergent');
                const detergentSummary = document.getElementById('detergent-summary');
                if (detergentSelect && detergentSummary) {
                    const selectedOption = detergentSelect.options[detergentSelect.selectedIndex];
                    detergentSummary.textContent = selectedOption.text.split(' (')[0];
                }
            }
        });
    </script>
</body>
</html>