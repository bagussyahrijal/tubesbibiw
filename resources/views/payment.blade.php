<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Methods - B Laundry</title>
    
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
                <li><a href="{{ route('schedule.create') }}">Schedule Pickup</a></li>
                <li><a href="{{ route('pricing') }}">Pricing</a></li>
                <li><a href="#">Support</a></li>
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
                <li><a href="{{ route('schedule.create') }}"><i class="fas fa-calendar-alt"></i> Schedule Pickup</a></li>
                <li><a href="{{ route('addresses') }}"><i class="fas fa-map-marker-alt"></i> My Addresses</a></li>
                <li><a href="{{ route('payment.methods') }}" class="active"><i class="fas fa-credit-card"></i> Payment Methods</a></li>
                <li><a href="{{ route('profile.show') }}"><i class="fas fa-user"></i> My Profile</a></li>
                <li><a href="{{ route('support') }}"><i class="fas fa-headset"></i> Support</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="page-header">
                <h1 class="page-title"><i class="fas fa-credit-card"></i> Payment Methods</h1>
                <p class="page-subtitle">Manage your payment methods for quick checkout</p>
            </div>

            <!-- Add Payment Button -->
            <div class="page-actions">
                <button class="btn btn-primary" onclick="showAddPaymentModal()">
                    <i class="fas fa-plus"></i> Add Payment Method
                </button>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Payment Methods List -->
            <div class="payment-methods-list">
                <!-- Credit Card -->
                <div class="payment-method-card">
                    <div class="payment-method-header">
                        <div class="payment-method-icon visa">
                            <i class="fab fa-cc-visa"></i>
                        </div>
                        <div class="payment-method-info">
                            <h3>Visa ending in 4242</h3>
                            <p>Expires 12/2025</p>
                        </div>
                        <div class="payment-method-badges">
                            <span class="badge default">Default</span>
                        </div>
                    </div>
                    <div class="payment-method-actions">
                        <button class="action-btn edit">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="action-btn delete">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                        <button class="action-btn default">
                            <i class="fas fa-star"></i> Set Default
                        </button>
                    </div>
                </div>

                <!-- PayPal -->
                <div class="payment-method-card">
                    <div class="payment-method-header">
                        <div class="payment-method-icon paypal">
                            <i class="fab fa-cc-paypal"></i>
                        </div>
                        <div class="payment-method-info">
                            <h3>PayPal</h3>
                            <p>{{ Auth::user()->email }}</p>
                        </div>
                        <div class="payment-method-badges">
                            <!-- No badges for this one -->
                        </div>
                    </div>
                    <div class="payment-method-actions">
                        <button class="action-btn edit">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="action-btn delete">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                        <button class="action-btn default">
                            <i class="fas fa-star"></i> Set Default
                        </button>
                    </div>
                </div>

                <!-- Mastercard -->
                <div class="payment-method-card">
                    <div class="payment-method-header">
                        <div class="payment-method-icon mastercard">
                            <i class="fab fa-cc-mastercard"></i>
                        </div>
                        <div class="payment-method-info">
                            <h3>Mastercard ending in 8888</h3>
                            <p>Expires 08/2026</p>
                        </div>
                        <div class="payment-method-badges">
                            <!-- No badges for this one -->
                        </div>
                    </div>
                    <div class="payment-method-actions">
                        <button class="action-btn edit">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="action-btn delete">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                        <button class="action-btn default">
                            <i class="fas fa-star"></i> Set Default
                        </button>
                    </div>
                </div>
            </div>

            <!-- No Payment Methods State -->
            <div class="no-payment-methods" style="display: none;">
                <i class="fas fa-credit-card"></i>
                <h3>No Payment Methods Yet</h3>
                <p>Add your first payment method for quick and secure checkout.</p>
                <button class="btn btn-primary" onclick="showAddPaymentModal()">Add Payment Method</button>
            </div>
        </main>
    </div>

    <!-- Add Payment Method Modal -->
    <div id="paymentModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-credit-card"></i> Add Payment Method</h2>
                <span class="close" onclick="hideAddPaymentModal()">&times;</span>
            </div>
            <form action="{{ route('payment.store') }}" method="POST" class="payment-form">
                @csrf
                
                <div class="form-section">
                    <h3>Payment Type</h3>
                    <div class="payment-type-tabs">
                        <div class="payment-type-tab active" data-type="credit_card">
                            <i class="fas fa-credit-card"></i> Credit Card
                        </div>
                        <div class="payment-type-tab" data-type="debit_card">
                            <i class="fas fa-credit-card"></i> Debit Card
                        </div>
                        <div class="payment-type-tab" data-type="paypal">
                            <i class="fab fa-paypal"></i> PayPal
                        </div>
                    </div>
                    <input type="hidden" id="payment-type" name="payment_type" value="credit_card">
                </div>

                <div id="card-details">
                    <div class="form-group">
                        <label for="card-holder-name">Cardholder Name</label>
                        <input type="text" id="card-holder-name" name="card_holder_name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="card-number">Card Number</label>
                        <input type="text" id="card-number" name="card_number" class="form-control" placeholder="1234 5678 9012 3456" maxlength="19" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="expiry-date">Expiry Date</label>
                            <input type="text" id="expiry-date" name="expiry_date" class="form-control" placeholder="MM/YY" maxlength="5" required>
                        </div>
                        <div class="form-group">
                            <label for="cvv">CVV</label>
                            <input type="text" id="cvv" name="cvv" class="form-control" placeholder="123" maxlength="4" required>
                        </div>
                    </div>
                </div>

                <div id="paypal-details" style="display: none;">
                    <div class="form-group">
                        <label for="paypal-email">PayPal Email</label>
                        <input type="email" id="paypal-email" name="paypal_email" class="form-control" placeholder="your@email.com">
                    </div>
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" id="set-default" name="set_default" class="checkbox-input">
                    <label for="set-default">Set as default payment method</label>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn btn-outline" onclick="hideAddPaymentModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Payment Method</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Modal functionality
        function showAddPaymentModal() {
            document.getElementById('paymentModal').style.display = 'block';
        }

        function hideAddPaymentModal() {
            document.getElementById('paymentModal').style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('paymentModal');
            if (event.target === modal) {
                hideAddPaymentModal();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Payment type tabs
            const paymentTypeTabs = document.querySelectorAll('.payment-type-tab');
            const paymentTypeInput = document.getElementById('payment-type');
            const cardDetails = document.getElementById('card-details');
            const paypalDetails = document.getElementById('paypal-details');
            
            paymentTypeTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    paymentTypeTabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    
                    const type = this.getAttribute('data-type');
                    paymentTypeInput.value = type;
                    
                    if (type === 'paypal') {
                        cardDetails.style.display = 'none';
                        paypalDetails.style.display = 'block';
                    } else {
                        cardDetails.style.display = 'block';
                        paypalDetails.style.display = 'none';
                    }
                });
            });

            // Card number formatting
            const cardNumberInput = document.getElementById('card-number');
            if (cardNumberInput) {
                cardNumberInput.addEventListener('input', function() {
                    let value = this.value.replace(/\s/g, '');
                    let formattedValue = value.replace(/(.{4})/g, '$1 ').trim();
                    this.value = formattedValue;
                });
            }

            // Expiry date formatting
            const expiryInput = document.getElementById('expiry-date');
            if (expiryInput) {
                expiryInput.addEventListener('input', function() {
                    let value = this.value.replace(/\D/g, '');
                    if (value.length >= 2) {
                        value = value.substring(0, 2) + '/' + value.substring(2, 4);
                    }
                    this.value = value;
                });
            }

            // Delete payment method
            const deleteButtons = document.querySelectorAll('.action-btn.delete');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    if (confirm('Are you sure you want to delete this payment method?')) {
                        // In real app, this would make an API call
                        const card = this.closest('.payment-method-card');
                        card.remove();
                    }
                });
            });

            // Set default payment method
            const defaultButtons = document.querySelectorAll('.action-btn.default');
            defaultButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove default badge from all cards
                    document.querySelectorAll('.badge.default').forEach(badge => badge.remove());
                    
                    // Add default badge to this card
                    const card = this.closest('.payment-method-card');
                    const badgesContainer = card.querySelector('.payment-method-badges');
                    
                    const defaultBadge = document.createElement('span');
                    defaultBadge.className = 'badge default';
                    defaultBadge.textContent = 'Default';
                    badgesContainer.appendChild(defaultBadge);
                });
            });
        });
    </script>
</body>
</html>