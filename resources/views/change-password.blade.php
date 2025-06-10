<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B Laundry Laundry - Change Password</title>
    <link rel="stylesheet" href="change-password.css">
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
                <li><a href="payment.html"><i class="fas fa-credit-card"></i> Payment Methods</a></li>
                <li><a href="profile.html"><i class="fas fa-user"></i> My Profile</a></li>
                <li><a href="support.html"><i class="fas fa-headset"></i> Support</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <a href="profile.html" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to My Profile
            </a>
            
            <div class="page-header">
                <h1 class="page-title"><i class="fas fa-key"></i> Change Password</h1>
            </div>

            <form class="password-form" id="changePasswordForm">
                <div class="form-section">
                    <h2 class="section-title"><i class="fas fa-lock"></i> Password Update</h2>
                    
                    <div class="form-group">
                        <label for="current-password">Current Password</label>
                        <input type="password" id="current-password" class="form-control" placeholder="Enter your current password" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="new-password">New Password</label>
                        <input type="password" id="new-password" class="form-control" placeholder="Create a new password" required>
                        <div class="password-strength">
                            <div class="password-strength-bar"></div>
                        </div>
                        <p class="password-hint">Use 8 or more characters with a mix of letters, numbers & symbols</p>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm-password">Confirm New Password</label>
                        <input type="password" id="confirm-password" class="form-control" placeholder="Confirm your new password" required>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-outline" onclick="window.location.href='profile.html'">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </div>
            </form>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('changePasswordForm');
            const newPasswordInput = document.getElementById('new-password');
            const strengthBar = document.querySelector('.password-strength-bar');
            const strengthContainer = document.querySelector('.password-strength');
            
            // Password strength indicator
            newPasswordInput.addEventListener('input', function() {
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
            
            // Form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const currentPassword = document.getElementById('current-password').value;
                const newPassword = document.getElementById('new-password').value;
                const confirmPassword = document.getElementById('confirm-password').value;
                
                // Basic validation
                if (newPassword !== confirmPassword) {
                    alert('New passwords do not match!');
                    return;
                }
                
                if (newPassword.length < 8) {
                    alert('Password must be at least 8 characters long!');
                    return;
                }
                
                // In a real application, this would send the data to your server
                console.log('Password change requested');
                alert('Password updated successfully!');
                window.location.href = 'profile.html';
            });
        });
    </script>
</body>
</html>