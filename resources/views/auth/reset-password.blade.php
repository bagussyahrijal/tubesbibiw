<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - B Laundry</title>
    
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
            <div class="auth-box">
                <div class="auth-header">
                    <div class="auth-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h2 class="auth-title">Reset Your Password</h2>
                    <p class="auth-subtitle">Enter your new password below to complete the reset process.</p>
                </div>

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

                <form class="auth-form" action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <div class="input-group">
                            <div class="input-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <input 
                                type="email" 
                                id="email" 
                                class="form-control" 
                                value="{{ $email }}" 
                                readonly
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">New Password</label>
                        <div class="input-group">
                            <div class="input-icon">
                                <i class="fas fa-lock"></i>
                            </div>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="form-control" 
                                placeholder="Enter your new password" 
                                required 
                                autofocus
                            >
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <i class="fas fa-eye" id="password-eye"></i>
                            </button>
                        </div>
                        <div class="password-requirements">
                            <small>Password must be at least 8 characters long</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm New Password</label>
                        <div class="input-group">
                            <div class="input-icon">
                                <i class="fas fa-lock"></i>
                            </div>
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                class="form-control" 
                                placeholder="Confirm your new password" 
                                required
                            >
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye" id="password_confirmation-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-full">
                        <i class="fas fa-check"></i>
                        Reset Password
                    </button>
                </form>

                <div class="auth-footer">
                    <p>Remember your password? <a href="{{ route('login') }}" class="auth-link">Back to login</a></p>
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

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const eye = document.getElementById(fieldId + '-eye');
            
            if (field.type === 'password') {
                field.type = 'text';
                eye.classList.remove('fa-eye');
                eye.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                eye.classList.remove('fa-eye-slash');
                eye.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>