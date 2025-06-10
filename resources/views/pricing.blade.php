<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing - B Laundry</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container navbar-container">
            <a href="{{ route('home') }}" class="logo">
                <i class="fas fa-tshirt"></i>
                B Laundry
            </a>
            <ul class="nav-links">
                @auth
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('orders') }}">My Orders</a></li>
                    <li><a href="{{ route('schedule.create') }}">Schedule Pickup</a></li>
                @endauth
                <li><a href="{{ route('pricing') }}" class="active">Pricing</a></li>
                <li><a href="#">Support</a></li>
            </ul>
            <div class="nav-buttons">
                @auth
                    <span style="margin-right: 1rem;">Welcome, {{ Auth::user()->name }}!</span>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-outline">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Pricing Section -->
    <section class="pricing-section">
        <div class="container">
            <div class="pricing-header">
                <h1>Simple, Transparent Pricing</h1>
                <p>No hidden fees, no minimum orders. Pay only for what you need.</p>
            </div>

            <!-- Service Pricing -->
            <div class="pricing-cards">
                <div class="pricing-card featured">
                    <div class="pricing-card-header">
                        <i class="fas fa-tshirt"></i>
                        <h3>Wash & Fold</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">2.50</span>
                            <span class="unit">per lb</span>
                        </div>
                    </div>
                    <div class="pricing-card-body">
                        <p>Perfect for everyday laundry</p>
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Wash & Dry</li>
                            <li><i class="fas fa-check"></i> Fold & Sort</li>
                            <li><i class="fas fa-check"></i> 24-48 Hour Turnaround</li>
                            <li><i class="fas fa-check"></i> Standard Detergent</li>
                        </ul>
                        @auth
                            <a href="{{ route('schedule.create') }}" class="btn btn-primary">Schedule Now</a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                        @endauth
                    </div>
                </div>

                <div class="pricing-card">
                    <div class="pricing-card-header">
                        <i class="fas fa-spray-can"></i>
                        <h3>Dry Cleaning</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">8.00</span>
                            <span class="unit">per item</span>
                        </div>
                    </div>
                    <div class="pricing-card-body">
                        <p>Professional dry cleaning service</p>
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Professional Cleaning</li>
                            <li><i class="fas fa-check"></i> Pressing Included</li>
                            <li><i class="fas fa-check"></i> 2-3 Day Turnaround</li>
                            <li><i class="fas fa-check"></i> Protective Bags</li>
                        </ul>
                        @auth
                            <a href="{{ route('schedule.create') }}" class="btn btn-outline">Schedule Now</a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-outline">Get Started</a>
                        @endauth
                    </div>
                </div>

                <div class="pricing-card">
                    <div class="pricing-card-header">
                        <i class="fas fa-iron"></i>
                        <h3>Ironing</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">3.00</span>
                            <span class="unit">per item</span>
                        </div>
                    </div>
                    <div class="pricing-card-body">
                        <p>Professional ironing service</p>
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Professional Ironing</li>
                            <li><i class="fas fa-check"></i> Crisp Finish</li>
                            <li><i class="fas fa-check"></i> Same Day Available</li>
                            <li><i class="fas fa-check"></i> Hanger Ready</li>
                        </ul>
                        @auth
                            <a href="{{ route('schedule.create') }}" class="btn btn-outline">Schedule Now</a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-outline">Get Started</a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Additional Services -->
            <div class="additional-services">
                <h2>Additional Services</h2>
                <div class="services-grid">
                    <div class="service-item">
                        <i class="fas fa-magic"></i>
                        <h4>Stain Removal</h4>
                        <p>$5.00 per item</p>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-feather"></i>
                        <h4>Delicate Items</h4>
                        <p>$4.00 per item</p>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-bed"></i>
                        <h4>Bulky Items</h4>
                        <p>$15.00 per item</p>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-leaf"></i>
                        <h4>Eco-Friendly Detergent</h4>
                        <p>+$3.00 per load</p>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-heart"></i>
                        <h4>Hypoallergenic</h4>
                        <p>+$2.00 per load</p>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-wind"></i>
                        <h4>Fabric Softener</h4>
                        <p>+$1.50 per load</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="pricing-faq">
                <h2>Frequently Asked Questions</h2>
                <div class="faq-items">
                    <div class="faq-item">
                        <h4>Is there a minimum order?</h4>
                        <p>No minimum order required! We're happy to handle any amount of laundry.</p>
                    </div>
                    <div class="faq-item">
                        <h4>How do you calculate weight?</h4>
                        <p>We weigh your items when we pick them up and provide a receipt for transparency.</p>
                    </div>
                    <div class="faq-item">
                        <h4>What if an item gets damaged?</h4>
                        <p>We're insured and will compensate you for any damage caused by our negligence.</p>
                    </div>
                    <div class="faq-item">
                        <h4>Are there any additional fees?</h4>
                        <p>No hidden fees! You only pay for the services you select plus applicable taxes.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>Ready to Get Started?</h2>
                <p>Schedule your first pickup today and experience the convenience of our laundry service.</p>
                @auth
                    <a href="{{ route('schedule.create') }}" class="btn btn-primary btn-large">
                        <i class="fas fa-calendar-plus"></i> Schedule Pickup
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-primary btn-large">
                        <i class="fas fa-user-plus"></i> Sign Up Now
                    </a>
                @endauth
            </div>
        </div>
    </section>
</body>
</html>