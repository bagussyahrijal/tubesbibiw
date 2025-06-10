<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - B Laundry</title>
    
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
                        <a href="{{ route('profile.show') }}" class="active"><i class="fas fa-user"></i> My Profile</a>
                        <a href="#"><i class="fas fa-cog"></i> Settings</a>
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
                <li><a href="{{ route('profile.show') }}" class="active"><i class="fas fa-user"></i> My Profile</a></li>
                <li><a href="{{ route('support') }}"><i class="fas fa-headset"></i> Support</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="page-header">
                <h1 class="page-title"><i class="fas fa-user"></i> My Profile</h1>
            </div>

            <!-- Success Messages -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="profile-container">
                <!-- Profile Sidebar -->
                <div class="profile-sidebar">
                    <div class="profile-card">
                        <div class="profile-avatar">
                            <img src="{{ $user->avatar_url }}" alt="Profile Picture" id="current-avatar">
                        </div>
                        <h3 class="profile-name">{{ $user->name }}</h3>
                        <p class="profile-email">{{ $user->email }}</p>
                        
                        <div class="profile-stats">
                            <div class="stat-item">
                                <div class="stat-value">{{ $totalOrders }}</div>
                                <div class="stat-label">Orders</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">{{ $user->created_at->diffInYears() }}</div>
                                <div class="stat-label">Years</div>
                            </div>
                        </div>
                        
                        <div class="profile-actions">
                            <button class="btn btn-primary" onclick="showAvatarModal()">
                                <i class="fas fa-camera"></i> Change Photo
                            </button>
                            <button class="btn btn-outline" onclick="showPasswordModal()">
                                <i class="fas fa-key"></i> Change Password
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Profile Content -->
                <div class="profile-content">
                    <!-- Personal Information Section -->
                    <div class="profile-section">
                        <div class="section-header">
                            <h3 class="section-title"><i class="fas fa-info-circle"></i> Personal Information</h3>
                            <span class="section-edit" onclick="showEditModal()">Edit</span>
                        </div>
                        
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">First Name</div>
                                <div class="info-value">{{ $user->first_name ?: 'Not provided' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Last Name</div>
                                <div class="info-value">{{ $user->last_name ?: 'Not provided' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Email</div>
                                <div class="info-value">{{ $user->email }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Phone</div>
                                <div class="info-value">{{ $user->phone ?: 'Not provided' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Date of Birth</div>
                                <div class="info-value">{{ $user->date_of_birth ? $user->date_of_birth->format('F d, Y') : 'Not provided' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Member Since</div>
                                <div class="info-value">{{ $memberSince }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Membership Section -->
                    <div class="profile-section">
                        <div class="section-header">
                            <h3 class="section-title"><i class="fas fa-crown"></i> Membership</h3>
                            <span class="section-edit">Upgrade</span>
                        </div>
                        
                        <div class="membership-card {{ $user->membership_type }}">
                            <div class="membership-header">
                                <h4 class="membership-title">{{ $user->membership_title }}</h4>
                                <span class="membership-badge">Active</span>
                            </div>
                            
                            <div class="membership-details">
                                <p>
                                    @if($user->membership_type === 'premium')
                                        Enjoy all the benefits of our premium membership with exclusive discounts and priority service.
                                    @else
                                        Upgrade to premium for exclusive benefits and priority service.
                                    @endif
                                </p>
                            </div>
                            
                            <ul class="membership-features">
                                @if($user->membership_type === 'premium')
                                    <li>15% discount on all orders</li>
                                    <li>Priority pickup and delivery</li>
                                    <li>Free stain treatment on all items</li>
                                    <li>Exclusive eco-friendly packaging</li>
                                @else
                                    <li>Standard service available</li>
                                    <li>Regular pickup and delivery</li>
                                    <li>Basic stain treatment</li>
                                    <li>Standard packaging</li>
                                @endif
                            </ul>
                            
                            <button class="btn btn-outline membership-btn">
                                @if($user->membership_type === 'premium')
                                    <i class="fas fa-star"></i> Manage Membership
                                @else
                                    <i class="fas fa-arrow-up"></i> Upgrade to Premium
                                @endif
                            </button>
                        </div>
                    </div>

                    <!-- Notification Preferences -->
                    <div class="profile-section">
                        <div class="section-header">
                            <h3 class="section-title"><i class="fas fa-bell"></i> Notification Preferences</h3>
                            <span class="section-edit">Edit</span>
                        </div>
                        
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Order Status</div>
                                <div class="info-value">
                                    @if($user->notifications_email && $user->notifications_sms)
                                        Email & SMS
                                    @elseif($user->notifications_email)
                                        Email Only
                                    @elseif($user->notifications_sms)
                                        SMS Only
                                    @else
                                        Disabled
                                    @endif
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Promotions</div>
                                <div class="info-value">{{ $user->promotions_enabled ? 'Enabled' : 'Disabled' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Newsletter</div>
                                <div class="info-value">{{ ucfirst($user->newsletter_frequency) }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Account Alerts</div>
                                <div class="info-value">{{ $user->notifications_email ? 'Enabled' : 'Disabled' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Edit Profile Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-edit"></i> Edit Profile</h2>
                <span class="close" onclick="hideEditModal()">&times;</span>
            </div>
            <form action="{{ route('profile.update') }}" method="POST" class="profile-form">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" class="form-control" value="{{ $user->phone }}">
                </div>

                <div class="form-group">
                    <label for="date_of_birth">Date of Birth</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" value="{{ $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '' }}">
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn btn-outline" onclick="hideEditModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div id="passwordModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-key"></i> Change Password</h2>
                <span class="close" onclick="hidePasswordModal()">&times;</span>
            </div>
            <form action="{{ route('profile.password') }}" method="POST" class="profile-form">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm New Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn btn-outline" onclick="hidePasswordModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Change Avatar Modal -->
    <div id="avatarModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-camera"></i> Change Profile Photo</h2>
                <span class="close" onclick="hideAvatarModal()">&times;</span>
            </div>
            <form action="{{ route('profile.avatar') }}" method="POST" enctype="multipart/form-data" class="profile-form">
                @csrf
                
                <div class="form-group">
                    <label for="avatar">Choose Photo</label>
                    <input type="file" id="avatar" name="avatar" class="form-control" accept="image/*" required>
                    <small>Max file size: 2MB. Supported formats: JPG, PNG, GIF</small>
                </div>

                <div id="avatar-preview" style="display: none;">
                    <img id="preview-image" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 50%;">
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn btn-outline" onclick="hideAvatarModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload Photo</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Modal functionality
        function showEditModal() {
            document.getElementById('editModal').style.display = 'block';
        }

        function hideEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        function showPasswordModal() {
            document.getElementById('passwordModal').style.display = 'block';
        }

        function hidePasswordModal() {
            document.getElementById('passwordModal').style.display = 'none';
        }

        function showAvatarModal() {
            document.getElementById('avatarModal').style.display = 'block';
        }

        function hideAvatarModal() {
            document.getElementById('avatarModal').style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modals = ['editModal', 'passwordModal', 'avatarModal'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        }

        // Avatar preview
        document.getElementById('avatar').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                    document.getElementById('avatar-preview').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>