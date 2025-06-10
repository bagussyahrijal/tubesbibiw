<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B Laundry - Manage Orders</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="manage-orders.css"> 
</head>
<body>
    <nav class="navbar">
        <div class="container navbar-container">
            <a href="admin-dashboard.html" class="logo"> <i class="fas fa-tshirt"></i>
                B Laundry
            </a>
            <ul class="nav-links">
                <li><a href="admin-dashboard.html">Dashboard</a></li>
                <li><a href="manage-orders.html" class="active">Manage Orders</a></li> 
                <li><a href="manage-users.html">Manage Users</a></li>
                <li><a href="#">Services</a></li>
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
                <li><a href="admin-dashboard.html"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="manage-orders.html" class="active"><i class="fas fa-tasks"></i> Manage Orders</a></li> 
                <li><a href="manage-users.html"><i class="fas fa-users-cog"></i> Manage Users</a></li> 
                <li><a href="#"><i class="fas fa-concierge-bell"></i> Manage Services</a></li>
                <li><a href="#"><i class="fas fa-chart-line"></i> View Reports</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="page-header">
                <h1>Order Management</h1>
                <button class="quick-action-btn" id="createNewOrderBtn"><i class="fas fa-plus-circle"></i> Create New Order</button>
            </div>

            <div class="search-filter-bar orders-filter-bar"> 
                <div class="filter-item search-item"> 
                    <label for="orderSearchInput">Search:</label>
                    <input type="text" id="orderSearchInput" class="search-input" placeholder="Search by Order ID, Customer Name/Email...">
                </div>
                <div class="filter-item">
                    <label for="orderStatusFilter">Status:</label>
                    <select id="orderStatusFilter" class="filter-select">
                        <option value="">All</option>
                        <option value="Unpaid">Unpaid</option>
                        <option value="Pending">Pending</option>
                        <option value="Processing">Processing</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="filter-item">
                    <label for="dateStartFilter">From:</label>
                    <input type="date" id="dateStartFilter" class="filter-date">
                </div>
                <div class="filter-item">
                    <label for="dateEndFilter">To:</label>
                    <input type="date" id="dateEndFilter" class="filter-date">
                </div>
                <div class="filter-item button-item"> 
                    <button class="btn btn-outline btn-filter-apply" id="applyOrderFilters">Apply Filters</button>
                </div>
            </div>

            <div class="data-table-container"> 
                <table>
            <thead>
                <tr>
                    <th data-sort="orderId">Order ID <i class="fas fa-sort"></i></th>
                    <th data-sort="customer">Customer <i class="fas fa-sort"></i></th>
                    <th data-sort="orderDate">Order Date <i class="fas fa-sort"></i></th>
                    <th data-sort="serviceType">Service Type <i class="fas fa-sort"></i></th>
                    <th data-sort="items">Items <i class="fas fa-sort"></i></th>
                    <th data-sort="quantity">Quantity <i class="fas fa-sort"></i></th>
                    <th data-sort="total">Total <i class="fas fa-sort"></i></th>
                    <th data-sort="status">Status <i class="fas fa-sort"></i></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="ordersTableBody">
                <tr>
                    <td data-label="Order ID">#LC-78945</td>
                    <td data-label="Customer">Sarah W. <br><small>sarah.w@example.com</small></td>
                    <td data-label="Order Date">2025-06-03</td>
                    <td data-label="Service Type">Wash & Fold</td>
                    <td data-label="Items">Shirt</td>
                    <td data-label="Quantity">3</td>
                    <td data-label="Total">$18.50</td>
                    <td data-label="Status"><span class="status unpaid">Unpaid</span></td>
                    <td>
                        <button class="action-btn view-order" data-id="LC-78945" title="View Details"><i class="fas fa-eye"></i></button>
                        <button class="action-btn edit-order-status" data-id="LC-78945" title="Update Status"><i class="fas fa-edit"></i></button>
                        <button class="action-btn cancel-order" data-id="LC-78945" title="Cancel Order"><i class="fas fa-times-circle"></i></button>
                    </td>
                </tr>
                <tr>
                    <td data-label="Order ID">#LC-78944</td>
                    <td data-label="Customer">John D. <br><small>john.d@example.com</small></td>
                    <td data-label="Order Date">2025-06-02</td>
                    <td data-label="Service Type">Dry Cleaning</td>
                    <td data-label="Items">Jacket</td>
                    <td data-label="Quantity">1</td>
                    <td data-label="Total">$32.75</td>
                    <td data-label="Status"><span class="status pending">Pending</span></td>
                    <td>
                        <button class="action-btn view-order" data-id="LC-78944" title="View Details"><i class="fas fa-eye"></i></button>
                        <button class="action-btn edit-order-status" data-id="LC-78944" title="Update Status"><i class="fas fa-edit"></i></button>
                        <button class="action-btn cancel-order" data-id="LC-78944" title="Cancel Order"><i class="fas fa-times-circle"></i></button>
                    </td>
                </tr>
                <tr>
                    <td data-label="Order ID">#LC-78932</td>
                    <td data-label="Customer">Alice B. <br><small>alice.b@example.com</small></td>
                    <td data-label="Order Date">2025-06-01</td>
                    <td data-label="Service Type">Premium Wash</td>
                    <td data-label="Items">Dress</td>
                    <td data-label="Quantity">2</td>
                    <td data-label="Total">$45.20</td>
                    <td data-label="Status"><span class="status processing">Processing</span></td>
                    <td>
                        <button class="action-btn view-order" data-id="LC-78932" title="View Details"><i class="fas fa-eye"></i></button>
                        <button class="action-btn edit-order-status" data-id="LC-78932" title="Update Status"><i class="fas fa-edit"></i></button>
                        <button class="action-btn cancel-order" data-id="LC-78932" title="Cancel Order"><i class="fas fa-times-circle"></i></button>
                    </td>
                </tr>
                <tr>
                    <td data-label="Order ID">#LC-78930</td>
                    <td data-label="Customer">Mike R. <br><small>mike.r@example.com</small></td>
                    <td data-label="Order Date">2025-05-30</td>
                    <td data-label="Service Type">Bedding Set Cleaning</td>
                    <td data-label="Items">Bedding Set</td>
                    <td data-label="Quantity">1</td>
                    <td data-label="Total">$25.00</td>
                    <td data-label="Status"><span class="status completed">Completed</span></td>
                    <td>
                        <button class="action-btn view-order" data-id="LC-78930" title="View Details"><i class="fas fa-eye"></i></button>
                        <button class="action-btn edit-order-status" data-id="LC-78930" title="Update Status"><i class="fas fa-edit"></i></button>
                        <button class="action-btn cancel-order" data-id="LC-78930" title="Cancel Order"><i class="fas fa-times-circle"></i></button>
                    </td>
                </tr>
            </tbody>
                </table>
            </div>
            <div class="pagination">
                 <a href="#">&laquo; Prev</a>
                 <a href="#" class="active">1</a>
                 <a href="#">2</a>
                 <a href="#">Next &raquo;</a>
            </div>
        </main>
    </div>

    <div id="orderDetailsModal" class="modal">
        <div class="modal-content large">
            <div class="modal-header">
                <h2 id="modalOrderTitle">Order Details: <span>#ORDER_ID_HERE</span></h2>
                <span class="close-btn" id="closeOrderDetailsModalBtn">&times;</span>
            </div>
            <div class="modal-body" id="modalOrderBodyContent">
                <div class="order-detail-grid">
                    <div class="detail-item"><strong>Customer:</strong> <span id="modalCustomerName">N/A</span></div>
                    <div class="detail-item"><strong>Email:</strong> <span id="modalCustomerEmail">N/A</span></div>
                    <div class="detail-item"><strong>Phone:</strong> <span id="modalCustomerPhone">N/A</span></div>
                    <div class="detail-item"><strong>Address:</strong> <span id="modalCustomerAddress">N/A</span></div>
                    <div class="detail-item"><strong>Order Date:</strong> <span id="modalOrderDate">N/A</span></div>
                    <div class="detail-item"><strong>Service Type:</strong> <span id="modalOrderService">N/A</span></div>
                    <div class="detail-item full-width"><strong>Items:</strong> <span id="modalOrderItems">N/A</span></div>
                    <div class="detail-item"><strong>Pickup Date:</strong> <span id="modalPickupDate">N/A</span></div>
                    <div class="detail-item"><strong>Delivery Date:</strong> <span id="modalDeliveryDate">N/A</span></div>
                    <div class="detail-item"><strong>Total Amount:</strong> <span id="modalOrderTotal">N/A</span></div>
                    <div class="detail-item"><strong>Payment Method:</strong> <span id="modalPaymentMethod">N/A</span></div>
                </div>
                <hr class="modal-divider">
                <div class="form-group">
                    <label for="modalOrderStatus">Update Status:</label>
                    <select id="modalOrderStatus" name="orderStatus">
                        <option value="Unpaid">Unpaid</option>
                        <option value="Pending">Pending</option>
                        <option value="Processing">Processing</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="modalOrderNotes">Admin Notes:</label>
                    <textarea id="modalOrderNotes" name="orderNotes" rows="3" placeholder="Add notes for this order..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" id="cancelOrderDetailsBtn">Close</button>
                <button type="button" class="btn btn-primary" id="saveOrderStatusBtn">Save Status</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Manage Orders page loaded.');

            // --- Modal Detail Pesanan Logic ---
            const orderDetailsModal = document.getElementById('orderDetailsModal');
            const closeOrderDetailsModalBtn = document.getElementById('closeOrderDetailsModalBtn');
            const cancelOrderDetailsBtn = document.getElementById('cancelOrderDetailsBtn');
            const ordersTableBody = document.getElementById('ordersTableBody');
            const saveOrderStatusBtn = document.getElementById('saveOrderStatusBtn');
            let currentEditingOrderId = null;

            if (closeOrderDetailsModalBtn) {
                closeOrderDetailsModalBtn.addEventListener('click', () => {
                    if (orderDetailsModal) orderDetailsModal.style.display = 'none';
                });
            }
            if (cancelOrderDetailsBtn) {
                cancelOrderDetailsBtn.addEventListener('click', () => {
                    if (orderDetailsModal) orderDetailsModal.style.display = 'none';
                });
            }
            if (orderDetailsModal) {
                window.addEventListener('click', (event) => {
                    if (event.target === orderDetailsModal) {
                        orderDetailsModal.style.display = 'none';
                    }
                });
            }

            if (ordersTableBody) {
                ordersTableBody.addEventListener('click', function(event) {
                    const targetButton = event.target.closest('button.action-btn');
                    if (!targetButton) return;

                    const orderId = targetButton.dataset.id;
                    if (!orderId) return;
                    currentEditingOrderId = orderId; // Simpan ID pesanan yang sedang diedit

                    if (targetButton.classList.contains('view-order') || targetButton.classList.contains('edit-order-status')) {
                        // // const orderRef = doc(db, "orders", orderId);
                        // getDoc(orderRef).then(async (docSnap) => {
                        //   if (docSnap.exists()) {
                        //     const orderData = docSnap.data();
                        //     // Fetch user details based on orderData.userId
                        //     const userRef = doc(db, "users", orderData.userId);
                        //     const userSnap = await getDoc(userRef);
                        //     const userData = userSnap.exists() ? userSnap.data() : {};
                        //
                        //     document.getElementById('modalOrderTitle').querySelector('span').textContent = orderId;
                        //     document.getElementById('modalCustomerName').textContent = userData.name || 'N/A';
                        //     document.getElementById('modalCustomerEmail').textContent = userData.email || 'N/A';
                        //     document.getElementById('modalCustomerPhone').textContent = userData.phone || 'N/A';
                        //     document.getElementById('modalCustomerAddress').textContent = userData.address || orderData.deliveryAddress || 'N/A'; // Ambil dari order jika ada
                        //     document.getElementById('modalOrderDate').textContent = orderData.orderDate ? new Date(orderData.orderDate.seconds * 1000).toLocaleString() : 'N/A';
                        //     document.getElementById('modalOrderService').textContent = orderData.serviceType || 'N/A';
                        //     document.getElementById('modalOrderItems').textContent = orderData.itemsSummary || 'Details not available';
                        //     document.getElementById('modalPickupDate').textContent = orderData.pickupDate ? new Date(orderData.pickupDate.seconds * 1000).toLocaleString() : 'N/A';
                        //     document.getElementById('modalDeliveryDate').textContent = orderData.deliveryDate ? new Date(orderData.deliveryDate.seconds * 1000).toLocaleString() : 'N/A';
                        //     document.getElementById('modalOrderTotal').textContent = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(orderData.totalCost || 0);
                        //     document.getElementById('modalPaymentMethod').textContent = orderData.paymentMethod || 'N/A';
                        //     document.getElementById('modalOrderStatus').value = orderData.status || 'Pending';
                        //     document.getElementById('modalOrderNotes').value = orderData.adminNotes || '';
                        //     orderDetailsModal.style.display = 'block';
                        //   } else {
                        //     alert("Order details not found!");
                        //   }
                        // });
                        // Contoh statis untuk sekarang:
                        document.getElementById('modalOrderTitle').querySelector('span').textContent = orderId;
                        document.getElementById('modalCustomerName').textContent = (orderId === 'LC-78945' ? 'Sarah Williams' : 'John Doe');
                        document.getElementById('modalCustomerEmail').textContent = (orderId === 'LC-78945' ? 'sarah.w@example.com' : 'john.d@example.com');
                        document.getElementById('modalCustomerPhone').textContent = (orderId === 'LC-78945' ? '08123...' : '08765...');
                        document.getElementById('modalCustomerAddress').textContent = 'Jl. Laundry No. 123';
                        document.getElementById('modalOrderDate').textContent = 'June 3, 2025, 10:00 AM';
                        document.getElementById('modalOrderService').textContent = 'Wash & Fold';
                        document.getElementById('modalOrderItems').textContent = '3 Shirts, 2 Pants, 1 Bedding Set';
                        document.getElementById('modalPickupDate').textContent = 'June 3, 2025, 11:00 AM';
                        document.getElementById('modalDeliveryDate').textContent = 'June 5, 2025, 02:00 PM';
                        document.getElementById('modalOrderTotal').textContent = '$' + (Math.random() * 50).toFixed(2);
                        document.getElementById('modalPaymentMethod').textContent = 'Cash on Delivery';
                        document.getElementById('modalOrderStatus').value = 'Pending'; // Ambil status aktual
                        document.getElementById('modalOrderNotes').value = ''; // Ambil catatan aktual

                        if (orderDetailsModal) orderDetailsModal.style.display = 'block';

                    } else if (targetButton.classList.contains('cancel-order')) {
                        if (confirm(`Are you sure you want to cancel order ${orderId}? This action cannot be undone.`)) {
                            // // updateDoc(doc(db, "orders", orderId), { status: 'Cancelled' });
                            alert(`Order ${orderId} cancelled. Implement Firebase update.`);
                            // Optionally, update UI immediately or rely on real-time listener
                            targetButton.closest('tr').querySelector('.status').className = 'status cancelled';
                            targetButton.closest('tr').querySelector('.status').textContent = 'Cancelled';
                        }
                    }
                });
            }

            if (saveOrderStatusBtn) {
                saveOrderStatusBtn.addEventListener('click', function() {
                    if (!currentEditingOrderId) return;
                    const newStatus = document.getElementById('modalOrderStatus').value;
                    const adminNotes = document.getElementById('modalOrderNotes').value;
                    // // updateDoc(doc(db, "orders", currentEditingOrderId), { status: newStatus, adminNotes: adminNotes, lastUpdated: serverTimestamp() });
                    alert(`Order ${currentEditingOrderId} status updated to ${newStatus} with notes: "${adminNotes}". Implement Firebase update.`);
                    if (orderDetailsModal) orderDetailsModal.style.display = 'none';
                    // Optionally, update UI immediately or rely on real-time listener
                    // (misalnya, cari baris dengan data-id dan update status span-nya)
                    const rowToUpdate = Array.from(ordersTableBody.querySelectorAll('tr')).find(row => row.querySelector(`button[data-id="${currentEditingOrderId}"]`));
                    if (rowToUpdate) {
                        rowToUpdate.querySelector('.status').className = `status ${newStatus.toLowerCase().replace(/\s+/g, '-')}`;
                        rowToUpdate.querySelector('.status').textContent = newStatus;
                    }

                });
            }
            
            // --- Client-Side Search, Filter, Sorting Logic (placeholder) ---
            // Anda bisa mengadaptasi logika search dan sort dari manage-users.html ke sini,
            // dengan penyesuaian untuk kolom-kolom pesanan.
            // Filter berdasarkan status dan tanggal akan memerlukan logika tambahan.
            console.log("Implement client-side search, filter, and sorting for orders here.");

        });
    </script>
</body>
</html>