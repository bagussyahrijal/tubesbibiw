<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B Laundry - Manage Orders</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @vite(['resources/css/manage-orders.css', 'resources/js/app.js'])
</head>

<body>
    <nav class="navbar">
        <div class="container navbar-container">
            <a href="{{ route('admin.dashboard') }}" class="logo"> <i class="fas fa-tshirt"></i>
                B Laundry
            </a>
            <ul class="nav-links">
                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('admin.orders') }}" class="active">Manage Orders</a></li>
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
                <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="{{ route('admin.orders') }}" class="active"><i class="fas fa-tasks"></i> Manage Orders</a>
                </li>
                <li><a href="{{ route('admin.users') }}"><i class="fas fa-users-cog"></i> Manage Users</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="page-header">
                <h1>Order Management</h1>
            </div>

            <div class="search-filter-bar orders-filter-bar">
                <form action="{{ route('admin.orders') }}" method="GET" class="filter-form">
                    <div class="filter-item search-item">
                        <label for="orderSearchInput">Search:</label>
                        <input type="text" name="search" id="orderSearchInput" class="search-input"
                            placeholder="Search by Order ID, Customer Name/Email..."
                            value="{{ $searchQuery ?? '' }}"> {{-- Mempertahankan nilai input --}}
                    </div>
                    <div class="filter-item">
                        <label for="orderStatusFilter">Status:</label>
                        <select name="status" id="orderStatusFilter" class="filter-select">
                            <option value="" {{ ($statusFilter ?? '') == '' ? 'selected' : '' }}>All</option>
                            <option value="Payment" {{ ($statusFilter ?? '') == 'Payment' ? 'selected' : '' }}>Payment</option>
                            <option value="Pending to Process" {{ ($statusFilter ?? '') == 'Pending to Process' ? 'selected' : '' }}>Pending to Process</option>
                            <option value="Processed" {{ ($statusFilter ?? '') == 'Processed' ? 'selected' : '' }}>Processed</option>
                            <option value="Finished" {{ ($statusFilter ?? '') == 'Finished' ? 'selected' : '' }}>Finished</option>
                            {{-- Pastikan nilai option sesuai dengan yang ada di Firestore, atau mapping di controller --}}
                        </select>
                    </div>
                    <div class="filter-item">
                        <label for="dateStartFilter">From:</label>
                        <input type="date" name="date_start" id="dateStartFilter" class="filter-date"
                            value="{{ $dateStartFilter ?? '' }}"> {{-- Mempertahankan nilai input --}}
                    </div>
                    <div class="filter-item">
                        <label for="dateEndFilter">To:</label>
                        <input type="date" name="date_end" id="dateEndFilter" class="filter-date"
                            value="{{ $dateEndFilter ?? '' }}"> {{-- Mempertahankan nilai input --}}
                    </div>
                    <div class="filter-item button-item">
                        <button type="submit" class="btn btn-outline btn-filter-apply" id="applyOrderFilters">Apply Filters</button>
                        {{-- Tombol Reset Filters --}}
                        @if ($searchQuery || $statusFilter || $dateStartFilter || $dateEndFilter)
                            <a href="{{ route('admin.orders') }}" class="btn btn-outline">Reset Filters</a>
                        @endif
                    </div>
                </form>
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
                            <th>Payment Method</th> {{-- Anda menambahkan ini di controller sebelumnya --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentOrders as $order)
                            <tr>
                                <td>{{ $order['customerName'] ?? '-' }}</td>
                                <td>{{ $order['phone'] ?? '-' }}</td>
                                <td>{{ $order['address'] ?? '-' }}</td>
                                <td>{{ $order['item'] ?? '-' }}</td>
                                <td>Rp{{ number_format($order['totalCost'] ?? 0, 0, ',', '.') }}</td>
                                <td>
                                    <form action="{{ route('orders.updateStatus', $order['id']) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()">
                                            <option value="Payment" {{ ($order['status'] ?? '') == 'Payment' ? 'selected' : '' }}>Payment</option>
                                            <option value="Pending to Process" {{ ($order['status'] ?? '') == 'Pending to Process' ? 'selected' : '' }}>Pending to Process</option>
                                            <option value="Processed" {{ ($order['status'] ?? '') == 'Processed' ? 'selected' : '' }}>Processed</option>
                                            <option value="Finished" {{ ($order['status'] ?? '') == 'Finished' ? 'selected' : '' }}>Finished</option>
                                        </select>
                                    </form>
                                </td>
                                <td>{{ $order['paymentMethod'] ?? '-' }}</td> {{-- Tampilkan Payment Method --}}
                                <td>
                                    <button class="action-btn view-order"
                                        data-customer="{{ $order['customerName'] ?? '-' }}"
                                        data-phone="{{ $order['phone'] ?? '-' }}"
                                        data-address="{{ $order['address'] ?? '-' }}"
                                        data-item="{{ $order['item'] ?? '-' }}"
                                        data-totalcost="{{ $order['totalCost'] ?? 0 }}"
                                        data-status="{{ $order['status'] ?? '-' }}"
                                        data-createdat="{{ $order['createdAt'] ?? '-' }}" {{-- Sesuaikan jika formatnya sudah string --}}
                                        data-servicetype="{{ $order['serviceType'] ?? '-' }}"
                                        data-paymentmethod="{{ $order['paymentMethod'] ?? '-' }}"
                                        data-quantity="{{ $order['quantity'] ?? '-' }}"
                                        data-material="{{ $order['material'] ?? '-' }}"
                                        title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="text-align: center;">Tidak ada order ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- <div class="pagination">
                <a href="#">&laquo; Prev</a>
                <a href="#" class="active">1</a>
                <a href="#">2</a>
                <a href="#">Next &raquo;</a>
            </div> --}}
        </main>
    </div>

    <div id="orderDetailsModal" class="modal">
        <div class="modal-content large">
            <div class="modal-header">
                <h2 id="modalOrderTitle">Order Details: <span>#</span></h2> {{-- Hapus nilai statis dari span --}}
                <span class="close-btn" id="closeOrderDetailsModalBtn">&times;</span>
            </div>
            <div class="modal-body" id="modalOrderBodyContent">
                <div class="order-detail-grid">
                    <div class="detail-item"><strong>Nama Pelanggan:</strong> <span id="modalCustomerName"></span></div>
                    <div class="detail-item"><strong>Nomor Telepon:</strong> <span id="modalCustomerPhone"></span></div>
                    <div class="detail-item"><strong>Alamat:</strong> <span id="modalCustomerAddress"></span></div>
                    <div class="detail-item"><strong>Item:</strong> <span id="modalItem"></span></div>
                    <div class="detail-item"><strong>Total Cost:</strong> <span id="modalTotalCost"></span></div>
                    <div class="detail-item"><strong>Status Order:</strong> <span id="modalStatus"></span></div>
                    <div class="detail-item"><strong>Tanggal Pembuatan:</strong> <span id="modalCreatedAt"></span></div>
                    <div class="detail-item"><strong>Service Type:</strong> <span id="modalServiceType"></span></div>
                    <div class="detail-item"><strong>Payment Method:</strong> <span id="modalPaymentMethod"></span></div>
                    <div class="detail-item"><strong>Quantity:</strong> <span id="modalQuantity"></span></div>
                    <div class="detail-item"><strong>Material:</strong> <span id="modalMaterial"></span></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" id="cancelOrderDetailsBtn">Close</button>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.view-order').forEach(btn => {
            btn.addEventListener('click', function() {
                // Isi modal dengan data dari tombol
                document.getElementById('modalOrderTitle').querySelector('span').textContent = '#' + (btn.dataset.id || '-');
                document.getElementById('modalCustomerName').textContent = btn.dataset.customer || '-';
                document.getElementById('modalCustomerPhone').textContent = btn.dataset.phone || '-';
                document.getElementById('modalCustomerAddress').textContent = btn.dataset.address || '-';
                document.getElementById('modalItem').textContent = btn.dataset.item || '-';
                document.getElementById('modalTotalCost').textContent = 'Rp' + Number(btn.dataset.totalcost || 0).toLocaleString('id-ID');
                document.getElementById('modalStatus').textContent = btn.dataset.status || '-';
                document.getElementById('modalCreatedAt').textContent = btn.dataset.createdat || '-';
                document.getElementById('modalServiceType').textContent = btn.dataset.servicetype || '-';
                document.getElementById('modalPaymentMethod').textContent = btn.dataset.paymentmethod || '-';
                document.getElementById('modalQuantity').textContent = btn.dataset.quantity || '-';
                document.getElementById('modalMaterial').textContent = btn.dataset.material || '-';

                // Tampilkan modal
                document.getElementById('orderDetailsModal').style.display = 'block';
            });
        });

        // Tombol close
        document.getElementById('closeOrderDetailsModalBtn').onclick =
            document.getElementById('cancelOrderDetailsBtn').onclick = function() {
                document.getElementById('orderDetailsModal').style.display = 'none';
            };

        // Tutup modal jika klik di luar modal-content
        window.onclick = function(event) {
            const modal = document.getElementById('orderDetailsModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        };
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
