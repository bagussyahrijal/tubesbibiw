<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B Laundry - Manage Users</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @vite(['resources/css/manage-users.css', 'resources/js/app.js'])
</head>

<body>
    <nav class="navbar">
        <div class="container navbar-container">
            <a href="admin-dashboard.html" class="logo"> <i class="fas fa-tshirt"></i>
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
                <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="{{ route('admin.orders') }}"><i class="fas fa-tasks"></i> Manage Orders</a></li>
                <li><a href="{{ route('admin.users') }}" class="active"><i class="fas fa-users-cog"></i> Manage
                        Users</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="page-header">
                <h1>User Management</h1>
                <a href="#" class="quick-action-btn" id="addNewUserBtnOpenModal"><i class="fas fa-user-plus"></i>
                    Add New User</a>
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
                        @foreach ($users as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td data-label="Name">{{ $user->name }}</td>
                                <td data-label="Email">{{ $user->email }}</td>
                                <td data-label="Phone">{{ $user->phone }}</td>
                                <td data-label="Address">{{ $user->addresses->first()->address ?? '-' }}</td>
                                <td data-label="Joined Date">{{ $user->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <button class="action-btn view-user" data-id="user{{ $user->id }}"
                                        title="View Details"><i class="fas fa-eye"></i></button>
                                    <button class="action-btn edit-user" data-id="user{{ $user->id }}"
                                        title="Edit User"><i class="fas fa-edit"></i></button>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete-user" title="Delete User"
                                            onclick="return confirm('Are you sure you want to delete this user?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
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
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="name-fields">
                        <div class="form-group">
                            <label for="first-name">First Name</label>
                            <input type="text" id="first-name" name="first_name" class="form-control"
                                placeholder="Enter your first name" required>
                        </div>
                        <div class="form-group">
                            <label for="last-name">Last Name</label>
                            <input type="text" id="last-name" name="last_name" class="form-control"
                                placeholder="Enter your last name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control"
                            placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" class="form-control"
                            placeholder="Enter your phone number" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control"
                            placeholder="Create a password" required>
                        <div class="password-strength">
                            <div class="password-strength-bar"></div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-register">Create Account</button>
                </form>
            </div>
        </div>
    </div>
    <div id="editUserModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit User</h2>
                <span class="close-btn" id="closeEditUserModalBtn">&times;</span>
            </div>
            <div class="modal-body">
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit-user-id" name="user_id">
                    <div class="name-fields">
                        <div class="form-group">
                            <label for="edit-first-name">First Name</label>
                            <input type="text" id="edit-first-name" name="first_name" class="form-control"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="edit-last-name">Last Name</label>
                            <input type="text" id="edit-last-name" name="last_name" class="form-control"
                                required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit-email">Email Address</label>
                        <input type="email" id="edit-email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-phone">Phone Number</label>
                        <input type="tel" id="edit-phone" name="phone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-password">Password (leave blank if not changing)</label>
                        <input type="password" id="edit-password" name="password" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </form>
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
            // Modal Edit
            const editUserModal = document.getElementById('editUserModal');
            const closeEditUserModalBtn = document.getElementById('closeEditUserModalBtn');
            const editUserForm = document.getElementById('editUserForm');

            if (closeEditUserModalBtn) {
                closeEditUserModalBtn.addEventListener('click', () => {
                    if (editUserModal) editUserModal.style.display = 'none';
                });
            }
            window.addEventListener('click', (event) => {
                if (event.target === editUserModal) {
                    editUserModal.style.display = 'none';
                }
            });

            if (usersTableBody) {
                usersTableBody.addEventListener('click', function(event) {
                    const targetButton = event.target.closest('button.action-btn');
                    if (!targetButton) return;

                    const userId = targetButton.dataset.id?.replace('user', '');
                    const row = targetButton.closest('tr');

                    if (targetButton.classList.contains('edit-user')) {
                        // Ambil data dari row
                        const name = row.querySelector('td[data-label="Name"]').textContent.trim();
                        const email = row.querySelector('td[data-label="Email"]').textContent.trim();
                        const phone = row.querySelector('td[data-label="Phone"]').textContent.trim();

                        // Pisahkan nama jadi first dan last name (asumsi 2 kata, jika lebih sesuaikan)
                        const nameParts = name.split(' ');
                        const firstName = nameParts.slice(0, -1).join(' ') || nameParts[0];
                        const lastName = nameParts.length > 1 ? nameParts.slice(-1).join(' ') : '';

                        // Isi form edit
                        document.getElementById('edit-user-id').value = userId;
                        document.getElementById('edit-first-name').value = firstName;
                        document.getElementById('edit-last-name').value = lastName;
                        document.getElementById('edit-email').value = email;
                        document.getElementById('edit-phone').value = phone;
                        document.getElementById('edit-password').value = '';

                        // Set action form
                        editUserForm.action = `/admin/users/${userId}`;

                        // Tampilkan modal
                        editUserModal.style.display = 'block';
                    }
                });
            }



            // --- Client-Side Search/Filter Logic ---
            if (userSearchInput && usersTableBody) {
                userSearchInput.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase();
                    const rows = usersTableBody.getElementsByTagName('tr');
                    Array.from(rows).forEach(row => {
                        // Sesuaikan pencarian jika kolom berubah
                        const nameText = row.querySelector('td[data-label="Name"]')?.textContent
                            .toLowerCase() || '';
                        const emailText = row.querySelector('td[data-label="Email"]')?.textContent
                            .toLowerCase() || '';
                        const phoneText = row.querySelector('td[data-label="Phone"]')?.textContent
                            .toLowerCase() || '';

                        if (nameText.includes(searchTerm) || emailText.includes(searchTerm) ||
                            phoneText.includes(searchTerm)) {
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
                        const icon = th.querySelector(
                            'i.fa-sort, i.fa-sort-up, i.fa-sort-down');
                        if (icon) {
                            if (th !== this) {
                                icon.className = 'fas fa-sort';
                            } else {
                                icon.className = direction === 'asc' ? 'fas fa-sort-up' :
                                    'fas fa-sort-down';
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

                    const colIndex = Array.from(rowA.parentElement.parentElement.querySelector('thead tr')
                        .cells).findIndex(th => th.dataset.sort === column);
                    if (colIndex === -1) return 0; // Kolom tidak ditemukan

                    valA = rowA.cells[colIndex]?.textContent.trim().toLowerCase() || '';
                    valB = rowB.cells[colIndex]?.textContent.trim().toLowerCase() || '';

                    if (column === 'id') { // Untuk kolom "No"
                        valA = parseInt(rowA.cells[0].textContent.trim());
                        valB = parseInt(rowB.cells[0].textContent.trim());
                    } else if (column === 'joinedDate') {
                        valA = new Date(valA).getTime();
                        valB = new Date(valB).getTime();
                    } else if (!isNaN(valA) && !isNaN(valB) && valA !== '' && valB !==
                        '') { // Cek jika bisa jadi angka
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


        });
    </script>
</body>

</html>
