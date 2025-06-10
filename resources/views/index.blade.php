<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B Laundry - Dashboard</title>
    
    <!-- Include Laravel CSRF token in meta tag -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Use Vite for CSS and JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Include Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Tailwind CDN as fallback -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    @stack('styles')
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
                <li><a href="#">Home</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="#how-it-works">How It Works</a></li>
                <li><a href="#pricing">Pricing</a></li>
                <li><a href="#testimonials">Testimonials</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
            <div class="nav-buttons">
                <a href="{{ url('/login') }}" class="btn btn-outline">Login</a>
                <a href="{{ url('/register') }}" class="btn btn-primary">Register</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Smart Laundry Management</h1>
            <p>Track your laundry, schedule pickups, and manage your orders all in one place. Our dashboard makes laundry day easier than ever.</p>
            <a href="{{ url('/register') }}" class="btn btn-primary">Get Started</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-title">
                <h2>Why Choose Our Service</h2>
                <p>We provide the best laundry experience with our advanced tracking system and premium services</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>Real-time Tracking</h3>
                    <p>Track your laundry in real-time from pickup to delivery. Know exactly when your clothes will be ready.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3>Flexible Scheduling</h3>
                    <p>Schedule pickups and deliveries at your convenience. We work around your busy life.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h3>Smart Notifications</h3>
                    <p>Get instant notifications about your order status and receive alerts when your laundry is on its way.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works" id="how-it-works">
        <div class="container">
            <div class="section-title">
                <h2>How It Works</h2>
                <p>Getting your laundry done has never been easier with our simple 4-step process</p>
            </div>
            <div class="steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <h3>Schedule Pickup</h3>
                    <p>Choose a pickup time that works for you through our app or website.</p>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <h3>We Collect</h3>
                    <p>Our professional team will collect your laundry at the scheduled time.</p>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <h3>We Clean</h3>
                    <p>Your clothes are cleaned with premium detergents and cared for by experts.</p>
                </div>
                <div class="step">
                    <div class="step-number">4</div>
                    <h3>Delivery</h3>
                    <p>Your fresh, clean laundry is delivered back to you at your chosen time.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing" id="pricing">
        <div class="container">
            <div class="section-title">
                <h2>Simple, Transparent Pricing</h2>
                <p>Choose the plan that works best for your laundry needs</p>
            </div>
            <div class="pricing-cards">
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>Basic Wash</h3>
                        <div class="price">$15<span>/bag</span></div>
                        <p>Perfect for small loads</p>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Wash & Fold Service</li>
                            <li><i class="fas fa-check"></i> Standard Detergent</li>
                            <li><i class="fas fa-check"></i> 48-Hour Turnaround</li>
                            <li><i class="fas fa-check"></i> Up to 15 lbs per bag</li>
                            <li><i class="fas fa-check"></i> Basic Packaging</li>
                        </ul>
                        <a href="#" class="btn btn-outline btn-block">Choose Plan</a>
                    </div>
                </div>
                <div class="pricing-card">
                    <div class="pricing-header" style="background-color: var(--secondary-color);">
                        <h3>Premium Care</h3>
                        <div class="price">$25<span>/bag</span></div>
                        <p>For delicate and special fabrics</p>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Premium Wash & Fold</li>
                            <li><i class="fas fa-check"></i> Hypoallergenic Detergent</li>
                            <li><i class="fas fa-check"></i> 24-Hour Turnaround</li>
                            <li><i class="fas fa-check"></i> Up to 15 lbs per bag</li>
                            <li><i class="fas fa-check"></i> Eco-Friendly Packaging</li>
                        </ul>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-block">Choose Plan</a>
                    </div>
                </div>
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>Monthly Unlimited</h3>
                        <div class="price">$99<span>/month</span></div>
                        <p>Best for families</p>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Unlimited Wash & Fold</li>
                            <li><i class="fas fa-check"></i> Premium Detergent</li>
                            <li><i class="fas fa-check"></i> 24-Hour Turnaround</li>
                            <li><i class="fas fa-check"></i> Up to 4 bags per week</li>
                            <li><i class="fas fa-check"></i> Eco-Friendly Packaging</li>
                        </ul>
                        <a href="#" class="btn btn-outline btn-block">Choose Plan</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials" id="testimonials">
        <div class="container">
            <div class="section-title">
                <h2>What Our Customers Say</h2>
                <p>Don't just take our word for it - hear from our satisfied customers</p>
            </div>
            <div class="testimonial-cards">
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "B Laundry efisien banget. Applikasinya mudah digunakan. Sangat membantu anak kos seperti saya yang sibuk. Laundry saya selalu bersih dan wangi!"
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Sarah J.">
                        </div>
                        <div class="author-info">
                            <h4>Sarah J.</h4>
                            <p>Regular Customer</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "Sebagai seorang profesional yang sibuk, layanan laundry B Laundry sangat membantu saya menghemat waktu. Saya bisa fokus pada pekerjaan saya tanpa khawatir tentang cucian."
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <img src="https://randomuser.me/api/portraits/men/54.jpg" alt="Michael T.">
                        </div>
                        <div class="author-info">
                            <h4>Michael T.</h4>
                            <p>Monthly Subscriber</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "Layanan premium mereka luar biasa! Saya sangat puas dengan hasil cucian saya. Mereka menangani pakaian saya dengan sangat hati-hati dan selalu mengembalikannya dalam kondisi sempurna."
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Priya K.">
                        </div>
                        <div class="author-info">
                            <h4>Priya K.</h4>
                            <p>Premium Customer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2>Ready to Simplify Your Laundry?</h2>
            <p>Join thousands of happy customers who save hours every week with our convenient laundry service.</p>
            <a href="{{ url('/register') }}" class="btn btn-primary">Get Started Now</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="contact">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h3>B Laundry</h3>
                    <p>Making laundry day easier with our smart tracking system and premium services.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="#">Home</a></li>
                        <li><a href="#features">Features</a></li>
                        <li><a href="#how-it-works">How It Works</a></li>
                        <li><a href="#pricing">Pricing</a></li>
                        <li><a href="#testimonials">Testimonials</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3>Services</h3>
                    <ul class="footer-links">
                        <li><a href="#">Wash & Fold</a></li>
                        <li><a href="#">Dry Cleaning</a></li>
                        <li><a href="#">Premium Care</a></li>
                        <li><a href="#">Stain Removal</a></li>
                        <li><a href="#">Alterations</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3>Contact Us</h3>
                    <ul class="footer-links">
                        <li><i class="fas fa-map-marker-alt"></i> Komplek Pesona Bali No. 13</li>
                        <li><i class="fas fa-phone"></i> (0778) 123-4567</li>
                        <li><i class="fas fa-envelope"></i> hello@B Laundry.com</li>
                        <li><i class="fas fa-clock"></i> Mon-Sat: 8AM-8PM</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 B Laundry Laundry Services. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>