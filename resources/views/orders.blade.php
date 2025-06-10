<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - B Laundry</title>
    
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
                <li><a href="{{ route('orders') }}" class="active">My Orders</a></li>
                <li><a href="{{ route('schedule.create') }}">Schedule Pickup</a></li>
                <li><a href="{{ route('pricing') }}">Pricing</a></li>
                <li><a href="{{ route('support') }}">Support</a></li>
            </ul>
            <div class="user-menu">
                <div class="dropdown">
                    <div class="user-avatar">
                        @if(Auth::user()->avatar_url)
                            <img src="{{ Auth::user()->avatar_url }}" alt="User Avatar">
                        @else
                            <i class="fas fa-user-circle"></i>
                        @endif
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
                <li><a href="{{ route('orders') }}" class="active"><i class="fas fa-clipboard-list"></i> My Orders</a></li>
                <li><a href="{{ route('schedule.create') }}"><i class="fas fa-calendar-alt"></i> Schedule Pickup</a></li>
                <li><a href="{{ route('addresses') }}"><i class="fas fa-map-marker-alt"></i> My Addresses</a></li>
                <li><a href="{{ route('payment.methods') }}"><i class="fas fa-credit-card"></i> Payment Methods</a></li>
                <li><a href="{{ route('profile.show') }}"><i class="fas fa-user"></i> My Profile</a></li>
                <li><a href="{{ route('settings') }}"><i class="fas fa-cog"></i> Settings</a></li>
                <li><a href="{{ route('support') }}"><i class="fas fa-headset"></i> Support</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="page-header">
                <h1 class="page-title"><i class="fas fa-clipboard-list"></i> My Orders</h1>
                <p class="page-subtitle">Welcome back, {{ Auth::user()->name }}! Here are your recent orders.</p>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Filter Tabs -->
            <div class="filter-tabs">
                <a href="{{ route('orders', ['status' => 'all']) }}" class="filter-tab {{ $status === 'all' ? 'active' : '' }}">
                    All Orders
                </a>
                <a href="{{ route('orders', ['status' => 'pending']) }}" class="filter-tab {{ $status === 'pending' ? 'active' : '' }}">
                    Pending
                </a>
                <a href="{{ route('orders', ['status' => 'pickup_scheduled']) }}" class="filter-tab {{ $status === 'pickup_scheduled' ? 'active' : '' }}">
                    Scheduled
                </a>
                <a href="{{ route('orders', ['status' => 'processing']) }}" class="filter-tab {{ $status === 'processing' ? 'active' : '' }}">
                    Processing
                </a>
                <a href="{{ route('orders', ['status' => 'delivered']) }}" class="filter-tab {{ $status === 'delivered' ? 'active' : '' }}">
                    Delivered
                </a>
            </div>

            <!-- Order List -->
            <div class="order-list">
                @forelse($orders as $order)
                    <div class="order-card" data-status="{{ $order->status }}">
                        <div class="order-header">
                            <div>
                                <span class="order-id">{{ $order->order_number }}</span>
                                <span class="order-date">
                                    @if($order->status === 'pickup_scheduled')
                                        Scheduled for pickup on {{ $order->pickup_date->format('M d') }} at {{ $order->pickup_time_slot }}
                                    @elseif($order->status === 'delivered' && $order->delivered_at)
                                        Delivered on {{ $order->delivered_at->format('M d, Y g:i A') }}
                                    @elseif($order->status === 'processing' && $order->processing_started_at)
                                        Processing since {{ $order->processing_started_at->format('M d, Y') }}
                                    @elseif($order->status === 'picked_up' && $order->picked_up_at)
                                        Picked up on {{ $order->picked_up_at->format('M d, Y g:i A') }}
                                    @else
                                        Created on {{ $order->created_at->format('M d, Y g:i A') }}
                                    @endif
                                </span>
                            </div>
                            <span class="order-status {{ $order->status_color }}">{{ $order->status_label }}</span>
                        </div>
                        
                        <div class="order-body">
                            <div class="order-details">
                                @if($order->items->count() > 0)
                                    @foreach($order->items->groupBy('service_type') as $serviceType => $items)
                                        <div class="order-service">
                                            <div class="service-icon">
                                                @if($serviceType === 'wash_fold')
                                                    <i class="fas fa-tshirt"></i>
                                                @elseif($serviceType === 'dry_cleaning')
                                                    <i class="fas fa-magic"></i>
                                                @elseif($serviceType === 'ironing')
                                                    <i class="fas fa-iron"></i>
                                                @else
                                                    <i class="fas fa-leaf"></i>
                                                @endif
                                            </div>
                                            <div class="service-info">
                                                <h4>{{ ucwords(str_replace('_', ' & ', $serviceType)) }}</h4>
                                                <p>
                                                    @foreach($items->groupBy('item_type') as $itemType => $itemGroup)
                                                        {{ $itemGroup->sum('quantity') }} {{ ucwords(str_replace('_', ' ', $itemType)) }}{{ $itemGroup->sum('quantity') > 1 ? 's' : '' }}{{ !$loop->last ? ', ' : '' }}
                                                    @endforeach
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <!-- Fallback for orders without items -->
                                    <div class="order-service">
                                        <div class="service-icon">
                                            <i class="fas fa-tshirt"></i>
                                        </div>
                                        <div class="service-info">
                                            <h4>Laundry Service</h4>
                                            <p>{{ $order->estimated_items_count ?? 0 }} items estimated</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="order-timeline">
                                <div class="timeline-item {{ $order->created_at ? 'completed' : '' }}">
                                    <h4>Order Placed</h4>
                                    <p>{{ $order->created_at->format('M d, g:i A') }}</p>
                                </div>
                                <div class="timeline-item {{ $order->scheduled_at ? 'completed' : '' }} {{ $order->status === 'pickup_scheduled' ? 'active' : '' }}">
                                    <h4>Pickup Scheduled</h4>
                                    <p>
                                        @if($order->pickup_date)
                                            {{ $order->pickup_date->format('M d') }}, {{ $order->pickup_time_slot }}
                                        @else
                                            Pending
                                        @endif
                                    </p>
                                </div>
                                <div class="timeline-item {{ $order->picked_up_at ? 'completed' : '' }} {{ $order->status === 'picked_up' ? 'active' : '' }}">
                                    <h4>Pickup</h4>
                                    <p>{{ $order->picked_up_at ? $order->picked_up_at->format('M d, g:i A') : 'Pending' }}</p>
                                </div>
                                <div class="timeline-item {{ $order->processing_started_at ? 'completed' : '' }} {{ $order->status === 'processing' ? 'active' : '' }}">
                                    <h4>Processing</h4>
                                    <p>
                                        @if($order->processing_started_at)
                                            Started {{ $order->processing_started_at->format('M d') }}
                                        @elseif($order->status === 'processing')
                                            In progress
                                        @else
                                            Pending
                                        @endif
                                    </p>
                                </div>
                                <div class="timeline-item {{ $order->ready_at ? 'completed' : '' }} {{ $order->status === 'ready' ? 'active' : '' }}">
                                    <h4>Ready</h4>
                                    <p>{{ $order->ready_at ? $order->ready_at->format('M d') : 'Pending' }}</p>
                                </div>
                                <div class="timeline-item {{ $order->delivered_at ? 'completed' : '' }} {{ in_array($order->status, ['out_for_delivery', 'delivered']) ? 'active' : '' }}">
                                    <h4>Delivery</h4>
                                    <p>
                                        @if($order->delivered_at)
                                            {{ $order->delivered_at->format('M d, g:i A') }}
                                        @elseif($order->status === 'out_for_delivery')
                                            Out for delivery
                                        @elseif($order->delivery_date)
                                            Scheduled: {{ $order->delivery_date->format('M d') }}
                                        @else
                                            Pending
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="order-footer">
                            <div class="order-total">Total: ${{ number_format($order->total_amount, 2) }}</div>
                            <div class="order-actions">
                                <a href="{{ route('orders.show', $order->order_number) }}" class="action-btn outline">
                                    <i class="fas fa-search"></i> Track Order
                                </a>
                                
                                @if(in_array($order->status, ['pending', 'pickup_scheduled']))
                                    <form method="POST" action="{{ route('orders.cancel', $order) }}" style="display: inline;" 
                                          onsubmit="return confirm('Are you sure you want to cancel this order?')">
                                        @csrf
                                        <button type="submit" class="action-btn danger">
                                            <i class="fas fa-times"></i> Cancel Order
                                        </button>
                                    </form>
                                @elseif($order->status === 'delivered')
                                    <button class="action-btn primary" onclick="reorderItems('{{ $order->order_number }}')">
                                        <i class="fas fa-redo"></i> Reorder
                                    </button>
                                @elseif(in_array($order->status, ['processing', 'ready', 'out_for_delivery']))
                                    <a href="{{ route('support') }}" class="action-btn primary">
                                        <i class="fas fa-headset"></i> Contact Support
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="no-orders">
                        <div class="no-orders-icon">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <h3>No Orders Yet</h3>
                        <p>You haven't placed any orders with us yet. Schedule your first pickup today!</p>
                        <a href="{{ route('schedule.create') }}" class="btn btn-primary">
                            <i class="fas fa-calendar-plus"></i> Schedule Pickup
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($orders->hasPages())
                <div class="pagination-wrapper">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            @endif

            <!-- Order Statistics -->
            @if($orders->total() > 0)
                <div class="order-stats">
                    <div class="stats-card">
                        <div class="stats-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="stats-info">
                            <h4>{{ $orders->total() }}</h4>
                            <p>Total Orders</p>
                        </div>
                    </div>
                    <div class="stats-card">
                        <div class="stats-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stats-info">
                            <h4>{{ $orders->where('status', 'processing')->count() }}</h4>
                            <p>In Progress</p>
                        </div>
                    </div>
                    <div class="stats-card">
                        <div class="stats-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stats-info">
                            <h4>{{ $orders->where('status', 'delivered')->count() }}</h4>
                            <p>Completed</p>
                        </div>
                    </div>
                    <div class="stats-card">
                        <div class="stats-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="stats-info">
                            <h4>${{ number_format($orders->sum('total_amount'), 2) }}</h4>
                            <p>Total Spent</p>
                        </div>
                    </div>
                </div>
            @endif
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide success/error messages
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        alert.remove();
                    }, 300);
                }, 5000);
            });

            // Dropdown functionality
            const dropdown = document.querySelector('.dropdown');
            const userAvatar = document.querySelector('.user-avatar');
            const dropdownContent = document.querySelector('.dropdown-content');

            if (userAvatar && dropdownContent) {
                userAvatar.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdownContent.classList.toggle('show');
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function() {
                    dropdownContent.classList.remove('show');
                });
            }
        });

        // Reorder functionality
        function reorderItems(orderNumber) {
            if (confirm('Would you like to schedule a pickup with the same items as order ' + orderNumber + '?')) {
                // Redirect to schedule page with order details
                window.location.href = '{{ route("schedule.create") }}?reorder=' + orderNumber;
            }
        }

        // Real-time order updates (WebSocket or polling could be implemented here)
        function refreshOrderStatus() {
            // This could poll the server for order status updates
            // For now, just reload the page every 30 seconds if there are pending orders
            const pendingOrders = document.querySelectorAll('[data-status="processing"], [data-status="pickup_scheduled"], [data-status="picked_up"]');
            if (pendingOrders.length > 0) {
                setTimeout(() => {
                    window.location.reload();
                }, 30000); // Refresh every 30 seconds
            }
        }

        // Initialize real-time updates
        refreshOrderStatus();
    </script>
</body>
</html>