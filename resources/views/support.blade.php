<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Center - B Laundry</title>
    
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
                <li><a href="{{ route('support') }}" class="active">Support</a></li>
            </ul>
            <div class="user-menu">
                <div class="dropdown">
                    <div class="user-avatar">
                        <img src="{{ $user->avatar_url }}" alt="User Avatar">
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
                <li><a href="{{ route('payment.methods') }}"><i class="fas fa-credit-card"></i> Payment Methods</a></li>
                <li><a href="{{ route('profile.show') }}"><i class="fas fa-user"></i> My Profile</a></li>
                <li><a href="{{ route('support') }}" class="active"><i class="fas fa-headset"></i> Support</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="page-header">
                <h1 class="page-title"><i class="fas fa-headset"></i> Support Center</h1>
                <p class="page-subtitle">We're here to help you with any questions or concerns</p>
            </div>

            <!-- Success Messages -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="support-container">
                <!-- Quick Actions -->
                <div class="quick-actions">
                    <div class="quick-action" onclick="document.getElementById('contactForm').scrollIntoView()">
                        <i class="fas fa-envelope"></i>
                        <span>Send Message</span>
                    </div>
                    <div class="quick-action" onclick="window.open('tel:+15551234567')">
                        <i class="fas fa-phone"></i>
                        <span>Call Now</span>
                    </div>
                    <div class="quick-action" onclick="window.open('https://api.whatsapp.com/send?phone=15551234567', '_blank')">
                        <i class="fab fa-whatsapp"></i>
                        <span>WhatsApp</span>
                    </div>
                    <div class="quick-action" onclick="document.getElementById('faqSection').scrollIntoView()">
                        <i class="fas fa-question-circle"></i>
                        <span>View FAQ</span>
                    </div>
                </div>

                <!-- FAQ Section -->
                <div class="support-section" id="faqSection">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <h2 class="section-title">Frequently Asked Questions</h2>
                        <p class="section-subtitle">Find quick answers to common questions</p>
                    </div>
                    <div class="section-content">
                        <div class="faq-list">
                            @foreach($faqItems as $index => $faq)
                                <div class="faq-item">
                                    <div class="faq-question" onclick="toggleFaq({{ $index }})">
                                        <span>{{ $faq['question'] }}</span>
                                        <i class="fas fa-chevron-down faq-icon"></i>
                                    </div>
                                    <div class="faq-answer" id="faq-{{ $index }}">
                                        <p>{{ $faq['answer'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Contact Form Section -->
                <div class="support-section" id="contactForm">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h2 class="section-title">Contact Our Team</h2>
                        <p class="section-subtitle">Can't find what you're looking for? Send us a message</p>
                    </div>
                    <div class="section-content">
                        <form class="contact-form" action="{{ route('support.store') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="name">Your Name</label>
                                    <input type="text" id="name" class="form-control" value="{{ $user->name }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="email">Your Email</label>
                                    <input type="email" id="email" class="form-control" value="{{ $user->email }}" readonly>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <select id="subject" name="subject" class="form-control" required>
                                    <option value="">Select a subject</option>
                                    <option value="order">Order Question</option>
                                    <option value="pickup">Pickup Issue</option>
                                    <option value="delivery">Delivery Problem</option>
                                    <option value="billing">Billing Inquiry</option>
                                    <option value="quality">Quality Concern</option>
                                    <option value="account">Account Issue</option>
                                    <option value="feedback">Feedback</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea id="message" name="message" class="form-control" placeholder="Please describe your issue in detail..." rows="6" required></textarea>
                            </div>
                            
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i>
                                    Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Additional Support Options -->
                <div class="support-section">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <h2 class="section-title">Other Ways to Reach Us</h2>
                        <p class="section-subtitle">Choose the method that works best for you</p>
                    </div>
                    <div class="section-content">
                        <div class="support-options">
                            <div class="support-option" onclick="window.open('tel:+15551234567')">
                                <div class="option-icon phone">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="option-content">
                                    <div class="option-title">Call Us</div>
                                    <div class="option-text">Available 8AM-8PM daily</div>
                                    <div class="option-link">(555) 123-4567</div>
                                </div>
                                <div class="option-status online">
                                    <i class="fas fa-circle"></i>
                                    <span>Online</span>
                                </div>
                            </div>
                            
                            <div class="support-option" onclick="window.open('mailto:support@blazandry.com')">
                                <div class="option-icon email">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="option-content">
                                    <div class="option-title">Email Us</div>
                                    <div class="option-text">Response within 2 hours</div>
                                    <div class="option-link">support@blazandry.com</div>
                                </div>
                                <div class="option-status online">
                                    <i class="fas fa-circle"></i>
                                    <span>Active</span>
                                </div>
                            </div>
                            
                            <div class="support-option" onclick="window.open('https://api.whatsapp.com/send?phone=15551234567', '_blank')">
                                <div class="option-icon whatsapp">
                                    <i class="fab fa-whatsapp"></i>
                                </div>
                                <div class="option-content">
                                    <div class="option-title">WhatsApp</div>
                                    <div class="option-text">Chat with our support team</div>
                                    <div class="option-link">Start Chat</div>
                                </div>
                                <div class="option-status online">
                                    <i class="fas fa-circle"></i>
                                    <span>Online</span>
                                </div>
                            </div>
                            
                            <div class="support-option" onclick="window.open('https://www.facebook.com/blazandry', '_blank')">
                                <div class="option-icon social">
                                    <i class="fab fa-facebook-messenger"></i>
                                </div>
                                <div class="option-content">
                                    <div class="option-title">Live Chat</div>
                                    <div class="option-text">Instant messaging support</div>
                                    <div class="option-link">Start Chat</div>
                                </div>
                                <div class="option-status online">
                                    <i class="fas fa-circle"></i>
                                    <span>Online</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Support Hours -->
                <div class="support-hours">
                    <h3><i class="fas fa-clock"></i> Support Hours</h3>
                    <div class="hours-grid">
                        <div class="hours-item">
                            <span class="day">Monday - Friday</span>
                            <span class="time">8:00 AM - 8:00 PM</span>
                        </div>
                        <div class="hours-item">
                            <span class="day">Saturday</span>
                            <span class="time">9:00 AM - 6:00 PM</span>
                        </div>
                        <div class="hours-item">
                            <span class="day">Sunday</span>
                            <span class="time">10:00 AM - 4:00 PM</span>
                        </div>
                        <div class="hours-item emergency">
                            <span class="day">Emergency</span>
                            <span class="time">24/7 Available</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function toggleFaq(index) {
            const answer = document.getElementById(`faq-${index}`);
            const question = answer.previousElementSibling;
            const icon = question.querySelector('.faq-icon');
            
            // Close all other FAQs
            document.querySelectorAll('.faq-answer').forEach((el, i) => {
                if (i !== index) {
                    el.classList.remove('show');
                    el.previousElementSibling.classList.remove('active');
                    el.previousElementSibling.querySelector('.faq-icon').style.transform = 'rotate(0deg)';
                }
            });
            
            // Toggle current FAQ
            answer.classList.toggle('show');
            question.classList.toggle('active');
            
            if (answer.classList.contains('show')) {
                icon.style.transform = 'rotate(180deg)';
            } else {
                icon.style.transform = 'rotate(0deg)';
            }
        }

        // Auto-hide success messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const successAlert = document.querySelector('.alert-success');
            if (successAlert) {
                setTimeout(() => {
                    successAlert.style.opacity = '0';
                    setTimeout(() => {
                        successAlert.remove();
                    }, 300);
                }, 5000);
            }
        });
    </script>
</body>
</html>