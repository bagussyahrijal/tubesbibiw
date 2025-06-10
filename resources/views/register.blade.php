<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - B Laundry</title>
    
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
            <a href="{{ url('/') }}" class="logo">
                <i class="fas fa-tshirt"></i>
                B Laundry
            </a>
            <ul class="nav-links">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/') }}#features">Features</a></li>
                <li><a href="{{ url('/') }}#how-it-works">How It Works</a></li>
                <li><a href="{{ url('/') }}#pricing">Pricing</a></li>
            </ul>
            <div class="nav-buttons">
                <a href="{{ url('/login') }}" class="btn btn-outline">Login</a>
            </div>
        </div>
    </nav>

    <!-- Register Section -->
    <section class="register-section">
        <div class="register-container">
            <div class="register-image">
                <h2>Join B Laundry Today</h2>
                <p>Sign up to enjoy all the benefits of our premium laundry service:</p>
                <ul>
                    <li>Real-time order tracking</li>
                    <li>Flexible pickup & delivery</li>
                    <li>Exclusive member discounts</li>
                    <li>Priority customer support</li>
                    <li>Eco-friendly cleaning</li>
                </ul>
                <div style="margin-top: auto;">
                    <p>Already have an account?</p>
                    <a href="{{ url('/login') }}" class="btn btn-outline" style="color: white; border-color: white;">Login Here</a>
                </div>
            </div>
            <div class="register-form">
                <div class="form-header">
                    <h2>Create Your Account</h2>
                    <p>Fill in your details to get started</p>
                </div>
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
    
    <!-- Keep all your existing form fields below -->
    <div class="name-fields">
        <!-- ... rest of your form stays the same ... -->
                    <div class="name-fields">
                        <div class="form-group">
                            <label for="first-name">First Name</label>
                            <input type="text" id="first-name" name="first_name" class="form-control" placeholder="Enter your first name" required>
                        </div>
                        <div class="form-group">
                            <label for="last-name">Last Name</label>
                            <input type="text" id="last-name" name="last_name" class="form-control" placeholder="Enter your last name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" class="form-control" placeholder="Enter your phone number" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Create a password" required>
                        <div class="password-strength">
                            <div class="password-strength-bar"></div>
                        </div>
                        <p class="password-hint">Use 8 or more characters with a mix of letters, numbers & symbols</p>
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" id="confirm-password" name="password_confirmation" class="form-control" placeholder="Confirm your password" required>
                    </div>
                    <div class="terms">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-register">Create Account</button>
                </form>
                <div class="login-link">
                    <p>Already have an account? <a href="{{ url('/login') }}">Login here</a></p>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Password strength indicator
        const passwordInput = document.getElementById('password');
        const strengthBar = document.querySelector('.password-strength-bar');
        const strengthContainer = document.querySelector('.password-strength');

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            // Check password length
            if (password.length >= 8) strength += 1;
            if (password.length >= 12) strength += 1;
            
            // Check for mixed case
            if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1;
            
            // Check for numbers
            if (password.match(/[0-9]/)) strength += 1;
            
            // Check for special chars
            if (password.match(/[^a-zA-Z0-9]/)) strength += 1;
            
            // Update strength bar
            strengthContainer.className = 'password-strength';
            
            if (password.length > 0) {
                if (strength <= 2) {
                    strengthContainer.classList.add('password-strength-weak');
                } else if (strength === 3) {
                    strengthContainer.classList.add('password-strength-medium');
                } else if (strength === 4) {
                    strengthContainer.classList.add('password-strength-strong');
                } else if (strength >= 5) {
                    strengthContainer.classList.add('password-strength-very-strong');
                }
            }
        });
    </script>
</body>
</html>