<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B Laundry Laundry - Track Order</title>
    <link rel="stylesheet" href="order-tracker.css">
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
                <li><a href="payment.html"><i class="fas fa-credit-card"></i> Payment Methods</a></li>
                <li><a href="profile.html"><i class="fas fa-user"></i> My Profile</a></li>
                <li><a href="support.html"><i class="fas fa-headset"></i> Support</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <a href="orders.html" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to My Orders
            </a>
            
            <div class="page-header">
                <h1 class="page-title"><i class="fas fa-truck"></i> Track Order</h1>
            </div>

            <div class="tracking-container">
                <!-- Order Summary -->
                <div class="order-summary">
                    <div>
                        <div class="order-id">Order #LC-78944</div>
                        <div class="order-status processing">Processing</div>
                        <div class="order-dates">
                            <div>Placed: May 18, 2023 at 2:15 PM</div>
                            <div>Estimated Delivery: May 21, 2023 by 4:00 PM</div>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-outline">
                            <i class="fas fa-headset"></i> Contact Support
                        </button>
                    </div>
                </div>

                <!-- Tracking Timeline -->
                <div class="tracking-timeline">
                    <div class="timeline-progress">
                        <div class="timeline-progress-bar" style="height: 60%;"></div>
                    </div>
                    
                    <div class="timeline-item completed">
                        <div class="timeline-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-date">May 18, 2:30 PM</div>
                            <div class="timeline-title">Order Picked Up</div>
                            <div class="timeline-description">Your laundry has been collected from your address</div>
                        </div>
                    </div>
                    
                    <div class="timeline-item completed">
                        <div class="timeline-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-date">May 18, 4:15 PM</div>
                            <div class="timeline-title">Received at Facility</div>
                            <div class="timeline-description">Your items have arrived at our cleaning facility</div>
                        </div>
                    </div>
                    
                    <div class="timeline-item active">
                        <div class="timeline-icon">
                            <i class="fas fa-spinner"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-date">May 19, 9:00 AM</div>
                            <div class="timeline-title">In Progress</div>
                            <div class="timeline-description">Your items are being cleaned and processed</div>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-icon">
                            <i class="fas fa-tshirt"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-date">Estimated: May 20</div>
                            <div class="timeline-title">Quality Check</div>
                            <div class="timeline-description">Your items will undergo final inspection</div>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-date">Estimated: May 21, 12PM-4PM</div>
                            <div class="timeline-title">Out for Delivery</div>
                            <div class="timeline-description">Your order will be delivered to your address</div>
                        </div>
                    </div>
                </div>

                <!-- Order Details -->
                <div class="order-details">
                    <div class="details-title">
                        <i class="fas fa-info-circle"></i> Order Details
                    </div>
                    
                    <div class="details-grid">
                        <div class="detail-card">
                            <div class="detail-label">Pickup Address</div>
                            <div class="detail-value">123 Main St, Apt 4B, New York, NY 10001</div>
                        </div>
                        <div class="detail-card">
                            <div class="detail-label">Delivery Address</div>
                            <div class="detail-value">123 Main St, Apt 4B, New York, NY 10001</div>
                        </div>
                        <div class="detail-card">
                            <div class="detail-label">Payment Method</div>
                            <div class="detail-value">VISA •••• 4242</div>
                        </div>
                        <div class="detail-card">
                            <div class="detail-label">Delivery Instructions</div>
                            <div class="detail-value">Leave with doorman if not home</div>
                        </div>
                    </div>
                    
                    <div class="details-title">
                        <i class="fas fa-concierge-bell"></i> Services
                    </div>
                    
                    <div class="service-items">
                        <div class="service-item">
                            <div class="service-info">
                                <div class="service-icon">
                                    <i class="fas fa-tshirt"></i>
                                </div>
                                <div>
                                    <div class="service-name">Wash & Fold</div>
                                    <div class="service-description">5 Shirts, 3 Pants, 1 Jacket</div>
                                </div>
                            </div>
                            <div class="service-price">$22.50</div>
                        </div>
                        <div class="service-item">
                            <div class="service-info">
                                <div class="service-icon">
                                    <i class="fas fa-iron"></i>
                                </div>
                                <div>
                                    <div class="service-name">Ironing</div>
                                    <div class="service-description">3 Shirts, 2 Pants</div>
                                </div>
                            </div>
                            <div class="service-price">$6.00</div>
                        </div>
                    </div>
                    
                    <div class="order-total">
                        <div class="total-label">Total:</div>
                        <div class="total-value">$28.50</div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button class="btn btn-outline">
                        <i class="fas fa-print"></i> Print Receipt
                    </button>
                    <button class="btn btn-primary">
                        <i class="fas fa-redo"></i> Reorder
                    </button>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // In a real application, this would fetch order tracking data from an API
            // and update the timeline progress bar accordingly
            
            // Example of updating progress bar based on order status
            const orderStatus = 'processing'; // This would come from your data
            let progressPercentage = 0;
            
            switch(orderStatus) {
                case 'pending':
                    progressPercentage = 10;
                    break;
                case 'processing':
                    progressPercentage = 60;
                    break;
                case 'completed':
                    progressPercentage = 100;
                    break;
                default:
                    progressPercentage = 0;
            }
            
            document.querySelector('.timeline-progress-bar').style.height = `${progressPercentage}%`;
        });
    </script>
</body>
</html>