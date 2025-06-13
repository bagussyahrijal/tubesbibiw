<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - B Laundry</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container navbar-container">
            <a href="/" class="logo">
                <i class="fas fa-tshirt"></i>
                B Laundry
            </a>
            <div class="nav-buttons">
                <span style="margin-right: 1rem; font-weight: 500;">Welcome, {{ Auth::user()->name }}!</span>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-outline">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Dashboard Content -->
    <div class="container" style="padding: 2rem 0;">
        <div class="dashboard-header">
            <h1>Welcome to Your Dashboard!</h1>
            <p><strong>Hello, {{ Auth::user()->name }}!</strong></p>
            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
            @if(Auth::user()->phone)
                <p><strong>Phone:</strong> {{ Auth::user()->phone }}</p>
            @endif
        </div>

        <div class="dashboard-content">
            <div class="dashboard-cards">
                <div class="dashboard-card">
                    <i class="fas fa-shopping-cart"></i>
                    <h3>My Orders</h3>
                    <p>Track your laundry orders</p>
                    <a href="{{ route('orders') }}" class="btn btn-primary">View Orders</a>
                </div>

                <div class="dashboard-card">
                    <i class="fas fa-user"></i>
                    <h3>Profile</h3>
                    <p>Manage your account settings</p>
                    <a href="{{ route('profile.show') }}" class="btn btn-primary">Edit Profile</a>
                </div>

                <div class="dashboard-card">
                    <i class="fas fa-history"></i>
                    <h3>Order History</h3>
                    <p>View past orders and receipts</p>
                    <a href="#" class="btn btn-primary">View History</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
