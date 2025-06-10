<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B Laundry Laundry - My Subscription</title>
    <link rel="stylesheet" href="subs.css">
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
                <li><a href="subscription.html" class="active"><i class="fas fa-star"></i> Subscription</a></li>
                <li><a href="payment.html"><i class="fas fa-credit-card"></i> Payment Methods</a></li>
                <li><a href="profile.html"><i class="fas fa-user"></i> My Profile</a></li>
                <li><a href="support.html"><i class="fas fa-headset"></i> Support</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="page-header">
                <h1 class="page-title"><i class="fas fa-star"></i> My Subscription</h1>
            </div>

            <div class="subscription-container">
                <!-- Current Subscription -->
                <div class="current-subscription">
                    <div class="subscription-header">
                        <h2 class="subscription-title">Premium Membership</h2>
                        <span class="subscription-badge">Active</span>
                    </div>
                    
                    <div class="subscription-details">
                        <div class="detail-item">
                            <div class="detail-label">Billing Cycle</div>
                            <div class="detail-value">Monthly</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Next Billing Date</div>
                            <div class="detail-value">June 15, 2023</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Payment Method</div>
                            <div class="detail-value">Visa ending in 4242</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Monthly Cost</div>
                            <div class="detail-value">$19.99</div>
                        </div>
                    </div>
                    
                    <div class="subscription-features">
                        <h3 class="features-title">Your Premium Benefits:</h3>
                        <ul class="features-list">
                            <li>15% discount on all laundry services</li>
                            <li>Free priority pickup and delivery</li>
                            <li>Eco-friendly packaging included</li>
                            <li>Free stain treatment on all items</li>
                            <li>Exclusive access to premium detergents</li>
                            <li>24-hour turnaround guarantee</li>
                        </ul>
                    </div>
                    
                    <div class="subscription-actions">
                        <button class="btn btn-outline">
                            <i class="fas fa-exchange-alt"></i> Change Plan
                        </button>
                        <button class="btn btn-primary">
                            <i class="fas fa-cog"></i> Manage Payment
                        </button>
                        <button class="btn btn-outline" style="border-color: var(--danger-color); color: var(--danger-color);">
                            <i class="fas fa-times"></i> Cancel Subscription
                        </button>
                    </div>
                </div>

                <!-- Upgrade Options -->
                <div class="upgrade-options">
                    <h2 class="section-title"><i class="fas fa-arrow-up"></i> Upgrade Your Plan</h2>
                    <p style="margin-bottom: 20px;">Choose a plan that fits your laundry needs and save more with our subscription options.</p>
                    
                    <div class="plans-grid">
                        <!-- Basic Plan -->
                        <div class="plan-card">
                            <h3 class="plan-name">Basic Plan</h3>
                            <div class="plan-price">$9.99 <span>/month</span></div>
                            <ul class="plan-features">
                                <li>5% discount on all orders</li>
                                <li>Standard turnaround time</li>
                                <li>Basic packaging</li>
                                <li>Up to 2 bags per week</li>
                            </ul>
                            <button class="btn btn-outline plan-button">Select Plan</button>
                        </div>
                        
                        <!-- Premium Plan (Recommended) -->
                        <div class="plan-card recommended">
                            <div class="recommended-badge">Recommended</div>
                            <h3 class="plan-name">Premium Plan</h3>
                            <div class="plan-price">$19.99 <span>/month</span></div>
                            <ul class="plan-features">
                                <li>15% discount on all orders</li>
                                <li>Priority pickup & delivery</li>
                                <li>Eco-friendly packaging</li>
                                <li>Free stain treatment</li>
                                <li>Up to 4 bags per week</li>
                                <li>24-hour turnaround</li>
                            </ul>
                            <button class="btn btn-primary plan-button">Current Plan</button>
                        </div>
                        
                        <!-- Family Plan -->
                        <div class="plan-card">
                            <h3 class="plan-name">Family Plan</h3>
                            <div class="plan-price">$29.99 <span>/month</span></div>
                            <ul class="plan-features">
                                <li>20% discount on all orders</li>
                                <li>Priority pickup & delivery</li>
                                <li>Premium packaging</li>
                                <li>Free stain treatment</li>
                                <li>Unlimited bags</li>
                                <li>Same-day service</li>
                                <li>Free dry cleaning (2 items/week)</li>
                            </ul>
                            <button class="btn btn-outline plan-button">Upgrade Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // In a real application, this would handle subscription management
        document.addEventListener('DOMContentLoaded', function() {
            // Cancel subscription button
            const cancelButton = document.querySelector('.btn-outline[style*="danger"]');
            
            cancelButton.addEventListener('click', function() {
                if (confirm('Are you sure you want to cancel your subscription? You will lose all premium benefits immediately.')) {
                    // In a real app, this would call an API to cancel the subscription
                    alert('Subscription cancellation request received. We\'re sorry to see you go!');
                    // Update UI to reflect cancelled status
                    document.querySelector('.subscription-badge').textContent = 'Cancelled';
                    document.querySelector('.subscription-badge').classList.add('cancelled');
                }
            });
            
            // Plan selection buttons
            const planButtons = document.querySelectorAll('.plan-button:not(.btn-primary)');
            
            planButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const planName = this.closest('.plan-card').querySelector('.plan-name').textContent;
                    // In a real app, this would redirect to a checkout/upgrade page
                    alert(`You selected the ${planName}. This would redirect to a checkout page in a real application.`);
                });
            });
        });
    </script>
</body>
</html>