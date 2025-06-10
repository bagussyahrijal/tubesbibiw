<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B Laundry - Manage Users</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="manage-users.css"> 
</head>
<body>
    <nav class="navbar">
        <div class="container navbar-container">
            <a href="admin-dashboard.html" class="logo"> <i class="fas fa-tshirt"></i>
                B Laundry
            </a>
            <ul class="nav-links">
                <li><a href="admin-dashboard.html">Dashboard</a></li>
                <li><a href="manage-orders.html">Manage Orders</a></li>
                <li><a href="manage-users.html" class="active">Manage Users</a></li>
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
                <li><a href="manage-orders.html"><i class="fas fa-tasks"></i> Manage Orders</a></li>
                <li><a href="manage-users.html" class="active"><i class="fas fa-users-cog"></i> Manage Users</a></li> 
                <li><a href="#"><i class="fas fa-concierge-bell"></i> Manage Services</a></li>
                <li><a href="#"><i class="fas fa-chart-line"></i> View Reports</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="page-header">
                <h1>User Management</h1>
                <a href="#" class="quick-action-btn" id="addNewUserBtnOpenModal"><i class="fas fa-user-plus"></i> Add New User</a>
            </div>

            <div class="search-filter-bar">
                <input type="text" id="userSearchInput" placeholder="Search by name, email, or phone...">
            </div>

            <div class="data-table-container"> 
                <table>
                    <thead>
                        <tr>
                            <th data-sort="id">No <i class="fas fa-sort"></i></th>
                            <th data-sort="name">Name <i class="fas fa-sort"></i></th>
                            <th data-sort="email">Email <i class="fas fa-sort"></i></th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th data-sort="joinedDate">Joined Date <i class="fas fa-sort"></i></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        <tr>
                            <td>1</td>
                            <td data-label="Name">Sarah Williams</td>
                            <td data-label="Email">sarah.w@example.com</td>
                            <td data-label="Phone">081234567890</td>
                            <td data-label="Address">Sukabirus</td>                                 
                            <td data-label="Joined Date">2024-01-15</td>
                            <td>
                                <button class="action-btn view-user" data-id="user1" title="View Details"><i class="fas fa-eye"></i></button>
                                <button class="action-btn edit-user" data-id="user1" title="Edit User"><i class="fas fa-edit"></i></button>
                                <button class="action-btn delete-user" data-id="user1" title="Delete User"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td data-label="Name">John Doe</td>
                            <td data-label="Email">john.d@example.com</td>
                            <td data-label="Phone">087654321098</td>
                            <td data-label="Address">Sukapura</td>   
                            <td data-label="Joined Date">2024-02-20</td>
                            <td>
                                <button class="action-btn view-user" data-id="user2" title="View Details"><i class="fas fa-eye"></i></button>
                                <button class="action-btn edit-user" data-id="user2" title="Edit User"><i class="fas fa-edit"></i></button>
                                <button class="action-btn delete-user" data-id="user2" title="Delete User"><i class="fas fa-trash-alt"></i></button>
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

    <div id="addUserModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add New User</h2>
                <span class="close-btn" id="closeAddUserModalBtn">&times;</span>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    <div class="form-group">
                        <label for="userName">Name:</label>
                        <input type="text" id="userName" name="userName" required>
                    </div>
                    <div class="form-group">
                        <label for="userEmail">Email:</label>
                        <input type="email" id="userEmail" name="userEmail" required>
                    </div>
                    <div class="form-group">
                        <label for="userPhone">Phone:</label>
                        <input type="tel" id="userPhone" name="userPhone">
                    </div>
                    <div class="form-group">
                        <label for="userAddress">Address:</label>
                        <input type="text" id="userAddress" name="userAddress">
                    </div>
                    <div class="form-group">
                        <label for="userRole">Role:</label>
                        <select id="userRole" name="userRole">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="userPassword">Password:</label>
                        <input type="password" id="userPassword" name="userPassword" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" id="cancelAddUserBtn">Cancel</button>
                <button type="submit" form="addUserForm" class="btn btn-primary">Save User</button>
            </div>
        </div>
    </div>

    <script>
        // JavaScript (Tetap sama seperti sebelumnya)
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Manage Users page loaded with interactions.');

            const addUserModal = document.getElementById('addUserModal');
            const openModalBtn = document.getElementById('addNewUserBtnOpenModal');
            const closeModalBtn = document.getElementById('closeAddUserModalBtn');
            const cancelAddUserBtn = document.getElementById('cancelAddUserBtn');
            const addUserForm = document.getElementById('addUserForm');
            const userSearchInput = document.getElementById('userSearchInput');
            const usersTableBody = document.getElementById('usersTableBody');
            const tableHeaders = document.querySelectorAll('.data-table-container th[data-sort]');

            // --- Modal Logic ---
            if (openModalBtn) {
                openModalBtn.addEventListener('click', () => {
                    if (addUserModal) addUserModal.style.display = 'block';
                });
            }
            if (closeModalBtn) {
                closeModalBtn.addEventListener('click', () => {
                    if (addUserModal) addUserModal.style.display = 'none';
                });
            }
            if (cancelAddUserBtn) {
                cancelAddUserBtn.addEventListener('click', () => {
                    if (addUserModal) addUserModal.style.display = 'none';
                });
            }
            if (addUserModal) {
                window.addEventListener('click', (event) => {
                    if (event.target === addUserModal) {
                        addUserModal.style.display = 'none';
                    }
                });
            }

            if (addUserForm) {
                addUserForm.addEventListener('submit', function(event) {
                    event.preventDefault();
                    const formData = new FormData(this);
                    const userData = {};
                    formData.forEach((value, key) => userData[key] = value);
                    console.log('New User Data:', userData);
                    alert('New user data logged to console. Implement Firebase save logic here.');
                    addUserModal.style.display = 'none';
                    this.reset();
                });
            }

            // --- Client-Side Search/Filter Logic ---
            if (userSearchInput && usersTableBody) {
                userSearchInput.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase();
                    const rows = usersTableBody.getElementsByTagName('tr');
                    Array.from(rows).forEach(row => {
                        // Sesuaikan pencarian jika kolom berubah
                        const nameText = row.querySelector('td[data-label="Name"]')?.textContent.toLowerCase() || '';
                        const emailText = row.querySelector('td[data-label="Email"]')?.textContent.toLowerCase() || '';
                        const phoneText = row.querySelector('td[data-label="Phone"]')?.textContent.toLowerCase() || '';
                        
                        if (nameText.includes(searchTerm) || emailText.includes(searchTerm) || phoneText.includes(searchTerm)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }
            
            // --- Client-Side Sorting Logic ---
            let sortDirections = {}; 

            tableHeaders.forEach(header => {
                header.addEventListener('click', function() {
                    const column = this.dataset.sort;
                    if (!column) return; // Jika tidak ada data-sort, jangan lakukan apa-apa

                    const currentDirection = sortDirections[column] || 'asc';
                    const direction = currentDirection === 'asc' ? 'desc' : 'asc';
                    sortDirections[column] = direction;

                    tableHeaders.forEach(th => {
                        const icon = th.querySelector('i.fa-sort, i.fa-sort-up, i.fa-sort-down');
                        if (icon) {
                            if (th !== this) {
                                icon.className = 'fas fa-sort';
                            } else {
                                icon.className = direction === 'asc' ? 'fas fa-sort-up' : 'fas fa-sort-down';
                            }
                        }
                    });
                    sortTable(column, direction);
                });
            });

            function sortTable(column, direction) {
                const rows = Array.from(usersTableBody.querySelectorAll('tr'));
                const isAsc = direction === 'asc';

                rows.sort((rowA, rowB) => {
                    let valA, valB;
                    
                    const colIndex = Array.from(rowA.parentElement.parentElement.querySelector('thead tr').cells).findIndex(th => th.dataset.sort === column);
                    if (colIndex === -1) return 0; // Kolom tidak ditemukan

                    valA = rowA.cells[colIndex]?.textContent.trim().toLowerCase() || '';
                    valB = rowB.cells[colIndex]?.textContent.trim().toLowerCase() || '';
                    
                    if (column === 'id') { // Untuk kolom "No"
                        valA = parseInt(rowA.cells[0].textContent.trim());
                        valB = parseInt(rowB.cells[0].textContent.trim());
                    } else if (column === 'joinedDate') {
                        valA = new Date(valA).getTime();
                        valB = new Date(valB).getTime();
                    } else if (!isNaN(valA) && !isNaN(valB) && valA !== '' && valB !== '') { // Cek jika bisa jadi angka
                         valA = parseFloat(valA);
                         valB = parseFloat(valB);
                    }
                    
                    if (valA < valB) return isAsc ? -1 : 1;
                    if (valA > valB) return isAsc ? 1 : -1;
                    return 0;
                });

                while (usersTableBody.firstChild) {
                    usersTableBody.removeChild(usersTableBody.firstChild);
                }
                rows.forEach(row => usersTableBody.appendChild(row));
            }
            
            function capitalizeFirstLetter(string) { // Fungsi ini sepertinya tidak digunakan lagi di sorting
                if (!string) return '';
                return string.charAt(0).toUpperCase() + string.slice(1);
            }

            // --- Action Buttons Logic (placeholder) ---
            if (usersTableBody) {
                usersTableBody.addEventListener('click', function(event) {
                    const targetButton = event.target.closest('button.action-btn');
                    if (!targetButton) return;

                    const userId = targetButton.dataset.id;
                    if (!userId) return;

                    if (targetButton.classList.contains('view-user')) {
                        alert(`View user: ${userId}. Implement view details logic.`);
                    } else if (targetButton.classList.contains('edit-user')) {
                        alert(`Edit user: ${userId}. Implement edit form/modal and update logic.`);
                    } else if (targetButton.classList.contains('delete-user')) {
                        if (confirm(`Are you sure you want to delete user ${userId}?`)) {
                            alert(`Delete user: ${userId}. Implement delete logic.`);
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>