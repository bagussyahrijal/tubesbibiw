<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B Laundry - Admin Dashboard (Charts + Firebase Prep)</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @vite(['resources/css/admin-dashboard.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <nav class="navbar">
        <div class="container navbar-container">
            <a href="#" class="logo">
                <i class="fas fa-tshirt"></i>
                B Laundry
            </a>
            <ul class="nav-links">
                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('admin.orders') }}">Manage Orders</a></li>
                <li><a href="{{ route('admin.users') }}">Manage Users</a></li>
            </ul>
            <div class="user-menu">
                <div class="dropdown" id="userDropdown">
                    <div class="user-avatar" id="userAvatarToggle"> <img
                            src="https://randomuser.me/api/portraits/men/46.jpg" alt="Admin Avatar">
                    </div>
                    <div class="dropdown-content" id="userDropdownContent"> <a
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="dashboard">
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="{{ route('admin.dashboard') }}" class="active"><i class="fas fa-tachometer-alt"></i>
                        Dashboard</a></li>
                <li><a href="{{ route('admin.orders') }}"><i class="fas fa-tasks"></i> Manage Orders</a></li>
                <li><a href="{{ route('admin.users') }}"><i class="fas fa-users-cog"></i> Manage Users</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="welcome-banner">
                <div class="welcome-text">
                    <h1>Admin Dashboard</h1>
                    <p>Manage all aspects of B-Laundry operations from here.</p>
                </div>
            </div>

            <div class="dashboard-cards">
                <div class="dashboard-card">
                    <div class="card-header">
                        <div class="card-title">Total Revenue (Overall)</div>
                        <div class="card-icon success"><i class="fas fa-wallet"></i></div>
                    </div>
                    <div class="card-value">Rp{{ number_format($totalFinishedCost, 0, ',', '.') }}
                    </div>
                </div>
                <div class="dashboard-card">
                    <div class="card-header">
                        <div class="card-title">Total Orders (Overall)</div>
                        <div class="card-icon primary"><i class="fas fa-box-open"></i></div>
                    </div>
                    <div class="card-value" id="totalOrdersValue">{{ $totalOrders }}</div>
                </div>
                <div class="dashboard-card">
                    <div class="card-header">
                        <div class="card-title">Active Users</div>
                        <div class="card-icon warning"><i class="fas fa-users"></i></div>
                    </div>
                    <div class="card-value" id="activeUsersValue">{{ $totalUsers }}</div>
                </div>
            </div>

            <div class="section-title">
                <i class="fas fa-chart-pie"></i> Operational Data Visualization
            </div>
            <div class="charts-grid">
                <div class="chart-container">
                    <h3 class="chart-title">Order Status Distribution (Overall)</h3>
                    <canvas id="orderStatusChart" class="h-20"></canvas>
                </div>
                <div class="chart-container">
                    <h3 class="chart-title">Daily Revenue (Last 7 Days)</h3>
                    <canvas id="dailyRevenueChart"></canvas>
                </div>
            </div>
            <div class="section-title">
                <i class="fas fa-clipboard-list"></i> Recent Orders (All Users)
            </div>
            <div class="orders-table">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Pelanggan</th>
                            <th>Nomor Telepon</th>
                            <th>Alamat</th>
                            <th>Item</th>
                            <th>Total Cost</th>
                            <th>Status Order</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentOrders as $order)
                            <tr>
                                <td>{{ $order['customerName'] ?? '-' }}</td>
                                <td>{{ $order['phone'] ?? '-' }}</td>
                                <td>{{ $order['address'] ?? '-' }}</td>
                                <td>{{ $order['item'] ?? '-' }}</td>
                                <td>Rp{{ number_format($order['totalCost'] ?? 0, 0, ',', '.') }}</td>
                                <td>{{ $order['status'] ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const recentOrders = {!! json_encode($recentOrders) !!};
        console.log('recentOrders:', recentOrders); // Order Status Chart
        const orderStatusRawData = [{
                status: 'Payment',
                count: {{ $statusCounts['Payment'] }},
                color: '#e67e22'
            },
            {
                status: 'Pending to Process',
                count: {{ $statusCounts['Pending to Process'] }},
                color: '#2ecc71'
            },
            {
                status: 'Processed',
                count: {{ $statusCounts['Processed'] }},
                color: '#e74c3c'
            },
            {
                status: 'Finished',
                count: {{ $statusCounts['Finished'] }},
                color: '#7f8c8d'
            }
        ];
        const statusLabels = orderStatusRawData.map(item => item.status);
        const statusCounts = orderStatusRawData.map(item => item.count);
        const statusColors = orderStatusRawData.map(item => item.color);

        const orderStatusChartData = {
            labels: statusLabels,
            datasets: [{
                data: statusCounts,
                backgroundColor: statusColors
            }]
        };

        document.addEventListener('DOMContentLoaded', function() {
            const ctxStatus = document.getElementById('orderStatusChart');
            if (ctxStatus) {
                new Chart(ctxStatus.getContext('2d'), {
                    type: 'doughnut',
                    data: orderStatusChartData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }

            // Daily Revenue Chart
            const dailyRevenueLabels = {!! json_encode(collect($dailyRevenue)->pluck('date')->map(fn($d) => date('M d', strtotime($d)))) !!};
            const dailyRevenueData = {!! json_encode(collect($dailyRevenue)->pluck('total')) !!};

            const ctxRevenue = document.getElementById('dailyRevenueChart');
            if (ctxRevenue) {
                new Chart(ctxRevenue.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: dailyRevenueLabels,
                        datasets: [{
                            label: 'Revenue ($)',
                            data: dailyRevenueData,
                            borderColor: '#e74c3c',
                            backgroundColor: 'rgba(231, 76, 60, 0.1)',
                            tension: 0.2,
                            fill: true,
                            pointBackgroundColor: '#e74c3c',
                            pointBorderColor: '#fff',
                            pointHoverRadius: 7,
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: '#e74c3c'
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            const userAvatarToggle = document.getElementById('userAvatarToggle');
            const userDropdownContent = document.getElementById('userDropdownContent');
            const userDropdown = document.getElementById('userDropdown'); // Tambahkan ini

            if (userAvatarToggle && userDropdownContent) {
                userAvatarToggle.addEventListener('click', function() {
                    // Toggle class 'show' untuk menampilkan/menyembunyikan dropdown
                    userDropdownContent.classList.toggle('show');
                });

                // Optional: Tutup dropdown saat klik di luar area dropdown
                document.addEventListener('click', function(event) {
                    // Periksa apakah klik terjadi di luar elemen .dropdown
                    if (userDropdown && !userDropdown.contains(event.target)) {
                        if (userDropdownContent.classList.contains('show')) {
                            userDropdownContent.classList.remove('show');
                        }
                    }
                });
            }
        });
    </script>

</body>

</html>
