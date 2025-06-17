<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - B Laundry</title>

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
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('home') }}#features">Features</a></li>
                <li><a href="{{ route('home') }}#how-it-works">How It Works</a></li>
            </ul>
            <div class="nav-buttons">
                <a href="{{ route('register') }}" class="btn btn-outline">Register</a>
            </div>
        </div>
    </nav>

    <!-- Login Section -->
    <section class="login-section">
        <div class="login-container">
            <div class="login-image">
                <h2>Welcome Back!</h2>
                <p>Track your laundry orders, view order history, and manage your account all in one place.</p>
                <div style="margin-top: auto;">
                    <p>Don't have an account?</p>
                    <a href="{{ route('register') }}" class="btn btn-outline" style="color: white; border-color: white;">Create Account</a>
                </div>
            </div>
            <div class="login-form">
                <div class="form-header">
                    <h2>Login to Your Account</h2>
                    <p>Enter your credentials to access your dashboard</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control"
                               placeholder="Enter your email" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control"
                               placeholder="Enter your password" required>
                    </div>

                    <div class="remember-forgot">
                        <div class="remember-me">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Remember me</label>
                        </div>
                        <a href="{{ route('password.request') }}" class="forgot-password">Forgot password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary btn-login">Login</button>
                </form>

                <div class="social-login">
                    <p>Or login with</p>
                    <div class="social-icons">
                        <a href="#" class="social-icon">
                            <i class="fab fa-google"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-apple"></i>
                        </a>
                    </div>
                </div>

                <div class="register-link">
                    <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
