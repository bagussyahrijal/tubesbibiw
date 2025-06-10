<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Address - B Laundry</title>
    
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
                <li><a href="{{ route('schedule.create') }}"><i class="fas fa-calendar-alt"></i> Schedule Pickup</a></li>
                <li><a href="{{ route('pricing') }}">Pricing</a></li>
                <li><a href="{{ route('support') }}">Support</a></li>
            </ul>
            <div class="user-menu">
                <div class="dropdown">
                    <div class="user-avatar">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="dropdown-content">
                        <a href="#"><i class="fas fa-user"></i> My Profile</a>
                        <a href="#"><i class="fas fa-cog"></i> Settings</a>
                        <a href="#"><i class="fas fa-credit-card"></i> Payment Methods</a>
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
                <li><a href="#"><i class="fas fa-calendar-alt"></i> Schedule Pickup</a></li>
                <li><a href="{{ route('addresses') }}" class="active"><i class="fas fa-map-marker-alt"></i> My Addresses</a></li>
                <li><a href="{{ route('payment.methods') }}"><i class="fas fa-credit-card"></i> Payment Methods</a></li>
                <li><a href="#"><i class="fas fa-user"></i> My Profile</a></li>
                <li><a href="#"><i class="fas fa-headset"></i> Support</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <a href="{{ route('addresses') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to My Addresses
            </a>
            
            <div class="page-header">
                <h1 class="page-title"><i class="fas fa-map-marker-alt"></i> Add New Address</h1>
            </div>

            <div class="address-form">
                <form action="{{ route('addresses.store') }}" method="POST">
                    @csrf
                    
                    <!-- Address Type Selection -->
                    <div class="form-section">
                        <h2 class="section-title"><i class="fas fa-tag"></i> Address Type</h2>
                        
                        <div class="address-type-tabs">
                            <div class="address-type-tab active" data-type="home">
                                <i class="fas fa-home"></i> Home
                            </div>
                            <div class="address-type-tab" data-type="work">
                                <i class="fas fa-building"></i> Work
                            </div>
                            <div class="address-type-tab" data-type="other">
                                <i class="fas fa-map-marker-alt"></i> Other
                            </div>
                        </div>
                        
                        <input type="hidden" id="address-type" name="address_type" value="home">
                        
                        <div id="other-type" style="display: none;">
                            <div class="form-group">
                                <label for="custom-type">Custom Address Name</label>
                                <input type="text" id="custom-type" name="custom_type" class="form-control" placeholder="e.g., Sister's Place, Gym, etc.">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contact Information -->
                    <div class="form-section">
                        <h2 class="section-title"><i class="fas fa-user"></i> Contact Information</h2>
                        
                        <div class="form-group">
                            <label for="full-name">Full Name</label>
                            <input type="text" id="full-name" name="full_name" class="form-control" 
                                   value="{{ Auth::user()->name }}" placeholder="Enter full name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" class="form-control" 
                                   value="{{ Auth::user()->phone }}" placeholder="Enter phone number" required>
                        </div>
                    </div>
                    
                    <!-- Address Details -->
                    <div class="form-section">
                        <h2 class="section-title"><i class="fas fa-location-arrow"></i> Address Details</h2>
                        
                        <div class="form-group">
                            <label for="address-line1">Address Line 1</label>
                            <input type="text" id="address-line1" name="address_line1" class="form-control" 
                                   placeholder="Street address, P.O. box, company name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="address-line2">Address Line 2 (Optional)</label>
                            <input type="text" id="address-line2" name="address_line2" class="form-control" 
                                   placeholder="Apartment, suite, unit, building, floor, etc.">
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" id="city" name="city" class="form-control" placeholder="Enter city" required>
                            </div>
                            <div class="form-group">
                                <label for="state">State/Province</label>
                                <input type="text" id="state" name="state" class="form-control" placeholder="Enter state" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="zip">ZIP/Postal Code</label>
                                <input type="text" id="zip" name="zip" class="form-control" placeholder="Enter ZIP code" required>
                            </div>
                            <div class="form-group">
                                <label for="country">Country</label>
                                <select id="country" name="country" class="form-control" required>
                                    <option value="US" selected>Indonesia</option>
                                    <option value="CA">Malaysia</option>
                                    <option value="UK">Singapur</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Address Options -->
                    <div class="form-section">
                        <h2 class="section-title"><i class="fas fa-cog"></i> Address Options</h2>
                        
                        <div class="checkbox-group">
                            <input type="checkbox" id="pickup-address" name="pickup_address" class="checkbox-input" checked>
                            <label for="pickup-address">Use for pickup</label>
                        </div>
                        
                        <div class="checkbox-group">
                            <input type="checkbox" id="delivery-address" name="delivery_address" class="checkbox-input" checked>
                            <label for="delivery-address">Use for delivery</label>
                        </div>
                        
                        <div class="checkbox-group">
                            <input type="checkbox" id="default-address" name="default_address" class="checkbox-input">
                            <label for="default-address">Set as default address</label>
                        </div>
                    </div>
                    
                    <!-- Special Instructions -->
                    <div class="form-section">
                        <h2 class="section-title"><i class="fas fa-sticky-note"></i> Special Instructions (Optional)</h2>
                        
                        <div class="form-group">
                            <label for="instructions">Delivery Instructions</label>
                            <textarea id="instructions" name="instructions" class="form-control" 
                                      placeholder="e.g., Leave at front door, Ring bell twice, Call upon arrival, etc." 
                                      rows="3"></textarea>
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="{{ route('addresses') }}" class="btn btn-outline">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Address</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Address type tabs
            const addressTypeTabs = document.querySelectorAll('.address-type-tab');
            const addressTypeInput = document.getElementById('address-type');
            const otherTypeSection = document.getElementById('other-type');
            
            addressTypeTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Remove active class from all tabs
                    addressTypeTabs.forEach(t => t.classList.remove('active'));
                    // Add active class to clicked tab
                    this.classList.add('active');
                    
                    // Update hidden input value
                    const type = this.getAttribute('data-type');
                    addressTypeInput.value = type;
                    
                    // Show/hide custom type input
                    if (type === 'other') {
                        otherTypeSection.style.display = 'block';
                        document.getElementById('custom-type').required = true;
                    } else {
                        otherTypeSection.style.display = 'none';
                        document.getElementById('custom-type').required = false;
                    }
                });
            });
        });
    </script>
</body>
</html>