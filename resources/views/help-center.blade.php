<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B Laundry Laundry - Help Center</title>
    <link rel="stylesheet" href="help-center.css">
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
                <li><a href="help-center.html" class="active">Help Center</a></li>
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
                <li><a href="payment.html"><i class="fas fa-credit-card"></i> Payment Methods</a></li>
                <li><a href="profile.html"><i class="fas fa-user"></i> My Profile</a></li>
                <li><a href="help-center.html" class="active"><i class="fas fa-headset"></i> Help Center</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="help-center">
                <!-- Search Section -->
                <div class="search-section">
                    <h2>How can we help you today?</h2>
                    <p>Search our help center for answers to common questions or browse our categories below.</p>
                    <div class="search-bar">
                        <input type="text" class="search-input" placeholder="Search help articles...">
                        <button class="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Help Categories -->
                <div class="help-categories">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <h3>Getting Started</h3>
                        <p>Learn how to create an account, schedule your first pickup, and use our services.</p>
                        <a href="#" class="category-link">
                            Browse articles <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <h3>Pickup & Delivery</h3>
                        <p>Information about scheduling, tracking, and managing your laundry pickup and delivery.</p>
                        <a href="#" class="category-link">
                            Browse articles <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <h3>Payments & Pricing</h3>
                        <p>Understand our pricing structure, payment methods, and billing questions.</p>
                        <a href="#" class="category-link">
                            Browse articles <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-tshirt"></i>
                        </div>
                        <h3>Services & Care</h3>
                        <p>Learn about our different laundry services and how we care for your clothes.</p>
                        <a href="#" class="category-link">
                            Browse articles <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-user-cog"></i>
                        </div>
                        <h3>Account Management</h3>
                        <p>Help with managing your account, addresses, preferences</p>
                        <a href="#" class="category-link">
                            Browse articles <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h3>Troubleshooting</h3>
                        <p>Solutions for common issues and problems you might encounter.</p>
                        <a href="#" class="category-link">
                            Browse articles <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <!-- FAQ Section -->
                <div class="faq-section">
                    <div class="section-header">
                        <h2><i class="fas fa-question"></i> Frequently Asked Questions</h2>
                    </div>
                    <div class="faq-list">
                        <div class="faq-item">
                            <div class="faq-question">
                                How do I schedule a laundry pickup?
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="faq-answer">
                                <p>To schedule a pickup, log in to your account and go to the "Schedule Pickup" page. Select your pickup address, date, and time window. Choose your services and delivery preferences, then confirm your order. You'll receive a confirmation email with all the details.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <div class="faq-question">
                                What are your operating hours?
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="faq-answer">
                                <p>We offer pickup and delivery services from 8 AM to 8 PM, Monday through Saturday. Our facility processes laundry 24/7 to ensure quick turnaround times. You can schedule pickups anytime through our website or mobile app.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <div class="faq-question">
                                How long does it take to get my laundry back?
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="faq-answer">
                                <p>Standard service has a 48-hour turnaround time. For example, if we pick up on Monday, your laundry will be delivered on Wednesday. We also offer express 24-hour service for an additional fee. Delivery times may vary during holidays or peak periods.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <div class="faq-question">
                                What payment methods do you accept?
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="faq-answer">
                                <p>We accept all major credit cards (Visa, Mastercard, American Express, Discover), debit cards, Apple Pay, Google Pay, and PayPal. We also accept gift cards purchased through our website. All payments are processed securely through our encrypted payment system.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <div class="faq-question">
                                What if I need to cancel or reschedule my pickup?
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="faq-answer">
                                <p>You can cancel or reschedule your pickup up to 2 hours before your scheduled time through your account dashboard. For changes needed within 2 hours of pickup, please contact our customer support team immediately at (555) 123-4567.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Section -->
                <div class="contact-section">
                    <div class="section-header">
                        <h2><i class="fas fa-headset"></i> Still need help? Contact us</h2>
                    </div>
                    <div class="contact-methods">
                        <div class="contact-method">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="contact-info">
                                <h3>Phone Support</h3>
                                <p>Available 8 AM - 8 PM, 7 days a week</p>
                                <a href="tel:+15551234567" class="contact-link">(555) 123-4567</a>
                            </div>
                        </div>
                        <div class="contact-method">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-info">
                                <h3>Email Us</h3>
                                <p>Typically respond within 24 hours</p>
                                <a href="mailto:support@B Laundry.com" class="contact-link">support@B Laundry.com</a>
                            </div>
                        </div>
                        <div class="contact-method">
                            <div class="contact-icon">
                                <i class="fas fa-comment-dots"></i>
                            </div>
                            <div class="contact-info">
                                <h3>Live Chat</h3>
                                <p>Available 9 AM - 6 PM, Monday-Friday</p>
                                <a href="#" class="contact-link">Start Chat</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // FAQ Accordion Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const faqQuestions = document.querySelectorAll('.faq-question');
            
            faqQuestions.forEach(question => {
                question.addEventListener('click', function() {
                    // Toggle active class on question
                    this.classList.toggle('active');
                    
                    // Get the answer element
                    const answer = this.nextElementSibling;
                    
                    // Toggle answer visibility
                    if (this.classList.contains('active')) {
                        answer.classList.add('show');
                    } else {
                        answer.classList.remove('show');
                    }
                    
                    // Close other open answers
                    faqQuestions.forEach(q => {
                        if (q !== this && q.classList.contains('active')) {
                            q.classList.remove('active');
                            q.nextElementSibling.classList.remove('show');
                        }
                    });
                });
            });
            
            // Search functionality would be implemented here
            const searchInput = document.querySelector('.search-input');
            const searchBtn = document.querySelector('.search-btn');
            
            searchBtn.addEventListener('click', function() {
                const searchTerm = searchInput.value.trim();
                if (searchTerm) {
                    alert('In a real application, this would search for: ' + searchTerm);
                    // Here you would implement the search functionality
                    // Either filtering existing content or making an API call
                }
            });
            
            // Allow search on Enter key
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    searchBtn.click();
                }
            });
        });
    </script>
</body>
</html>