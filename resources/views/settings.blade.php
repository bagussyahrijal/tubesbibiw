<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - B Laundry</title>
    
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
                <li><a href="{{ route('support') }}">Support</a></li>
            </ul>
            <div class="user-menu">
                <div class="dropdown">
                    <div class="user-avatar">
                        <img src="{{ $user->avatar_url }}" alt="User Avatar">
                    </div>
                    <div class="dropdown-content">
                        <a href="{{ route('profile.show') }}"><i class="fas fa-user"></i> My Profile</a>
                        <a href="{{ route('settings') }}" class="active"><i class="fas fa-cog"></i> Settings</a>
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
                <li><a href="{{ route('settings') }}" class="active"><i class="fas fa-cog"></i> Settings</a></li>
                <li><a href="{{ route('support') }}"><i class="fas fa-headset"></i> Support</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="page-header">
                <h1 class="page-title"><i class="fas fa-cog"></i> Settings</h1>
                <p class="page-subtitle">Manage your account preferences and security settings</p>
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

            <div class="settings-container">
                <!-- Account Settings -->
                <div class="settings-section">
                    <div class="section-header">
                        <div class="section-info">
                            <h2 class="section-title"><i class="fas fa-user-cog"></i> Account Settings</h2>
                            <p class="section-description">Update your personal information</p>
                        </div>
                        <button type="button" class="edit-btn" id="editAccountBtn">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                    </div>

                    <div class="settings-display" id="accountDisplay">
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Full Name</span>
                                <span class="info-value">{{ $user->name }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Email Address</span>
                                <span class="info-value">{{ $user->email }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Phone Number</span>
                                <span class="info-value">{{ $user->phone ?: 'Not provided' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Member Since</span>
                                <span class="info-value">{{ $user->created_at->format('F Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <form class="settings-form" id="accountForm" action="{{ route('settings.account') }}" method="POST" style="display: none;">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" class="form-control" value="{{ $user->phone }}">
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn btn-outline" id="cancelAccountEdit">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>

                <!-- Security Settings -->
                <div class="settings-section">
                    <div class="section-header">
                        <div class="section-info">
                            <h2 class="section-title"><i class="fas fa-shield-alt"></i> Security Settings</h2>
                            <p class="section-description">Manage your password and security preferences</p>
                        </div>
                        <button type="button" class="edit-btn" id="editPasswordBtn">
                            <i class="fas fa-key"></i> Change Password
                        </button>
                    </div>

                    <div class="settings-display" id="passwordDisplay">
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Current Password</span>
                                <span class="info-value">••••••••••••</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Last Changed</span>
                                <span class="info-value">{{ $user->updated_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <form class="settings-form" id="passwordForm" action="{{ route('settings.password') }}" method="POST" style="display: none;">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" id="current_password" name="current_password" class="form-control" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirm New Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn btn-outline" id="cancelPasswordEdit">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Password</button>
                        </div>
                    </form>
                </div>

                <!-- Notification Settings -->
                <div class="settings-section">
                    <div class="section-header">
                        <div class="section-info">
                            <h2 class="section-title"><i class="fas fa-bell"></i> Notification Preferences</h2>
                            <p class="section-description">Choose how you want to receive notifications</p>
                        </div>
                    </div>

                    <form action="{{ route('settings.notifications') }}" method="POST" id="notificationForm">
                        @csrf
                        @method('PUT')
                        <div class="notification-list">
                            <div class="notification-item">
                                <div class="notification-content">
                                    <div class="notification-icon">
                                        <i class="fas fa-clipboard-check"></i>
                                    </div>
                                    <div class="notification-text">
                                        <h4>Order Status Updates</h4>
                                        <p>Get notified when your order status changes (pickup, processing, delivery)</p>
                                    </div>
                                </div>
                                <label class="switch">
                                    <input type="checkbox" name="order_status" {{ $user->notifications_email ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </div>

                            <div class="notification-item">
                                <div class="notification-content">
                                    <div class="notification-icon">
                                        <i class="fas fa-percentage"></i>
                                    </div>
                                    <div class="notification-text">
                                        <h4>Promotions & Offers</h4>
                                        <p>Receive special offers, discounts, and promotional updates</p>
                                    </div>
                                </div>
                                <label class="switch">
                                    <input type="checkbox" name="promotions" {{ $user->promotions_enabled ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </div>

                            <div class="notification-item">
                                <div class="notification-content">
                                    <div class="notification-icon">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                    <div class="notification-text">
                                        <h4>Service Reminders</h4>
                                        <p>Get reminders to schedule your next laundry pickup</p>
                                    </div>
                                </div>
                                <label class="switch">
                                    <input type="checkbox" name="service_reminders" {{ $user->notifications_sms ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Preferences
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Data & Privacy -->
                <div class="settings-section">
                    <div class="section-header">
                        <div class="section-info">
                            <h2 class="section-title"><i class="fas fa-database"></i> Data & Privacy</h2>
                            <p class="section-description">Manage your data and privacy settings</p>
                        </div>
                    </div>

                    <div class="privacy-actions">
                        <div class="privacy-item">
                            <div class="privacy-content">
                                <div class="privacy-icon">
                                    <i class="fas fa-download"></i>
                                </div>
                                <div class="privacy-text">
                                    <h4>Export Your Data</h4>
                                    <p>Download a copy of all your account data in JSON format</p>
                                </div>
                            </div>
                            <a href="{{ route('settings.export') }}" class="btn btn-outline">
                                <i class="fas fa-download"></i> Export Data
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="settings-section danger-zone">
                    <div class="section-header">
                        <div class="section-info">
                            <h2 class="section-title"><i class="fas fa-exclamation-triangle"></i> Danger Zone</h2>
                            <p class="section-description">Irreversible actions - proceed with caution</p>
                        </div>
                    </div>

                    <div class="danger-content">
                        <div class="danger-item">
                            <div class="danger-text">
                                <h4><i class="fas fa-trash-alt"></i> Delete Account</h4>
                                <p>Permanently delete your account and all associated data. This action cannot be undone.</p>
                            </div>
                            <button type="button" class="btn btn-danger" onclick="showDeleteModal()">
                                <i class="fas fa-trash-alt"></i> Delete Account
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Delete Account Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-exclamation-triangle"></i> Confirm Account Deletion</h2>
                <span class="close" onclick="hideDeleteModal()">&times;</span>
            </div>
            <div class="modal-body">
                <div class="warning-box">
                    <i class="fas fa-exclamation-circle"></i>
                    <p><strong>Warning:</strong> This action is permanent and cannot be undone. All your data will be permanently deleted.</p>
                </div>
                <form action="{{ route('settings.delete') }}" method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <div class="form-group">
                        <label for="delete_password">Enter your password to confirm:</label>
                        <input type="password" id="delete_password" name="password" class="form-control" required>
                    </div>
                    <div class="modal-actions">
                        <button type="button" class="btn btn-outline" onclick="hideDeleteModal()">Cancel</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i> Delete My Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Auto-submit notification form when switches are toggled
        document.addEventListener('DOMContentLoaded', function() {
            const notificationSwitches = document.querySelectorAll('#notificationForm input[type="checkbox"]');
            notificationSwitches.forEach(switch_ => {
                switch_.addEventListener('change', function() {
                    // Add a small delay to show the visual feedback
                    setTimeout(() => {
                        document.getElementById('notificationForm').submit();
                    }, 200);
                });
            });

            // Account settings edit toggle
            const editAccountBtn = document.getElementById('editAccountBtn');
            const accountDisplay = document.getElementById('accountDisplay');
            const accountForm = document.getElementById('accountForm');
            const cancelAccountEdit = document.getElementById('cancelAccountEdit');
            
            editAccountBtn.addEventListener('click', function() {
                accountDisplay.style.display = 'none';
                accountForm.style.display = 'block';
            });
            
            cancelAccountEdit.addEventListener('click', function() {
                accountDisplay.style.display = 'block';
                accountForm.style.display = 'none';
            });
            
            // Password settings edit toggle
            const editPasswordBtn = document.getElementById('editPasswordBtn');
            const passwordDisplay = document.getElementById('passwordDisplay');
            const passwordForm = document.getElementById('passwordForm');
            const cancelPasswordEdit = document.getElementById('cancelPasswordEdit');
            
            editPasswordBtn.addEventListener('click', function() {
                passwordDisplay.style.display = 'none';
                passwordForm.style.display = 'block';
            });
            
            cancelPasswordEdit.addEventListener('click', function() {
                passwordDisplay.style.display = 'block';
                passwordForm.style.display = 'none';
                passwordForm.reset();
            });

            // Auto-hide success messages
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

        function showDeleteModal() {
            document.getElementById('deleteModal').style.display = 'block';
        }

        function hideDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
            document.getElementById('deleteForm').reset();
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('deleteModal');
            if (event.target === modal) {
                hideDeleteModal();
            }
        }
    </script>
</body>
</html>