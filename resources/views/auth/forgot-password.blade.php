<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - B Laundry</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="auth-page">
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container navbar-container">
            <a href="{{ route('home') }}" class="logo">
                <i class="fas fa-tshirt"></i>
                B Laundry
            </a>
            <ul class="nav-links">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('home') }}#features">Features</a></li>
                <li><a href="{{ route('home') }}#how-it-works">How It Works</a></li>
                <li><a href="{{ route('pricing') }}">Pricing</a></li>
            </ul>
            <div class="nav-buttons">
                <a href="{{ route('login') }}" class="btn btn-outline">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
            </div>
        </div>
    </nav>

    <!-- Password Reset Section -->
    <section class="auth-section">
        <div class="auth-container">
            <div class="auth-box password-reset-box">
                <div class="auth-header">
                    <div class="auth-icon">
                        <i class="fas fa-key"></i>
                    </div>
                    <h2 class="auth-title">Forgot Your Password?</h2>
                    <p class="auth-subtitle">Enter your email address and we'll send you a link to reset your password.</p>
                </div>

                <!-- Success Message -->
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

                <form class="auth-form" action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <div class="input-group">
                            <div class="input-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="form-control" 
                                placeholder="Enter your email address" 
                                value="{{ old('email') }}"
                                required 
                                autofocus
                            >
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-full">
                        <i class="fas fa-paper-plane"></i>
                        Send Reset Link
                    </button>
                </form>

                <div class="auth-footer">
                    <p>Remember your password? <a href="{{ route('login') }}" class="auth-link">Back to login</a></p>
                </div>
            </div>

            <!-- Additional Help -->
            <div class="help-section">
                <div class="help-item">
                    <div class="help-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="help-content">
                        <h4>Secure Reset</h4>
                        <p>Your password reset link will expire in 60 minutes for security.</p>
                    </div>
                </div>
                <div class="help-item">
                    <div class="help-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="help-content">
                        <h4>Quick Delivery</h4>
                        <p>You should receive the reset email within 2-3 minutes.</p>
                    </div>
                </div>
                <div class="help-item">
                    <div class="help-icon">
                        <i class="fas fa-life-ring"></i>
                    </div>
                    <div class="help-content">
                        <h4>Need Help?</h4>
                        <p>Contact our support team if you don't receive the email.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="auth-footer-section">
        <div class="container">
            <div class="footer-content">
                <div class="footer-links">
                    <a href="{{ route('home') }}">Home</a>
                    <a href="{{ route('pricing') }}">Pricing</a>
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                </div>
                <div class="footer-text">
                    <p>&copy; 2025 B Laundry. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>