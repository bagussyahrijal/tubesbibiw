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
                <div class="dropdown">
                    <div class="user-avatar">
                        <img src="https://randomuser.me/api/portraits/men/46.jpg" alt="Admin Avatar">
                    </div>
                    <div class="dropdown-content">
                        <a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
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
                        <div class="card-title">Total Amount (Overall)</div>
                        <div class="card-icon success"><i class="fas fa-wallet"></i></div>
                    </div>
                    <div class="card-value" id="totalAmountValue">${{ $totalAmount }}</div>
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
                    <canvas id="orderStatusChart"></canvas>
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
                            <th>Order ID</th>
                            <th>User</th>
                            <th>Date Placed</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="recentOrdersTableBody">
                        @foreach ($orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->user->name ?? '-' }}</td>
                                <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                                <td>
                                    @php
                                        // Jika $order->services adalah JSON string, decode dulu
                                        $servicesArray = is_array($order->services)
                                            ? $order->services
                                            : json_decode($order->services, true);
                                        $serviceItems = isset($servicesArray[0]['items'])
                                            ? $servicesArray[0]['items']
                                            : [];
                                    @endphp
                                    @if ($serviceItems)
                                        @foreach ($serviceItems as $item)
                                            {{ ucwords(str_replace('_', ' ', $item['type'])) }}
                                            ({{ $item['quantity'] }})
                                            {{ !$loop->last ? ', ' : '' }}
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>${{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    <span
                                        class="status {{ strtolower($order->status) }}">{{ ucfirst($order->status) }}</span>
                                </td>
                                <td>
                                    <button class="action-btn" title="View Details"><i class="fas fa-eye"></i></button>
                                    <button class="action-btn" title="Update Status"><i
                                            class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Admin Dashboard (Charts + Firebase Prep) loaded.');

            const orderStatusDetailValue = document.getElementById('orderStatusDetailValue');

            // --- DATA UNTUK GRAFIK (Contoh Statis) ---
            // Firebase Prep: Order Status Distribution
            // Data ini akan diagregasi dari collection 'orders' di Firestore.
            // Anda perlu menghitung jumlah pesanan untuk setiap status yang relevan.
            // Misal, jika status di DB Anda adalah 'Payment', 'Pending to Process', 'Processed', 'Finished'.
            // Anda akan memetakannya ke label 'Unpaid', 'Pending', 'Processing', 'Completed' untuk grafik.
            // const counts = { unpaid: 0, pending: 0, processing: 0, completed: 0 };
            // const querySnapshot = await getDocs(collection(db, "orders"));
            // querySnapshot.forEach((doc) => {
            //   const status = doc.data().status;
            //   if (status === 'Payment') counts.unpaid++;
            //   else if (status === 'Pending to Process') counts.pending++;
            //   else if (status === 'Processed') counts.processing++;
            //   else if (status === 'Finished') counts.completed++;
            // });
            // const orderStatusRawData = [
            //   { status: 'Unpaid', count: counts.unpaid, color: '#6c757d' },
            //   { status: 'Pending', count: counts.pending, color: '#ffc107' },
            //   { status: 'Processing', count: counts.processing, color: '#007bff' },
            //   { status: 'Completed', count: counts.completed, color: '#28a745' }
            // ];
            // Kemudian gunakan orderStatusRawData untuk chart.
            const orderStatusRawData = [{
                    status: 'Pending',
                    count: {{ $statusCounts['Pending'] }},
                    color: '#e67e22'
                },
                {
                    status: 'Paid',
                    count: {{ $statusCounts['Paid'] }},
                    color: '#2ecc71'
                },
                {
                    status: 'Failed',
                    count: {{ $statusCounts['Failed'] }},
                    color: '#e74c3c'
                },
                {
                    status: 'Refunded',
                    count: {{ $statusCounts['Refunded'] }},
                    color: '#7f8c8d'
                }
            ];

            // Siapkan data untuk Chart.js
            const statusLabels = orderStatusRawData.map(item => item.status);
            const statusCounts = orderStatusRawData.map(item => item.count);
            const statusColors = orderStatusRawData.map(item => item.color);

            // Pie Chart untuk Order Status
            const ctx = document.getElementById('orderStatusChart').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        data: statusCounts,
                        backgroundColor: statusColors
                    }]
                },
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

            // Firebase Prep: Daily Revenue (Last 7 Days)
            // Data ini memerlukan agregasi dari 'orders' yang statusnya 'Finished' (atau lunas)
            // dikelompokkan per hari untuk 7 hari terakhir.
            // Ini lebih kompleks dan idealnya dilakukan oleh backend/Cloud Function yang menyimpan
            // agregasi harian, atau Anda mengambil data order 7 hari terakhir lalu proses di client.
            // const revenueByDay = {}; // { 'YYYY-MM-DD': totalRevenue }
            // const sevenDaysAgo = new Date();
            // sevenDaysAgo.setDate(sevenDaysAgo.getDate() - 7);
            // const q = query(collection(db, "orders"),
            //                 where("completionDate", ">=", sevenDaysAgo), // asumsikan ada field completionDate (Timestamp)
            //                 where("status", "==", "Finished"));
            // const querySnapshot = await getDocs(q);
            // querySnapshot.forEach((doc) => {
            //   const order = doc.data();
            //   const day = new Date(order.completionDate.seconds * 1000).toISOString().split('T')[0];
            //   revenueByDay[day] = (revenueByDay[day] || 0) + order.totalCost;
            // });
            // // Kemudian format revenueByDay menjadi struktur labels dan data untuk chart.
            const dailyRevenueData = {
                labels: ['May 27', 'May 28', 'May 29', 'May 30', 'May 31', 'Jun 1', 'Jun 2'],
                datasets: [{
                    label: 'Revenue ($)',
                    data: [1500, 2000, 1800, 2200, 2500, 3000, 1750],
                    borderColor: '#e74c3c', // var(--danger-color)
                    backgroundColor: 'rgba(231, 76, 60, 0.1)', // rgba dari var(--danger-color)
                    tension: 0.2,
                    fill: true,
                    pointBackgroundColor: '#e74c3c',
                    pointBorderColor: '#fff',
                    pointHoverRadius: 7,
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: '#e74c3c'
                }]
            };

            // --- Initialize Charts ---
            try {
                const ctxOrderStatus = document.getElementById('orderStatusPieChart');
                if (ctxOrderStatus) {
                    new Chart(ctxOrderStatus.getContext('2d'), {
                        type: 'doughnut',
                        data: orderStatusChartData,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '60%',
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        padding: 15,
                                        usePointStyle: true,
                                        pointStyle: 'circle',
                                        font: {
                                            size: 11
                                        }
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: context => `${context.label}: ${context.formattedValue}`
                                    }
                                }
                            },
                            onHover: (event, chartElement) => {
                                const canvas = event.native ? event.native.target : event.target;
                                if (chartElement.length && orderStatusDetailValue) {
                                    const index = chartElement[0].index;
                                    orderStatusDetailValue.textContent =
                                        `${orderStatusChartData.labels[index]}: ${orderStatusChartData.datasets[0].data[index]}`;
                                    canvas.style.cursor = 'pointer';
                                } else if (orderStatusDetailValue) {
                                    orderStatusDetailValue.textContent =
                                        '- Hover on chart for details -';
                                    canvas.style.cursor = 'default';
                                }
                            }
                        }
                    });
                }

                const ctxDailyRevenue = document.getElementById('dailyRevenueChart');
                if (ctxDailyRevenue) {
                    new Chart(ctxDailyRevenue.getContext('2d'), {
                        type: 'line',
                        data: dailyRevenueData,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: false,
                                    ticks: {
                                        callback: value => '$' + (value / 1000) + 'K'
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: context =>
                                            `Revenue: ${new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD', minimumFractionDigits: 0 }).format(context.parsed.y)}`
                                    }
                                }
                            }
                        }
                    });
                }
            } catch (e) {
                console.error("Error initializing charts:", e);
            }

            // Firebase Prep: Untuk mengisi nilai summary cards di atas (Total Revenue, Total Orders, Active Users)
            // Anda akan mengambil data dari Firestore dan mengupdate elemen HTML yang sesuai.
            // Contoh (ambil dari data statis untuk sekarang):
            // const totalRevenueValueEl = document.getElementById('totalRevenueValue');
            // const totalOrdersValueEl = document.getElementById('totalOrdersValue');
            // const activeUsersValueEl = document.getElementById('activeUsersValue');
            // if(totalRevenueValueEl) totalRevenueValueEl.textContent = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(78500); // Ganti dengan data Firebase
            // if(totalOrdersValueEl) totalOrdersValueEl.textContent = (orderStatusRawData.reduce((sum, item) => sum + item.count, 0)).toLocaleString('en-US'); // Jumlah dari status chart
            // if(activeUsersValueEl) activeUsersValueEl.textContent = '157'; // Ganti dengan data Firebase
        });
    </script>
</body>

</html>
