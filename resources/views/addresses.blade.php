<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Addresses - B Laundry</title>
    
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
                <li><a href="{{ route('schedule.create') }}"><i class="fas fa-calendar-alt"></i> Schedule Pickup</a></li>
                <li><a href="{{ route('pricing') }}">Pricing</a></li>
                <li><a href="#">Support</a></li>
            </ul>
            <div class="user-menu">
                <div class="dropdown">
                    <div class="user-avatar">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="dropdown-content">
                        <a href="#"><i class="fas fa-user"></i> My Profile</a>
                        <a href="{{ route('settings') }}"><i class="fas fa-cog"></i> Settings</a>
                        <a href="{{ route('payment.methods') }}"><i class="fas fa-credit-card"></i> Payment Methods</a></li>
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
                <li><a href="{{ route('addresses') }}" class="active"><i class="fas fa-map-marker-alt"></i> My Addresses</a></li>
                <li><a href="{{ route('payment.methods') }}"><i class="fas fa-credit-card"></i> Payment Methods</a></li>
                <li><a href="{{ route('profile.show') }}"><i class="fas fa-user"></i> My Profile</a></li>
                <li><a href="{{ route('support') }}"><i class="fas fa-headset"></i> Support</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="page-header">
                <h1 class="page-title"><i class="fas fa-map-marker-alt"></i> My Addresses</h1>
                <p class="page-subtitle">Manage your pickup and delivery addresses</p>
            </div>

            <!-- Add Address Button -->
            <div class="page-actions">
                <a href="{{ route('addresses.add') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Address
                </a>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Address List -->
            @if($addresses->count() > 0)
                <div class="address-list">
                    @foreach($addresses as $address)
                        <div class="address-card">
                            <div class="address-header">
                                <div class="address-type">
                                    <i class="fas fa-{{ $address->address_type === 'home' ? 'home' : ($address->address_type === 'work' ? 'building' : 'map-marker-alt') }}"></i>
                                    <span>{{ $address->display_name }}</span>
                                </div>
                                <div class="address-badges">
                                    @if($address->is_default)
                                        <span class="badge default">Default</span>
                                    @endif
                                    @if($address->pickup_address)
                                        <span class="badge pickup">Pickup</span>
                                    @endif
                                    @if($address->delivery_address)
                                        <span class="badge delivery">Delivery</span>
                                    @endif
                                </div>
                            </div>
                            <div class="address-content">
                                <h3>{{ $address->full_name }}</h3>
                                <p class="address-line">{{ $address->full_address }}</p>
                                <p class="address-line">{{ $address->phone }}</p>
                                @if($address->instructions)
                                    <p class="address-line"><strong>Instructions:</strong> {{ $address->instructions }}</p>
                                @endif
                            </div>
                            <div class="address-actions">
                                <button class="action-btn edit">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form method="POST" action="{{ route('addresses.destroy', $address) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this address?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                                @if(!$address->is_default)
                                    <form method="POST" action="{{ route('addresses.setDefault', $address) }}" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="action-btn default">
                                            <i class="fas fa-star"></i> Set Default
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- No Addresses State -->
                <div class="no-addresses">
                    <i class="fas fa-map-marker-alt"></i>
                    <h3>No Addresses Yet</h3>
                    <p>Add your first address to schedule pickups and deliveries.</p>
                    <a href="{{ route('addresses.add') }}" class="btn btn-primary">Add Address</a>
                </div>
            @endif
        </main>
    </div>
</body>
</html>