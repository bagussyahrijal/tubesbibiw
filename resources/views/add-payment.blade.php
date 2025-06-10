<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B Laundry Laundry - Add Payment Method</title>
    <link rel="stylesheet" href="add-payment.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container navbar-container">
            <a href="index.html" class="logo">
                <i class="fas fa-tshirt"></i>
                B Laundry
            </a>
            <ul class="nav-links">
                <li><a href="dashboard.html">Dashboard</a></li>
                <li><a href="orders.html">My Orders</a></li>
                <li><a href="schedule.html">Schedule Pickup</a></li>
                <li><a href="pricing.html">Pricing</a></li>
                <li><a href="support.html">Support</a></li>
            </ul>
            <div class="user-menu">
                <div class="dropdown">
                    <div class="user-avatar">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="User Avatar">
                    </div>
                    <div class="dropdown-content">
                        <a href="profile.html"><i class="fas fa-user"></i> My Profile</a>
                        <a href="settings.html"><i class="fas fa-cog"></i> Settings</a>
                        <a href="payment.html"><i class="fas fa-credit-card"></i> Payment Methods</a>
                        <a href="login.html"><i class="fas fa-sign-out-alt"></i> Logout</a>
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
                <li><a href="dashboard.html"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="orders.html"><i class="fas fa-clipboard-list"></i> My Orders</a></li>
                <li><a href="schedule.html"><i class="fas fa-calendar-alt"></i> Schedule Pickup</a></li>
                <li><a href="addresses.html"><i class="fas fa-map-marker-alt"></i> My Addresses</a></li>
                <li><a href="payment.html" class="active"><i class="fas fa-credit-card"></i> Payment Methods</a></li>
                <li><a href="profile.html"><i class="fas fa-user"></i> My Profile</a></li>
                <li><a href="support.html"><i class="fas fa-headset"></i> Support</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <a href="payment.html" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Payment Methods
            </a>
            
            <div class="page-header">
                <h1 class="page-title"><i class="fas fa-credit-card"></i> Add Payment Method</h1>
            </div>

            <div class="payment-form">
                <!-- Payment Method Selection -->
                <div class="form-section">
                    <h2 class="section-title"><i class="fas fa-wallet"></i> Payment Method</h2>
                    
                    <div class="payment-tabs">
                        <div class="payment-tab active" data-target="credit-card">
                            <i class="far fa-credit-card"></i> Credit Card
                        </div>
                        <div class="payment-tab" data-target="paypal">
                            <i class="fab fa-paypal"></i> PayPal
                        </div>
                    </div>
                    
                    <div class="payment-options">
                        <!-- Credit Card Form -->
                        <div id="credit-card" class="payment-option active">
                            <div class="card-icons">
                                <div class="card-icon visa">
                                    <i class="fab fa-cc-visa"></i>
                                </div>
                                <div class="card-icon mastercard">
                                    <i class="fab fa-cc-mastercard"></i>
                                </div>
                                <div class="card-icon amex">
                                    <i class="fab fa-cc-amex"></i>
                                </div>
                                <div class="card-icon discover">
                                    <i class="fab fa-cc-discover"></i>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="card-number">Card Number</label>
                                <input type="text" id="card-number" class="form-control" placeholder="1234 5678 9012 3456" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="card-name">Name on Card</label>
                                <input type="text" id="card-name" class="form-control" placeholder="Enter name as it appears on card" required>
                            </div>
                            
                            <div class="form-row expiry-cvv">
                                <div class="expiry-date">
                                    <div class="form-group">
                                        <label for="expiry-month">Expiration Month</label>
                                        <select id="expiry-month" class="form-control" required>
                                            <option value="">Month</option>
                                            <option value="01">01 - January</option>
                                            <option value="02">02 - February</option>
                                            <option value="03">03 - March</option>
                                            <option value="04">04 - April</option>
                                            <option value="05">05 - May</option>
                                            <option value="06">06 - June</option>
                                            <option value="07">07 - July</option>
                                            <option value="08">08 - August</option>
                                            <option value="09">09 - September</option>
                                            <option value="10">10 - October</option>
                                            <option value="11">11 - November</option>
                                            <option value="12">12 - December</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="expiry-year">Expiration Year</label>
                                        <select id="expiry-year" class="form-control" required>
                                            <option value="">Year</option>
                                            <option value="2023">2023</option>
                                            <option value="2024">2024</option>
                                            <option value="2025">2025</option>
                                            <option value="2026">2026</option>
                                            <option value="2027">2027</option>
                                            <option value="2028">2028</option>
                                            <option value="2029">2029</option>
                                            <option value="2030">2030</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="cvv-group">
                                    <label for="cvv">Security Code (CVV) 
                                        <span class="cvv-hint">
                                            <i class="fas fa-question-circle"></i>
                                            <span class="cvv-tooltip">3 or 4 digit code on back of card</span>
                                        </span>
                                    </label>
                                    <input type="text" id="cvv" class="form-control" placeholder="123" required>
                                </div>
                            </div>
                        </div>
                        
                        <!-- PayPal Form -->
                        <div id="paypal" class="payment-option">
                            <div style="text-align: center; padding: 20px;">
                                <i class="fab fa-paypal" style="font-size: 50px; color: #003087; margin-bottom: 20px;"></i>
                                <p>You'll be redirected to PayPal to securely log in and authorize payments.</p>
                                <button type="button" class="btn btn-primary" style="background-color: #003087; border-color: #003087; margin-top: 15px;">
                                    <i class="fab fa-paypal"></i> Connect PayPal Account
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Billing Address -->
                <div class="form-section">
                    <h2 class="section-title"><i class="fas fa-map-marker-alt"></i> Billing Address</h2>
                    
                    <div class="form-group">
                        <label for="billing-address">Select Address</label>
                        <select id="billing-address" class="form-control" required>
                            <option value="">Select a saved address</option>
                            <option value="home">123 Main Street, Apartment 4B, New York, NY 10001</option>
                            <option value="work">456 Business Avenue, Floor 12, New York, NY 10010</option>
                            <option value="other">Use different address</option>
                        </select>
                    </div>
                    
                    <div id="different-address" style="display: none; margin-top: 20px;">
                        <div class="form-group">
                            <label for="address-line1">Address Line 1</label>
                            <input type="text" id="address-line1" class="form-control" placeholder="Street address, P.O. box, company name">
                        </div>
                        
                        <div class="form-group">
                            <label for="address-line2">Address Line 2 (Optional)</label>
                            <input type="text" id="address-line2" class="form-control" placeholder="Apartment, suite, unit, building, floor, etc.">
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="billing-city">City</label>
                                <input type="text" id="billing-city" class="form-control" placeholder="Enter city">
                            </div>
                            <div class="form-group">
                                <label for="billing-state">State/Province/Region</label>
                                <input type="text" id="billing-state" class="form-control" placeholder="Enter state or region">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="billing-zip">ZIP/Postal Code</label>
                                <input type="text" id="billing-zip" class="form-control" placeholder="Enter ZIP code">
                            </div>
                            <div class="form-group">
                                <label for="billing-country">Country</label>
                                <select id="billing-country" class="form-control">
                                    <option value="US" selected>United States</option>
                                    <option value="CA">Canada</option>
                                    <option value="UK">United Kingdom</option>
                                    <!-- More countries would be added here -->
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Default Payment Option -->
                <div class="form-section">
                    <div class="checkbox-group">
                        <input type="checkbox" id="set-default" class="checkbox-input">
                        <label for="set-default">Set as default payment method</label>
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="button" class="btn btn-outline">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Payment Method</button>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Payment method tabs
            const paymentTabs = document.querySelectorAll('.payment-tab');
            const paymentOptions = document.querySelectorAll('.payment-option');
            
            paymentTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Remove active class from all tabs
                    paymentTabs.forEach(t => t.classList.remove('active'));
                    // Add active class to clicked tab
                    this.classList.add('active');
                    
                    // Hide all payment options
                    paymentOptions.forEach(option => option.classList.remove('active'));
                    // Show selected payment option
                    const target = this.getAttribute('data-target');
                    document.getElementById(target).classList.add('active');
                });
            });
            
            // Billing address selection
            const billingAddressSelect = document.getElementById('billing-address');
            const differentAddressSection = document.getElementById('different-address');
            
            billingAddressSelect.addEventListener('change', function() {
                if (this.value === 'other') {
                    differentAddressSection.style.display = 'block';
                } else {
                    differentAddressSection.style.display = 'none';
                }
            });
            
            // Form submission
            const form = document.querySelector('.payment-form');
            
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // In a real application, this would validate and send the data to your server
                const paymentType = document.querySelector('.payment-tab.active').getAttribute('data-target');
                const formData = {
                    paymentType: paymentType,
                    cardNumber: paymentType === 'credit-card' ? document.getElementById('card-number').value : null,
                    cardName: paymentType === 'credit-card' ? document.getElementById('card-name').value : null,
                    expiryMonth: paymentType === 'credit-card' ? document.getElementById('expiry-month').value : null,
                    expiryYear: paymentType === 'credit-card' ? document.getElementById('expiry-year').value : null,
                    cvv: paymentType === 'credit-card' ? document.getElementById('cvv').value : null,
                    billingAddress: document.getElementById('billing-address').value,
                    isDefault: document.getElementById('set-default').checked
                };
                
                console.log('Form submitted:', formData);
                
                // Show success message and redirect
                alert('Payment method added successfully!');
                window.location.href = 'payment.html';
            });
            
            // Cancel button functionality
            const cancelButton = document.querySelector('.btn-outline');
            cancelButton.addEventListener('click', function() {
                if (confirm('Are you sure you want to cancel? Any unsaved changes will be lost.')) {
                    window.location.href = 'payment.html';
                }
            });
            
            // Format card number input
            const cardNumberInput = document.getElementById('card-number');
            if (cardNumberInput) {
                cardNumberInput.addEventListener('input', function(e) {
                    // Remove all non-digit characters
                    let value = this.value.replace(/\D/g, '');
                    // Add space after every 4 digits
                    value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
                    this.value = value;
                });
            }
        });
    </script>
</body>
</html>